<?php

namespace App\Services;

use App\Models\Accident;
use App\Models\Incident;
use App\Models\Pica;
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
                'date'     => $request->date,
                'description'     => $request->description,
            ]);
            // dd($incident);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Data accident saved successfully.',
                'data'    => [$incident],
            ];
        } catch (Exception $e) {
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
        $incident = Incident::where('id', $request->id)->first();
        DB::beginTransaction();
        try {
            $incident->update([
                'accident_id' => $request->accident,
                'category_id' => $request->category,
                'date' => $request->date,
                'description'     => $request->description,
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
}
