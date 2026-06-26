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
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name'      => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'password'  => bcrypt(\Illuminate\Support\Str::random(16)),
                    'role'      => 'user',
                ]
            );

            Auth::login($user, true);

            return redirect()->route('user.dashboard')
                ->with('login_success', true);

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Login Google gagal, silakan coba lagi.',
            ]);
        }
    }
    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }
}