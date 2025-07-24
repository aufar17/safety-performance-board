<?php

namespace App\Http\Controllers;

use App\Models\Accident;
use App\Models\AgcLevelHistory;
use App\Models\CategoryAccident;
use App\Models\Incident;
use App\Models\Pica;
use App\Services\MonitoringService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [
            'user' => $user
        ];
        return view('index', $data);
    }
    public function accident()
    {
        $user = Auth::user();
        $now = Carbon::now();
        $month = $now->month;
        $year = $now->year;

        $incidents = Incident::with('accident', 'category', 'pica', 'pica.image')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->paginate(10);

        $accidents = Accident::all();
        $categories = CategoryAccident::all();

        $data = [
            'incidents' => $incidents,
            'accidents' => $accidents,
            'categories' => $categories,
            'now' => $now->format('F Y'),
            'user' => $user
        ];

        return view('accident', $data);
    }

    public function monitoring()
    {

        $service = new MonitoringService();
        $data = $service->monitoring();
        return view('monitoring', $data);
    }

    public function agc()
    {
        $user = Auth::user();
        $now = Carbon::now();
        $month = $now->month;
        $year = $now->year;

        $agcLevels = AgcLevelHistory::with('agc')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->paginate(10);


        $data = [
            'agcLevels' => $agcLevels,
            'now' => $now->format('F Y'),
            'user' => $user
        ];
        return view('agc', $data);
    }
}
