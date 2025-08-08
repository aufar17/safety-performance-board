<?php

namespace App\Services;

use App\Models\Accident;
use App\Models\AgcLevel;
use App\Models\AgcLevelHistory;
use App\Models\Incident;
use App\Models\Pica;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MonitoringService
{
    public function monitoring()
    {
        $user = Auth::user();
        $now = Carbon::now()->format('d F Y');
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('F');

        $accidents = Accident::get();
        $mappings = $this->mappings($year);
        $months = $this->months();
        $accumulativeAccident = $this->accumulativeAccident($year);
        $calender = $this->calendar();
        $agc = $this->agc();

        return compact(
            'user',
            'now',
            'year',
            'month',
            'accidents',
            'mappings',
            'months',
            'accumulativeAccident',
            'agc',
            'calender',
        );
    }

    public function mappings($year)
    {
        $accidents = Accident::with([
            'incidents' => function ($query) use ($year) {
                $query->whereYear('date', $year)->with('category');
            }
        ])->get();

        $mappingIcon = [
            1 => 'fa-solid fa-person-burst',
            2 => 'fa-solid fa-fire',
            3 => 'fa-solid fa-car-burst',
        ];

        $mappings = [];

        foreach ($accidents as $accident) {
            $incidents = $accident->incidents;
            $total = $incidents->count();

            $categories = $incidents
                ->filter(fn($incident) => $incident->category)
                ->groupBy(fn($incident) => $incident->category->category)
                ->map(fn($group) => $group->count());

            $icon = $mappingIcon[$accident->id] ?? 'fa-solid fa-triangle-exclamation';

            $mappings[] = [
                'accident' => $accident->accident,
                'total' => $total,
                'categories' => $categories,
                'icon' => $icon,
            ];
        }

        return $mappings;
    }

    public function months()
    {
        $months = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = Carbon::create()->month($i)->translatedFormat('M');
        }

        return $months;
    }

    public function accumulativeAccident($year)
    {
        $currentMonth = now()->month;

        $colorMap = [
            1 => '#113F67',
            2 => '#FF3F33',
            3 => '#FFCE56',
        ];

        $accidents = Accident::with(['incidents' => function ($query) use ($year, $currentMonth) {
            $query->whereYear('date', $year)
                ->whereMonth('date', '<=', $currentMonth);
        }])->get();

        $results = [];

        foreach ($accidents as $accident) {
            $monthlyCounts = $accident->incidents
                ->groupBy(fn($incident) => Carbon::parse($incident->date)->month)
                ->map(fn($group) => $group->count())
                ->toArray();

            $runningTotal = 0;
            $accumulated = [];

            for ($i = 1; $i <= $currentMonth; $i++) {
                $runningTotal += $monthlyCounts[$i] ?? 0;
                $accumulated[] = $runningTotal;
            }

            $results[$accident->accident] = [
                'data' => $accumulated,
                'color' => $colorMap[$accident->id] ?? '#000000',
            ];
        }

        return $results;
    }

    public function calendar(): array
    {
        $carbon = Carbon::now()->locale('id');
        $bulan = $carbon->translatedFormat('F Y');

        $picaList = Pica::all();

        $incidentList = Incident::with(['accident', 'category'])
            ->whereMonth('date', $carbon->month)
            ->whereYear('date', $carbon->year)
            ->get();

        $incidents = $incidentList->groupBy(fn($incident) => Carbon::parse($incident->date)->day);

        $hariDalamBulan = $carbon->daysInMonth;
        $tanggalList = [];

        for ($i = 1; $i <= $hariDalamBulan; $i++) {
            $tanggal = Carbon::createFromDate($carbon->year, $carbon->month, $i);
            $tanggalKey = $i;

            $incidentHariIni = $incidents->get($tanggalKey, collect());

            $bgClass = null;
            if ($incidentHariIni->contains(fn($incident) => $incident->category_id === 4)) {
                $bgClass = 'red';
            } elseif ($incidentHariIni->isNotEmpty()) {
                $bgClass = 'yellow';
            } else {
                $bgClass = '#06923E';
            }

            $categoryBadge = [];

            if ($incidentHariIni->isNotEmpty()) {
                $kategoriUnik = $incidentHariIni->pluck('accident_id')->unique();

                foreach ($kategoriUnik as $id) {
                    $badge = match ($id) {
                        1 => ['icon' => 'fa-solid fa-notes-medical', 'color' => 'text-success'],
                        2 => ['icon' => 'fa-solid fa-fire', 'color' => 'text-danger'],
                        3 => ['icon' => 'fa-solid fa-triangle-exclamation', 'color' => 'text-warning'],
                        default => null,
                    };

                    if ($badge) {
                        $categoryBadge[] = $badge;
                    }
                }
            }

            $matchingPica = $picaList->first(function ($pica) use ($tanggal) {
                $start = Carbon::parse($pica->date_start)->startOfDay();
                $end = Carbon::parse($pica->date_end)->endOfDay();

                return $tanggal->between($start, $end, true);
            });

            $tanggalList[] = [
                'tanggal' => $tanggal->format('Y-m-d'),
                'label' => $tanggal->format('j'),
                'hari' => $tanggal->translatedFormat('l'),
                'status' => $tanggal->isToday() ? 'today' : ($tanggal->isPast() ? 'past' : 'future'),
                'bg' => $bgClass,
                'categoryBadge' => $categoryBadge,
                'pica' => $matchingPica?->id
            ];
        }

        $offsetHariPertama = Carbon::createFromDate($carbon->year, $carbon->month, 1)->dayOfWeekIso;

        $days = collect(range(1, 7))->map(function ($i) {
            return Carbon::create()->startOfWeek()->addDays($i - 1)->locale('id')->translatedFormat('l');
        });

        return [
            'incidents' => $incidents,
            'bulan' => $bulan,
            'tanggalList' => $tanggalList,
            'offsetHariPertama' => $offsetHariPertama,
            'days' => $days,
        ];
    }

    public function agc()
    {
        $now = Carbon::now()->format('m');

        $agc = AgcLevelHistory::with('agc')
            ->whereMonth('date', $now)
            ->latest('id')
            ->first();

        $latestLwd = Incident::where('category_id', 3)
            ->latest('date')
            ->first();

        $sinceLwd = $latestLwd
            ? floor(Carbon::parse($latestLwd->date)->floatDiffInDays(Carbon::now()))
            : null;

        if ($sinceLwd < 0) {
            $sinceLwd = 0;
        }

        return [
            'agc' => $agc,
            'sinceLwd' => $sinceLwd,
        ];
    }
}
