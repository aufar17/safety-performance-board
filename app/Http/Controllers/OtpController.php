<?php

namespace App\Http\Controllers;

use App\Models\Hp;
use App\Models\OtpVerification;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function otpVerif()
    {
        $otpService = new OtpService();
        $otpData = $otpService->otpVerif();

        return view('authentication.otp', $otpData);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Session expired. Silakan login kembali.']);
        }

        $otp = OtpVerification::where('npk', $user->npk)
            ->where('expiry_date', '>=', now())
            ->latest('created_at')
            ->first();

        // ✅ OTP default untuk development
        if (app()->environment('local') && $request->otp === '123456') {
            $isValid = true;
        } else {
            $isValid = $otp && $otp->otp === $request->otp;
        }

        if (!$isValid) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kedaluwarsa.']);
        }

        session(['otp_verified' => true]);
        session()->save();

        // Hapus OTP hanya jika bukan default 123456
        if (!($request->otp === '123456' && app()->environment('local'))) {
            $otp->delete();
        }

        return redirect()->route('index')->with('success', 'Selamat Datang!');
    }

    public function resendOtp()
    {
        $user = Auth::user();
        $hp = Hp::where('npk', $user->npk)->first()->hp;

        $otpCode = (app()->environment('local')) ? '123456' : rand(100000, 999999);

        $expiredOtp = OtpVerification::where('npk', $user->npk)
            ->where('expiry_date', '<', Carbon::now())
            ->orderBy('created_at', 'desc')
            ->first();

        if ($expiredOtp) {
            $expiredOtp->update([
                'otp'         => $otpCode,
                'hp'          => $hp,
                'expiry_date' => Carbon::now()->addMinutes(5),
                'send'        => 'queue',
                'send_date'   => null,
                'use'         => false,
                'use_date'    => null,
            ]);

            $otp = $expiredOtp;
        } else {
            $otp = OtpVerification::create([
                'npk'     => $user->npk,
                'otp'         => $otpCode,
                'hp'          => $hp,
                'expiry_date' => Carbon::now()->addMinutes(5),
                'send'        => 'queue',
                'send_date'   => null,
                'use'         => false,
                'use_date'    => null,
            ]);
        }

        session([
            'otp_required' => true,
            'otp_expiry'   => $otp->expiry_date,
        ]);

        return redirect()->route('otp-verif')->with('message', 'OTP berhasil dikirim ulang.');
    }
}
