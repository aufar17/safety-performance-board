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

        // Ambil semua incident ID
        $incidentIds = Incident::pluck('id')
            ->map(fn($v) => (int) $v)
            ->unique()
            ->values()
            ->toArray();

        if ($active) {
            // Saat aktif semua, simpan semua ID ke session
            session([
                'activeAccidents' => $incidentIds,
                'manuallyDisabled' => session('manuallyDisabled', []), // jaga preferensi user
            ]);
        } else {
            // Saat dimatikan, kosongkan semua
            session([
                'activeAccidents' => [],
                'manuallyDisabled' => [],
            ]);
        }

        return back()->with('success', $active ? 'All accidents are active.' : 'All accidents deactivated.');
    }


    public function isActive(Request $request, $id)
    {
        $id = (int) $id;

        // Ambil session data
        $incidents = collect(session('activeAccidents', []))
            ->map(fn($v) => (int) $v)
            ->unique()
            ->values()
            ->toArray();

        $manuallyDisabled = collect(session('manuallyDisabled', []))
            ->map(fn($v) => (int) $v)
            ->unique()
            ->values()
            ->toArray();

        $date = Incident::where('id', $id)->value('date') ?? now()->toDateString();

        // Cek apakah user menyalakan atau mematikan
        if ($request->has('active')) {
            // Aktifkan incident
            if (!in_array($id, $incidents, true)) {
                $incidents[] = $id;
            }

            // Hapus dari daftar manual nonaktif jika ada
            $manuallyDisabled = array_values(array_diff($manuallyDisabled, [$id]));

            $message = "Accident on {$date} is now visible.";
        } else {
            // Nonaktifkan incident
            $incidents = array_values(array_filter($incidents, fn($accId) => $accId !== $id));

            // Simpan ke daftar manual nonaktif supaya tetap disembunyikan meski 'all active' nyala
            if (!in_array($id, $manuallyDisabled, true)) {
                $manuallyDisabled[] = $id;
            }

            $message = "Accident on {$date} is now hidden.";
        }

        // Update session
        session([
            'activeAccidents' => $incidents,
            'manuallyDisabled' => $manuallyDisabled,
        ]);

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
