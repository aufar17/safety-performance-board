<?php

namespace App\Services;

use App\Models\OtpVerification;
use Illuminate\Support\Facades\Auth;

class OtpService
{
    /**
     * Handle OTP verification.
     *
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function otpVerif()
    {
        $user = Auth::user();

        $otp = OtpVerification::where('id_user', $user->id)
            ->where('expiry_date', '>=', now())
            ->latest('created_at')
            ->first();

        if (!$otp) {
            session()->forget('otp_expiry');
            return redirect()->route('login')->withErrors(['error' => 'Tidak ada OTP valid. Silakan coba lagi.']);
        }

        if (session('otp_verified', false)) {
            return redirect()->route('index')->with('success', 'Selamat Datang!');
        }

        session(['otp_expiry' => $otp->expiry_date]);

        return [
            'otp' => $otp,
            'expiryTimestamp' => strtotime($otp->expiry_date),
        ];
    }
}
