<?php

namespace App\Http\Controllers;

use App\Services\AgcLevelService;
use Illuminate\Http\Request;

class AgcController extends Controller
{
    public function agcPost(Request $request)
    {
        $service = new AgcLevelService();
        $post = $service->post($request);
        return $post['success']
            ? redirect()->route('agc')->with('success', $post['message'])
            : redirect()->route('agc')->with('error', $post['message']);
    }
    public function agcUpdate(Request $request)
    {
        $service = new AgcLevelService();
        $update = $service->update($request);
        return $update['success']
            ? redirect()->route('agc')->with('success', $update['message'])
            : redirect()->route('agc')->with('error', $update['message']);
    }
    public function agcDelete(Request $request)
    {
        $service = new AgcLevelService();
        $delete = $service->delete($request);
        return $delete['success']
            ? redirect()->route('agc')->with('success', $delete['message'])
            : redirect()->route('agc')->with('error', $delete['message']);
    }
}
