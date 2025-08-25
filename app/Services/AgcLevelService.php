<?php

namespace App\Services;

use App\Models\Accident;
use App\Models\AgcLevel;
use App\Models\AgcLevelHistory;
use App\Models\Incident;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class AgcLevelService
{
    public function post(Request $request): array
    {
        DB::beginTransaction();
        try {
            $lossday = $request->loss_day;
            $total_accident = $request->total_accident;
            $total_hours = $request->total_hours;
            $work_hours = $request->work_hours;

            $latestLwd = Incident::where('category_id', 3)
                ->latest('date')
                ->first();

            $sinceLwd = $latestLwd
                ? floor(Carbon::parse($latestLwd->date)->floatDiffInDays(Carbon::now()))
                : 0;

            $accident_hours_non_lti = $total_hours * $sinceLwd;

            $fr = round(($total_accident / $work_hours) * 1000000, 2);
            dd($fr);
            $sr = round(($lossday / $work_hours) * 1000000, 2);

            $frLevel = AgcLevel::matchFr($fr)->first();
            $srLevel = AgcLevel::matchSr($sr)->first();

            if ($frLevel && $srLevel) {
                $matchedLevel = $frLevel->id > $srLevel->id ? $frLevel : $srLevel;
            } else {
                $matchedLevel = $frLevel ?? $srLevel;
            }

            $agcHistory = AgcLevelHistory::create([
                'agc_level_id' => $matchedLevel?->id,
                'date'         => $request->date,
                'total_accident'           => $total_accident,
                'loss_day'           => $request->loss_day,
                'fr'           => $fr,
                'sr'           => $sr,
                'total_hours'           => $total_hours,
                'accident_hours_non_lti'           => $accident_hours_non_lti,
                'work_hours'           => $work_hours,
            ]);
            dd($agcHistory);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Data accident saved successfully.',
                'data'    => $agcHistory,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Failed to save data accident.',
                'error'   => $e->getMessage(),
            ];
        }
    }

    public function update(Request $request): array
    {
        $agc = AgcLevelHistory::where('id', $request->id)->first();
        DB::beginTransaction();
        try {
            $lossday = $request->loss_day;
            $total_accident = $request->total_accident;
            $total_hours = $request->total_hours;
            $work_hours = $request->work_hours;

            $latestLwd = Incident::where('category_id', 3)
                ->latest('date')
                ->first();

            $sinceLwd = $latestLwd
                ? floor(Carbon::parse($latestLwd->date)->floatDiffInDays(Carbon::now()))
                : 0;

            $accident_hours_non_lti = $total_hours * $sinceLwd;

            $fr = round(($total_accident / $work_hours) * 1000000, 2);
            $sr = round(($lossday / $work_hours) * 1000000, 2);

            $frLevel = AgcLevel::matchFr($fr)->first();
            $srLevel = AgcLevel::matchSr($sr)->first();

            if ($frLevel && $srLevel) {
                $matchedLevel = $frLevel->id > $srLevel->id ? $frLevel : $srLevel;
            } else {
                $matchedLevel = $frLevel ?? $srLevel;
            }

            $updateAgc =  $agc->update([
                'agc_level_id' => $matchedLevel?->id,
                'date'         => $request->date,
                'total_accident'           => $total_accident,
                'loss_day'           => $request->loss_day,
                'fr'           => $fr,
                'sr'           => $sr,
                'total_hours'           => $total_hours,
                'accident_hours_non_lti'           => $accident_hours_non_lti,
                'work_hours'           => $work_hours,

            ]);
            dd($accident_hours_non_lti);


            DB::commit();

            return [
                'success' => true,
                'message' => 'Data accident updated successfully.',
                'data'    => $updateAgc,
            ];
        } catch (Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Failed to update data accident.',
                'error'   => $e->getMessage(),
            ];
        }
    }
    public function delete(Request $request): array
    {
        $agc = AgcLevelHistory::where('id', $request->id)->first();
        DB::beginTransaction();
        try {
            $agc->delete();

            DB::commit();

            return [
                'success' => true,
                'message' => 'Data accident deleted successfully.',
                'data'    => $agc,
            ];
        } catch (Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Failed to delete data accident.',
                'error'   => $e->getMessage(),
            ];
        }
    }
}
