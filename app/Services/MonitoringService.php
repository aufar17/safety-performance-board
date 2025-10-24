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
        $mappings = $this->mappings($year) ?? collect();
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
        $isActiveAll = session('isActiveAll', false);
        $activeAccidents = collect(session('activeAccidents', []))->map(fn($v) => (int) $v)->unique()->values()->toArray();
        $manuallyDisabled = collect(session('manuallyDisabled', []))->map(fn($v) => (int) $v)->unique()->values()->toArray();

        $accidents = Accident::all();

        $query = Incident::with(['accident', 'category'])->whereYear('date', $year);

        if ($isActiveAll) {
            // Tampilkan semua, kecuali yang dinonaktifkan manual
            if (!empty($manuallyDisabled)) {
                $query->whereNotIn('id', $manuallyDisabled);
            }
        } else {
            // Tampilkan hanya yang aktif
            if (!empty($activeAccidents)) {
                $query->whereIn('id', $activeAccidents);
            } else {
                $incidents = collect();
            }
        }

        $incidents = $incidents ?? $query->get();

        $groupedByAccident = $incidents->groupBy('accident_id');

        $mappingIcon = [
            1 => 'fa-solid fa-person-burst',
            2 => 'fa-solid fa-fire',
            3 => 'fa-solid fa-car-burst',
        ];

        $mappings = [];

        foreach ($accidents as $accident) {
            $accIncidents = $groupedByAccident->get($accident->id, collect());

            $categories = [
                'First Aid' => 0,
                'Non LWD'   => 0,
                'LWD'       => 0,
                'Fatal'     => 0,
            ];

            if ($accIncidents->isNotEmpty()) {
                $groupedCategories = $accIncidents->filter(fn($incident) => $incident->category)
                    ->groupBy(fn($incident) => $incident->category->category)
                    ->map(fn($group) => $group->count());

                foreach ($groupedCategories as $key => $value) {
                    $categories[$key] = $value;
                }
            }

            $mappings[] = [
                'accident'   => $accident->accident,
                'total'      => $accIncidents->count(),
                'categories' => $categories,
                'icon'       => $mappingIcon[$accident->id] ?? 'fa-solid fa-triangle-exclamation',
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
        $isActiveAll = session('isActiveAll', false);
        $activeAccidents = collect(session('activeAccidents', []))->map(fn($v) => (int) $v)->unique()->values()->toArray();
        $manuallyDisabled = collect(session('manuallyDisabled', []))->map(fn($v) => (int) $v)->unique()->values()->toArray();

        $currentMonth = now()->month;

        $colorMap = [
            1 => '#113F67',
            2 => '#FF3F33',
            3 => '#FFCE56',
        ];

        $accidents = Accident::all();

        $query = Incident::whereYear('date', $year)
            ->whereMonth('date', '<=', $currentMonth);

        if ($isActiveAll) {
            if (!empty($manuallyDisabled)) {
                $query->whereNotIn('id', $manuallyDisabled);
            }
        } else {
            if (!empty($activeAccidents)) {
                $query->whereIn('id', $activeAccidents);
            } else {
                $incidents = collect();
            }
        }

        $incidents = $incidents ?? $query->get();

        $groupedByAccident = $incidents->groupBy('accident_id');

        $tableData = [];
        $chartData = [];

        foreach ($accidents as $accident) {
            $accIncidents = $groupedByAccident->get($accident->id, collect());

            $monthlyCounts = $accIncidents
                ->groupBy(fn($incident) => Carbon::parse($incident->date)->month)
                ->map(fn($group) => $group->count())
                ->toArray();

            $tableData[$accident->accident] = [
                'data' => array_map(fn($i) => $monthlyCounts[$i] ?? 0, range(1, $currentMonth)),
            ];
            $runningTotal = 0;
            $accumulated = [];
            for ($i = 1; $i <= $currentMonth; $i++) {
                $runningTotal += $monthlyCounts[$i] ?? 0;
                $accumulated[] = $runningTotal;
            }
            $chartData[$accident->accident] = [
                'data' => $accumulated,
                'color' => $colorMap[$accident->id] ?? '#000000',
            ];
        }

        return [
            'tableData' => $tableData,
            'chartData' => $chartData,
        ];
    }




    public function calendar(): array
    {
        $carbon = Carbon::now()->locale('id');
        $bulan = $carbon->translatedFormat('F Y');
        $hariDalamBulan = $carbon->daysInMonth;

        $isActiveAll = session('isActiveAll', false);
        $activeAccidents = collect(session('activeAccidents', []))
            ->map(fn($v) => (int) $v)
            ->unique()
            ->values()
            ->toArray();

        // Ambil semua PICA
        $picaList = Pica::all();

        // Ambil Incident sesuai filter session
        $incidentQuery = Incident::with(['accident', 'category'])
            ->whereMonth('date', $carbon->month)
            ->whereYear('date', $carbon->year);

        if (!$isActiveAll) {
            if (!empty($activeAccidents)) {
                $incidentQuery->whereIn('id', $activeAccidents);
            } else {
                $incidentQuery->whereRaw('1 = 0'); // kosong
            }
        }

        $incidentList = $incidentQuery->get();
        $incidentsByDay = $incidentList->groupBy(fn($incident) => Carbon::parse($incident->date)->day);

        $tanggalList = [];

        for ($i = 1; $i <= $hariDalamBulan; $i++) {
            $tanggal = Carbon::createFromDate($carbon->year, $carbon->month, $i);
            $incidentHariIni = $incidentsByDay->get($i, collect());

            // Tentukan warna latar
            if ($incidentHariIni->contains(fn($incident) => $incident->category_id === 4)) {
                $bgClass = 'red';
            } elseif ($incidentHariIni->isNotEmpty()) {
                $bgClass = 'yellow';
            } else {
                $bgClass = '#06923E';
            }

            // Buat badge kategori
            $categoryBadge = $incidentHariIni->pluck('accident_id')
                ->unique()
                ->map(function ($id) {
                    return match ($id) {
                        1 => ['icon' => 'fa-solid fa-notes-medical', 'color' => 'text-success'],
                        2 => ['icon' => 'fa-solid fa-fire', 'color' => 'text-danger'],
                        3 => ['icon' => 'fa-solid fa-triangle-exclamation', 'color' => 'text-warning'],
                        default => null,
                    };
                })
                ->filter()
                ->values()
                ->toArray();

            // Cek apakah tanggal masuk periode PICA
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
                'pica' => $matchingPica?->id,
            ];
        }

        $offsetHariPertama = Carbon::createFromDate($carbon->year, $carbon->month, 1)->dayOfWeekIso;

        $days = collect(range(1, 7))->map(function ($i) {
            return Carbon::create()->startOfWeek()->addDays($i - 1)->locale('id')->translatedFormat('l');
        });

        return [
            'incidents' => $incidentsByDay,
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
            ->whereMonth('created_at', $now)
            ->latest('id')
            ->first();


        $latestLwd = Incident::where('category_id', 3)
            ->latest('created_at')
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
