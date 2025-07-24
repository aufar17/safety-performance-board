<?php

namespace App\Services;

use App\Models\Incident;
use App\Models\OtpVerification;
use App\Models\Pica;
use App\Models\PicaImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PicaService
{
    /**
     * Handle OTP verification.
     *
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function post(Request $request): array
    {
        DB::beginTransaction();

        try {
            $pica = Pica::where('incident_id', $request->incident_id)->first();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('pica', $filename);

                    $image =  PicaImage::create([
                        'pica_id' => $pica->id,
                        'image'   => $path,
                    ]);
                }
            }

            DB::commit();

            return [
                'success' => true,
                'message' => 'Data accident saved successfully.',
                'data'    => $pica,
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
        $incident = Pica::where('id', $request->id)->first();
        DB::beginTransaction();
        try {
            $incident->update([
                'accident_id' => $request->accident,
                'category_id' => $request->category,
                'date' => $request->date,
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
        $incident = Pica::where('id', $request->id)->first();
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
