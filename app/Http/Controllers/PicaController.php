<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Pica;
use App\Services\PicaService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PicaController extends Controller
{

    public function pica($date)
    {
        $date = Carbon::parse($date)->toDateString();

        $pica = Pica::with('image')
            ->whereDate('date_start', '<=', $date)
            ->whereDate('date_end', '>=', $date)
            ->first();

        if (!$pica) {
            return view('pica', [
                'images' => collect(),
                'picaDate' => Carbon::parse($date)->format('d F Y'),
                'pica' => null,
            ]);
        }

        return view('pica', [
            'images' => $pica->image,
            'picaDate' => Carbon::parse($date)->format('d F Y'),
            'pica' => $pica,
        ]);
    }


    public function picaPost(Request $request)
    {
        $service = new PicaService();
        $post = $service->post($request);
        return $post['success']
            ? redirect()->route('pica-admin')->with('success', $post['message'])
            : redirect()->route('pica-admin')->with('error', $post['message']);
    }
    public function picaImagePost(Request $request)
    {
        $service = new PicaService();
        $post = $service->postImage($request);
        return $post['success']
            ? redirect()->route('pica-admin')->with('success', $post['message'])
            : redirect()->route('pica-admin')->with('error', $post['message']);
    }
    public function picaUpdate(Request $request)
    {
        $service = new PicaService();
        $update = $service->update($request);
        return $update['success']
            ? redirect()->route('pica-admin')->with('success', $update['message'])
            : redirect()->route('pica-admin')->with('error', $update['message']);
    }
    public function picaDelete(Request $request)
    {
        $service = new PicaService();
        $delete = $service->delete($request);
        return $delete['success']
            ? redirect()->route('pica-admin')->with('success', $delete['message'])
            : redirect()->route('pica-admin')->with('error', $delete['message']);
    }
}
