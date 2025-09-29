<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Services\AccidentService;
use Illuminate\Http\Request;

class AccidentController extends Controller
{

    public function simulation(Request $request)
    {
        $simulasi = $request->has('simulation');
        $today = now()->format('Y-m-d');

        $dailySimulation = session('dailySimulation', []);
        $dailySimulation[$today] = $simulasi;
        session(['dailySimulation' => $dailySimulation]);

        $message = $simulasi
            ? 'Today is emergency response simulation.'
            : 'Emergency response simulation canceled.';

        return redirect()->back()->with('success', $message);
    }

    public function isAllActive(Request $request)
    {
        $active = $request->has('activeAll');
        session(['isActiveAll' => $active]);

        if ($active) {
            $incidentIds = Incident::pluck('id')
                ->map(fn($v) => (int) $v)
                ->unique()
                ->values()
                ->toArray();

            session(['activeAccidents' => $incidentIds]);
        } else {
            session(['activeAccidents' => []]);
        }

        return back()->with('success', $active ? 'All accidents are active.' : 'All accidents deactivated.');
    }


    public function isActive(Request $request, $id)
    {
        $id = (int) $id;

        $incidents = collect(session('activeAccidents', []))
            ->map(fn($v) => (int) $v)
            ->unique()
            ->values()
            ->toArray();

        $date = Incident::where('id', $id)->value('date') ?? now()->toDateString();

        if ($request->has('simulation')) {
            if (!in_array($id, $incidents, true)) {
                $incidents[] = $id;
                $incidents = array_values(array_unique($incidents));
            }
            $message = "Accident on {$date} is now visible.";
        } else {
            $incidents = array_values(array_filter($incidents, fn($accId) => $accId !== $id));
            $message = "Accident on {$date} is now hidden.";
        }

        session(['activeAccidents' => $incidents]);

        return back()->with('success', $message);
    }



    public function accidentPost(Request $request)
    {
        $service = new AccidentService();
        $post = $service->post($request);
        return $post['success']
            ? redirect()->route('accident')->with('success', $post['message'])
            : redirect()->route('accident')->with('error', $post['message']);
    }
    public function accidentUpdate(Request $request)
    {
        $service = new AccidentService();
        $update = $service->update($request);
        return $update['success']
            ? redirect()->route('accident')->with('success', $update['message'])
            : redirect()->route('accident')->with('error', $update['message']);
    }
    public function accidentDelete(Request $request)
    {
        $service = new AccidentService();
        $delete = $service->delete($request);
        return $delete['success']
            ? redirect()->route('accident')->with('success', $delete['message'])
            : redirect()->route('accident')->with('error', $delete['message']);
    }
}
