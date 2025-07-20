<?php

namespace App\Services;

use App\Models\Accident;
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

        return compact(
            'user',
            'now',
            'year',
            'month',
            'accidents',
            'mappings',
            'months',
            'accumulativeAccident'
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
}
