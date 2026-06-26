<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    // Step 1: Tampilkan form input email
    public function showEmailForm()
    {
        return view('auth.forgot-password');
    }

    // Step 2: Kirim OTP ke email
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email tidak terdaftar di sistem SIGANA.',
        ]);

        // Hapus OTP lama untuk email ini
        PasswordResetOtp::where('email', $request->email)->delete();

        // Generate OTP 6 digit
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Simpan OTP ke database
        PasswordResetOtp::create([
            'email'      => $request->email,
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(10),
            'used'       => false,
        ]);

        // Kirim email
        Mail::to($request->email)->send(new OtpMail($otp));

        // Simpan email di session untuk step berikutnya
        session([
            'otp_email' => $request->email,
            'otp_sent_at' => now()->timestamp,
        ]);

        return redirect()->route('password.otp.form')
            ->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    // Step 3: Tampilkan form input OTP
    public function showOtpForm()
    {
        if (!session('otp_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-otp');
    }

    // Step 4: Verifikasi OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $email = session('otp_email');

        if (!$email) {
            return redirect()->route('password.request');
        }

        $record = PasswordResetOtp::where('email', $email)
            ->where('otp', $request->otp)
            ->where('used', false)
            ->first();

        if (!$record) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid.']);
        }

        if ($record->expires_at->isPast()) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Silakan minta ulang.']);
        }

        // Tandai OTP sudah diverifikasi
        session(['otp_verified' => true]);

        return redirect()->route('password.reset.form');
    }

    // Step 5: Tampilkan form reset password baru
    public function showResetForm()
    {
        if (!session('otp_email') || !session('otp_verified')) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password');
    }

    // Step 6: Simpan password baru
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ], [
            'password.min'      => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $email = session('otp_email');

        if (!$email || !session('otp_verified')) {
            return redirect()->route('password.request');
        }

        // Update password user
        User::where('email', $email)->update([
            'password' => Hash::make($request->password),
        ]);

        // Tandai OTP sebagai used
        PasswordResetOtp::where('email', $email)->update(['used' => true]);

        // Hapus session
        session()->forget(['otp_email', 'otp_verified']);

        return redirect()->route('login')
            ->with('success', 'Password berhasil direset. Silakan login.');
    }
}