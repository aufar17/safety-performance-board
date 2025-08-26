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

        $latestLwd = Incident::where('category_id', 3)
            ->latest('date')
            ->first();

        $sinceLwd = $latestLwd
            ? floor(Carbon::parse($latestLwd->date)->floatDiffInDays(Carbon::now()))
            : 0;

        $agcLevels = AgcLevelHistory::with('agc')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->paginate(10);


        $data = [
            'agcLevels' => $agcLevels,
            'month' => $carbonMonth->format('F'),
            'year' => $year,
            'now' => $now->format('F Y'),
            'user' => $user,
            'sinceLwd' => $sinceLwd,
        ];
        return view('agc', $data);
    }

    public function picaAdmin(Request $request)
    {
        $user = Auth::user();
        $now = Carbon::now();
        $year = $now->year;

        $picas = Pica::with('image')
            ->where('type', 1)
            ->whereYear('date_start', $year)
            ->paginate(10);


        $data = [
            'picas' => $picas,
            'year'   => $year,
            'now'    => $now->format('Y'),
            'user' => $user
        ];

        return view('pica-admin', $data);
    }
    public function issueAdmin()
    {
        $user = Auth::user();
        $now = Carbon::now();

        $year = $now->year;

        $issues = Pica::with('image')
            ->where('type', 2)
            ->whereYear('date_start', $year)
            ->paginate(10);

        $data = [
            'issues' => $issues,
            'year'   => $year,
            'now'    => $now->format('Y'),
            'user'   => $user,
        ];

        return view('issue-admin', $data);
    }
}
