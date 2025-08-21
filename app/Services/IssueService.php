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

class IssueService
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

            $createPica = Pica::create([
                'type' => 2,
                'title' => $request->title,
                'date_start' => $request->date_start,
            ]);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Data issue saved successfully.',
                'data'    => $createPica,
            ];
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return [
                'success' => false,
                'message' => 'Failed to save data issue.',
                'error'   => $e->getMessage(),
            ];
        }
    }
    public function postImage(Request $request): array
    {
        DB::beginTransaction();

        try {

            $pica = Pica::where('id', $request->pica_id)->first();
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('issue', $filename);

                    $image =  PicaImage::create([
                        'pica_id' => $pica->id,
                        'image'   => $path,
                    ]);
                }
            }

            DB::commit();

            return [
                'success' => true,
                'message' => 'Data pica saved successfully.',
                'data'    => $pica,
            ];
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);

            return [
                'success' => false,
                'message' => 'Failed to save data pica.',
                'error'   => $e->getMessage(),
            ];
        }
    }

    public function update(Request $request): array
    {
        $pica = Pica::where('id', $request->id)->first();
        DB::beginTransaction();
        try {
            $update = $pica->update([
                'title' => $request->title,
                'date_start' => $request->date_start,
            ]);
            DB::commit();

            return [
                'success' => true,
                'message' => 'Data issue updated successfully.',
                'data'    => $update,
            ];
        } catch (Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Failed to update data issue.',
                'error'   => $e->getMessage(),
            ];
        }
    }
    public function delete(Request $request): array
    {
        $issue = Pica::where('id', $request->id)->first();
        DB::beginTransaction();
        try {
            $issue->delete();

            DB::commit();

            return [
                'success' => true,
                'message' => 'Data issue deleted successfully.',
                'data'    => $issue,
            ];
        } catch (Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Failed to delete data issue.',
                'error'   => $e->getMessage(),
            ];
        }
    }
    public function deleteImages(Request $request): array
    {
        $issue = PicaImage::where('id', $request->id)->first();
        DB::beginTransaction();
        try {
            $issue->delete();

            DB::commit();

            return [
                'success' => true,
                'message' => 'Issue image deleted successfully.',
                'data'    => $issue,
            ];
        } catch (Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Failed to delete Issue image.',
                'error'   => $e->getMessage(),
            ];
        }
    }
}
