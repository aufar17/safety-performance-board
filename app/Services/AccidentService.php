<?php

namespace App\Services;

use App\Models\Accident;
use App\Models\AgcLevel;
use App\Models\AgcLevelHistory;
use App\Models\Incident;
use App\Models\Pica;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class AccidentService
{
    public function post(Request $request): array
    {
        DB::beginTransaction();
        try {
            $incident = Incident::create([
                'accident_id' => $request->accident,
                'category_id' => $request->category,
                'date'        => $request->date,
                'description' => $request->description,
            ]);

            if ($incident->category_id == 3) {
                $agc = AgcLevelHistory::whereYear('created_at', now()->year)->first();

                if ($agc) {
                    $sinceLwd = floor(Carbon::parse($incident->date)->floatDiffInDays(Carbon::now()));
                    $accident_hours_non_lti = $agc->man_power * 8 * $sinceLwd;

                    $agc->update([
                        'accident_hours_non_lti' => $accident_hours_non_lti
                    ]);
                }
            }

            $activeAccidents = collect(session('activeAccidents', []))
                ->map(fn($v) => (int) $v)
                ->filter(fn($v) => $v !== $incident->id)
                ->values()
                ->toArray();


            session(['activeAccidents' => $activeAccidents]);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Data accident saved successfully and set as inactive.',
                'data'    => $incident,
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
        $incident = Incident::find($request->id);
        if (!$incident) {
            return [
                'success' => false,
                'message' => 'Incident not found.',
            ];
        }

        DB::beginTransaction();
        try {
            $activeAccidents = collect(session('activeAccidents', []))->map(fn($v) => (int) $v)->toArray();

            $wasActive = in_array($incident->id, $activeAccidents, true);

            $incident->update([
                'accident_id' => $request->accident,
                'category_id' => $request->category,
                'date'        => $request->date,
                'description' => $request->description,
            ]);

            if ($incident->category_id == 3) {
                $agc = AgcLevelHistory::whereYear('created_at', now()->year)->first();

                if ($agc) {
                    $sinceLwd = floor(Carbon::parse($incident->date)->floatDiffInDays(Carbon::now()));
                    $accident_hours_non_lti = $agc->man_power * 8 * $sinceLwd;

                    $agc->update([
                        'accident_hours_non_lti' => $accident_hours_non_lti
                    ]);
                }
            }

            if ($wasActive) {
                if (!in_array($incident->id, $activeAccidents, true)) {
                    $activeAccidents[] = $incident->id;
                }
            } else {
                $activeAccidents = array_values(array_filter($activeAccidents, fn($id) => $id !== $incident->id));
            }

            session(['activeAccidents' => $activeAccidents]);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Data accident updated successfully.',
                'data'    => $incident,
            ];
        } catch (\Exception $e) {
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
        $incident = Incident::where('id', $request->id)->first();
        DB::beginTransaction();
        try {
            $incident->delete();

            DB::commit();

            return [
                'success' => true,
                'message' => 'Data accident deleted successfully.',
                'data'    => $incident,
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

    public function toggleSimulation(bool $isSimulation): string
    {
        $today = now()->toDateString();

        Incident::whereDate('date', $today)->update([
            'simulation' => $isSimulation ? 1 : 0,
        ]);

        return $isSimulation
            ? 'Today is emergency response simulation.'
            : 'Emergency response simulation canceled.';
    }


    public function toggleAllActive(bool $setActive): string
    {
        Incident::query()->update([
            'active' => $setActive ? 1 : 0,
        ]);

        return $setActive
            ? 'All accidents are active.'
            : 'All accidents deactivated.';
    }


    public function toggleActive(int $id, bool $isActive): string
    {
        $incident = Incident::findOrFail($id);
        $date = $incident->date ?? now()->toDateString();

        $incident->update([
            'active' => $isActive ? 1 : 0,
        ]);

        return $isActive
            ? "Accident on {$date} is now visible."
            : "Accident on {$date} is now hidden.";
    }
}
