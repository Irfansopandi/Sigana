<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        $this->generateCaptcha();
        return view('auth.login');
    }

    private function generateCaptcha(): void
    {
        $a = rand(1, 9);
        $b = rand (1, 10 - $a); //hasil max 10
        session([
            'captcha_question' => "$a + $b",
            'captcha_answer' => $a + $b,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
            'captcha'  => ['required', 'integer'],
            ]);

        
        $correctAnswer = session('captcha_answer');
        $this->generateCaptcha();
        // validasi jawaban captcha
        if ((int) $request->captcha !== $correctAnswer) {
            return back()->withErrors([
                'captcha' => 'Jawaban anda salah.',
            ])->onlyInput('email');
        }

        // Cek email dulu
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan.',
            ])->onlyInput('email');
        }

        // Cek password
        if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Kata sandi salah.',
            ])->onlyInput('email');
        }

        // Login
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return match ($user->role) {
            'admin'   => redirect()->route('admin.dashboard')->with('login_success', true),
            'relawan' => redirect()->route('relawan.dashboard')->with('login_success', true),
            default   => redirect()->route('user.dashboard')->with('login_success', true),
        };
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('logout_success', 'Anda telah berhasil keluar.');

    }
}