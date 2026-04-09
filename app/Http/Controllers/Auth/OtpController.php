<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class OtpController extends Controller
{
    public function showRequestForm()
    {
        return view('auth.otp.request-otp');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        // Expire old ones
        OtpVerification::where('email', $user->email)->where('is_used', false)->update(['expires_at' => now()]);

        $otpCode = (string) rand(100000, 999999);
        
        OtpVerification::create([
            'email'      => $user->email,
            'otp'        => Hash::make($otpCode),
            'expires_at' => now()->addMinutes(5),
            'attempts'   => 0
        ]);

        Mail::to($user->email)->send(new OtpMail($otpCode, $user->name));

        return redirect()->route('password.otp.verify', ['email' => $user->email])
                         ->with('status', 'A 6-digit OTP has been sent to your email.');
    }

    public function showVerifyForm(Request $request)
    {
        $email = $request->query('email');
        if (!$email) return redirect()->route('password.otp.request');
        return view('auth.otp.verify-otp', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6'
        ]);

        $otpRecord = OtpVerification::where('email', $request->email)
                        ->where('is_used', false)
                        ->latest()
                        ->first();

        if (!$otpRecord || $otpRecord->isExpired()) {
            return back()->withInput()->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
        }

        if ($otpRecord->attempts >= 3) {
            $otpRecord->update(['expires_at' => now()]); // invalidate
            return back()->withInput()->withErrors(['otp' => 'Too many failed attempts. Request a new OTP.']);
        }

        $otpRecord->increment('attempts');

        if (!Hash::check($request->otp, $otpRecord->otp)) {
            return back()->withInput()->withErrors(['otp' => 'Invalid OTP code.']);
        }

        $otpRecord->update(['is_used' => true]);

        // Put verified email in session for password reset
        session(['otp_reset_email' => $request->email]);

        return redirect()->route('password.otp.resetForm')->with('status', 'OTP verified. Please reset your password.');
    }

    public function showResetForm()
    {
        $email = session('otp_reset_email');
        if (!$email) return redirect()->route('password.otp.request');
        return view('auth.otp.reset-password', compact('email'));
    }

    public function resetPassword(Request $request)
    {
        $email = session('otp_reset_email');
        if (!$email) return redirect()->route('password.otp.request');

        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::where('email', $email)->first();
        if ($user) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        session()->forget('otp_reset_email');

        return redirect()->route('login')->with('status', 'Password has been reset successfully. You can now login.');
    }
}
