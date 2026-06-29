<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function callback()
    {
        try {
            $googleProvider = Socialite::driver('google');
            /** @var \Laravel\Socialite\Two\AbstractProvider $googleProvider */
            $googleUser = $googleProvider->stateless()->user();

            $user = User::firstOrNew(['email' => $googleUser->getEmail()]);

            if (!$user->exists) {
                // User baru → isi data awal dari Google
                $user->name     = $googleUser->getName();
                $user->password = bcrypt(\Illuminate\Support\Str::random(16));
                $user->role     = 'user';
            }

            // google_id aman diupdate tiap login (untuk jaga-jaga kalau belum tersimpan)
            $user->google_id = $googleUser->getId();
            $user->save();

            Auth::login($user, true);

            return match ($user->role) {
                'admin'   => redirect()->route('admin.dashboard')->with('login_success', true),
                'relawan' => redirect()->route('relawan.dashboard')->with('login_success', true),
                default   => redirect()->route('user.dashboard')->with('login_success', true),
            };


        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Login Google gagal, silakan coba lagi.',
            ]);
        }
    }
    public function redirect()
    {
        $googleProvider = Socialite::driver('google');
        /** @var \Laravel\Socialite\Two\AbstractProvider $googleProvider */
        return $googleProvider->stateless()->redirect();
    }
}