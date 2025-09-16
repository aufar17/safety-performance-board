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
            // paksa semua nilai jadi integer (default 0 kalau kosong/null)
            $lossday        = (int) ($request->loss_day ?? 0);
            $total_accident = (int) ($request->total_accident ?? 0);
            $man_power      = (int) ($request->man_power ?? 0);
            $sinceLwd       = (int) ($request->accident_days ?? 0);
            $work_hours_fr  = (int) ($request->work_hours_fr ?? 0);
            $work_hours_sr  = (int) ($request->work_hours_sr ?? 0);

            $accident_hours_non_lti = $man_power * 8 * $sinceLwd;

            // Cegah pembagian dengan nol
            $fr = ($work_hours_fr > 0) 
                ? round(($total_accident / $work_hours_fr) * 1000000, 2) 
                : 0;

            $sr = ($work_hours_sr > 0) 
                ? round(($lossday / $work_hours_sr) * 1000000, 2) 
                : 0;

            $frLevel = AgcLevel::matchFr($fr)->first();
            $srLevel = AgcLevel::matchSr($sr)->first();

            if ($frLevel && $srLevel) {
                $matchedLevel = $frLevel->id > $srLevel->id ? $frLevel : $srLevel;
            } else {
                $matchedLevel = $frLevel ?? $srLevel;
            }

            $agcHistory = AgcLevelHistory::create([
                'agc_level_id'           => $matchedLevel?->id,
                'total_accident'         => $total_accident,
                'loss_day'               => $lossday,
                'fr'                     => $fr,
                'sr'                     => $sr,
                'man_power'              => $man_power,
                'accident_hours_non_lti' => $accident_hours_non_lti,
                'work_hours'             => $work_hours_fr,
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
        $agc = AgcLevelHistory::where('id', $request->id)->first();
        DB::beginTransaction();
        try {
            $lossday        = (int) ($request->loss_day ?? 0);
            $total_accident = (int) ($request->total_accident ?? 0);
            $man_power      = (int) ($request->man_power ?? 0);
            $sinceLwd       = (int) ($request->accident_days ?? 0);
            $work_hours_fr  = (int) ($request->work_hours_fr ?? 0);
            $work_hours_sr  = (int) ($request->work_hours_sr ?? 0);

            $accident_hours_non_lti = $man_power * 8 * $sinceLwd;

            // Cegah pembagian dengan nol
            $fr = ($work_hours_fr > 0) 
                ? round(($total_accident / $work_hours_fr) * 1000000, 2) 
                : 0;

            $sr = ($work_hours_sr > 0) 
                ? round(($lossday / $work_hours_sr) * 1000000, 2) 
                : 0;

            $frLevel = AgcLevel::matchFr($fr)->first();
            $srLevel = AgcLevel::matchSr($sr)->first();

            if ($frLevel && $srLevel) {
                $matchedLevel = $frLevel->id > $srLevel->id ? $frLevel : $srLevel;
            } else {
                $matchedLevel = $frLevel ?? $srLevel;
            }

            $updateAgc = $agc->update([
                'agc_level_id'           => $matchedLevel?->id,
                'total_accident'         => $total_accident,
                'loss_day'               => $lossday,
                'fr'                     => $fr,
                'sr'                     => $sr,
                'man_power'              => $man_power,
                'accident_hours_non_lti' => $accident_hours_non_lti,
                'work_hours'             => $work_hours_fr,
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
