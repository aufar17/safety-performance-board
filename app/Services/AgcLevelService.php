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
            $lossday = $request->loss_day;
            $total_accident = $request->total_accident;
            $accident_hours = $request->accident_hours;

            $fr = ($total_accident / $accident_hours) * 1000000;
            $sr = ($lossday / $accident_hours) * 1000000;

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
                'accident_hours'           => $accident_hours,
            ]);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Data accident saved successfully.',
                'data'    => $agcHistory,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
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

            $fr = ($total_accident / $total_accident) * 1000000;
            $sr = ($lossday / $total_accident) * 1000000;

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
                'accident_hours'  => $request->accident_hours,

            ]);

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
