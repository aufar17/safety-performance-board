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
    public function accident(Request $request)
    {
        $user = Auth::user();
        $now = Carbon::now();

        $filterMonthYear = $request->input('filterMonthYear', $now->format('Y-m'));
        [$year, $month] = explode('-', $filterMonthYear);
        $carbonMonth = Carbon::createFromDate($year, $month, 1);
        $incidents = Incident::with('accident', 'category')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->paginate(10);

        $accidents = Accident::all();
        $categories = CategoryAccident::all();

        $data = [
            'incidents' => $incidents,
            'accidents' => $accidents,
            'categories' => $categories,
            'month' => $carbonMonth->format('F'),
            'year' => $year,
            'now' => Carbon::createFromDate($year, $month)->format('F Y'),
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

    public function agc(Request $request)
    {
        $user = Auth::user();
        $now = Carbon::now();
        $filterMonthYear = $request->input('filterMonthYear', $now->format('Y-m'));
        [$year, $month] = explode('-', $filterMonthYear);
        $carbonMonth = Carbon::createFromDate($year, $month, 1);

        $agcLevels = AgcLevelHistory::with('agc')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->paginate(10);


        $data = [
            'agcLevels' => $agcLevels,
            'month' => $carbonMonth->format('F'),
            'year' => $year,
            'now' => $now->format('F Y'),
            'user' => $user
        ];
        return view('agc', $data);
    }

    public function picaAdmin(Request $request)
    {
        $user = Auth::user();
        $now = Carbon::now();

        $filterMonthYear = $request->input('filterMonthYear', $now->format('Y-m'));
        [$year, $month] = explode('-', $filterMonthYear);
        $carbonMonth = Carbon::createFromDate($year, $month, 1);
        $picas = Pica::with('image')
            ->whereYear('date_start', $year)
            ->whereMonth('date_start', $month)
            ->paginate(10);


        $data = [
            'picas' => $picas,
            'month' => $carbonMonth->format('F'),
            'year' => $year,
            'now' => Carbon::createFromDate($year, $month)->format('F Y'),
            'user' => $user
        ];

        return view('pica-admin', $data);
    }
}
