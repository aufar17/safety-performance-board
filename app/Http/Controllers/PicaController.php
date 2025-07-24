<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Pica;
use App\Services\PicaService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PicaController extends Controller
{

    public function pica($day)
    {
        $incident = Incident::with(['pica', 'pica.image'])
            ->where('date', $day)
            ->firstOrFail();
        $accidentDate = Carbon::parse($incident->date)->format('d F Y');
        $images = $incident->pica->image ?? collect();

        $data = [
            'incident' => $incident,
            'images' => $images,
            'accidentDate' => $accidentDate,
        ];
        return view('pica', $data);
    }
    public function picaPost(Request $request)
    {
        $service = new PicaService();
        $post = $service->post($request);
        return $post['success']
            ? redirect()->route('accident')->with('success', $post['message'])
            : redirect()->route('accident')->with('error', $post['message']);
    }
    public function picaUpdate(Request $request)
    {
        $service = new PicaService();
        $update = $service->update($request);
        return $update['success']
            ? redirect()->route('accident')->with('success', $update['message'])
            : redirect()->route('accident')->with('error', $update['message']);
    }
    public function picaDelete(Request $request)
    {
        $service = new PicaService();
        $delete = $service->delete($request);
        return $delete['success']
            ? redirect()->route('accident')->with('success', $delete['message'])
            : redirect()->route('accident')->with('error', $delete['message']);
    }
}
