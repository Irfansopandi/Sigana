<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminVolunteerController extends Controller
{
    public function index()
    {
        $volunteers = User::where('role', 'relawan')->latest()->paginate(12);
        return view('admin.volunteers.index', compact('volunteers'));
    }

    public function show(User $user)
    {
        if ($user->role !== 'relawan') {
            return redirect()->route('admin.volunteers.index')->with('error', 'Relawan tidak ditemukan.');
        }

        return view('admin.volunteers.show', compact('user'));
    }

    public function verify(User $user)
    {
        if ($user->role !== 'relawan') {
            return redirect()->route('admin.volunteers.index')->with('error', 'Pengguna bukan relawan.');
        }

        $user->update(['email_verified_at' => now()]);
        $user->refresh();

        return redirect()->route('admin.volunteers.index')->with('success', 'Relawan berhasil diverifikasi.');
    }
}
