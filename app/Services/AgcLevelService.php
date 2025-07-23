<?php

namespace App\Services;

use App\Models\Accident;
use App\Models\AgcLevel;
use App\Models\AgcLevelHistory;
use App\Models\Incident;
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
            $lossday = $request->loss_day_fr;
            $work_time_fr = $request->work_time_fr;
            $work_time_sr = $request->work_time_sr;
            $total_accident = $request->total_accident;

            $fr = ($total_accident / $work_time_fr) * 1000000;
            $sr = ($lossday / $work_time_sr) * 1000000;

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
                'fr'           => $fr,
                'sr'           => $sr,
            ]);

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
        $incident = Incident::where('id', $request->id)->first();
        DB::beginTransaction();
        try {
            $lossday = $request->loss_day_fr;
            $work_time_fr = $request->work_time_fr;
            $work_time_sr = $request->work_time_sr;
            $total_accident = $request->total_accident;

            $fr = ($total_accident / $work_time_fr) * 1000000;
            $sr = ($lossday / $work_time_sr) * 1000000;

            $frLevel = AgcLevel::matchFr($fr)->first();
            $srLevel = AgcLevel::matchSr($sr)->first();

            if ($frLevel && $srLevel) {
                $matchedLevel = $frLevel->id > $srLevel->id ? $frLevel : $srLevel;
            } else {
                $matchedLevel = $frLevel ?? $srLevel;
            }

            $incident->update([
                'agc_level_id' => $matchedLevel?->id,
                'date'         => $request->date,
                'fr'           => $fr,
                'sr'           => $sr,
            ]);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Data accident updated successfully.',
                'data'    => $incident,
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
