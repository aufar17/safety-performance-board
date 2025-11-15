<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Services\AccidentService;
use Illuminate\Http\Request;

class AccidentController extends Controller
{

    public function simulation(Request $request)
    {
        $service = new AccidentService();
        $isSimulation = $request->has('simulation');

        $message = $service->toggleSimulation($isSimulation);

        return back()->with('success', $message);
    }


    public function isAllActive(Request $request)
    {
        $service = new AccidentService();
        $setActive = $request->has('activeAll');

        $message = $service->toggleAllActive($setActive);

        return back()->with('success', $message);
    }


    public function isActive(Request $request, $id)
    {
        $service = new AccidentService();
        $isActive = $request->has('active');

        $message = $service->toggleActive((int)$id, $isActive);

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
