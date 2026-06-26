<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (request()->header('x-forwarded-proto') === 'https') {
        URL::forceScheme('https');
        }
        Blade::if('admin', function () {
            $user = Auth::user();
            return $user instanceof User && $user->isAdmin();
        });

        Blade::if('relawan', function () {
            $user = Auth::user();
            return $user instanceof User && $user->isRelawan();
        });

        Blade::if('isuser', function () {
            $user = Auth::user();
            return $user instanceof User && $user->isUser();
        });
    }
}