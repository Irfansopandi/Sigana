<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $role    = $request->get('role', 'all');
        $search  = $request->get('search');

        $query = User::latest();

        if ($role !== 'all') {
            $query->where('role', $role);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $users = $query->paginate($perPage)->withQueryString();

        $stats = [
            'total'   => User::count(),
            'user'    => User::where('role', 'user')->count(),
            'relawan' => User::where('role', 'relawan')->count(),
            'admin'   => User::where('role', 'admin')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats', 'role', 'perPage', 'search'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
}