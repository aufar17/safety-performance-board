<?php

namespace App\Http\Controllers;

use App\Models\Accident;
use App\Models\CategoryAccident;
use App\Models\Incident;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function accident()
    {
        $user = Auth::user();
        $now = Carbon::now();
        $month = $now->month;
        $year = $now->year;

        $incidents = Incident::with('accident', 'category')
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
}
