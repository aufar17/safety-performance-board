<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Pica;
use App\Services\IssueService;
use App\Services\PicaService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IssueController extends Controller
{

    public function issue(Request $request)
    {
        $query = Pica::with('image')
            ->where('type', 2);

        if ($request->filled('date_start')) {
            $query->whereDate('date_start', $request->date_start);
        } else {
            $query->whereBetween('date_start', [Carbon::now()->subWeek(), Carbon::now()]);
        }

        $issues = $query->latest('date_start')->get();

        $availableDates = Pica::where('type', 2)
            ->pluck('date_start')
            ->unique()
            ->sortDesc();

        $data = [
            'images'         => $issues->flatMap->image ?? collect(),
            'pica'           => $issues ?? collect(),
            'availableDates' => $availableDates,
            'selectedDate'   => $request->date_start
        ];

        return view('issue', $data);
    }


    public function issuePost(Request $request)
    {
        $service = new IssueService();
        $post = $service->post($request);
        return $post['success']
            ? redirect()->route('issue-admin')->with('success', $post['message'])
            : redirect()->route('issue-admin')->with('error', $post['message']);
    }
    public function issueImagePost(Request $request)
    {
        $service = new IssueService();
        $post = $service->postImage($request);
        return $post['success']
            ? redirect()->route('issue-admin')->with('success', $post['message'])
            : redirect()->route('issue-admin')->with('error', $post['message']);
    }
    public function issueUpdate(Request $request)
    {
        $service = new IssueService();
        $update = $service->update($request);
        return $update['success']
            ? redirect()->route('issue-admin')->with('success', $update['message'])
            : redirect()->route('issue-admin')->with('error', $update['message']);
    }
    public function issueDelete(Request $request)
    {
        $service = new IssueService();
        $delete = $service->delete($request);
        return $delete['success']
            ? redirect()->route('issue-admin')->with('success', $delete['message'])
            : redirect()->route('issue-admin')->with('error', $delete['message']);
    }
}
