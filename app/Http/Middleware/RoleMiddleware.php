<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $normalizedRole = $user->role ?? 'user';

        $allowedRoles = array_map(function ($role) {
            return strtolower($role);
        }, $roles);

        $userRole = strtolower($normalizedRole);

        if (!in_array($userRole, $allowedRoles) && !in_array('user', $allowedRoles)) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}