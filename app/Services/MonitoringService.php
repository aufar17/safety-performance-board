<?php

namespace App\Services;

use App\Models\Accident;
use App\Models\Incident;
use App\Models\OtpVerification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MonitoringService
{
    /**
     * Handle OTP verification.
     *
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function monitoring()
    {
        $user = Auth::user();
        $now = Carbon::now()->format('d F Y');
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('F');
        $accidents = Accident::get();
        $mappings = $this->mappings($year);
        $data = [
            'user' => $user,
            'now' => $now,
            'year' => $year,
            'month' => $month,
            'accidents' => $accidents,
            'mappings' => $mappings,
        ];

        return $data;
    }

    public function mappings($year)
    {
        $accidents = Accident::with([
            'incidents' => function ($query) use ($year) {
                $query->whereYear('date', $year)->with('category');
            }
        ])->get();

        $mappings = [];

        foreach ($accidents as $accident) {
            $incidents = $accident->incidents;

            $total = $incidents->count();

            $categories = $incidents
                ->filter(fn($incident) => $incident->category)
                ->groupBy(fn($incident) => $incident->category->category)
                ->map(fn($group) => $group->count());

            $mappings[] = [
                'accident' => $accident->accident,
                'total' => $total,
                'categories' => $categories,
            ];
        }

        return $mappings;
    }
}
