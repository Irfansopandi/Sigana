<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminVolunteerController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $status  = $request->get('status', 'all');

        $query = User::where('role', 'relawan')->latest();

        if ($status === 'verified') {
            $query->whereNotNull('email_verified_at');
        } elseif ($status === 'unverified') {
            $query->whereNull('email_verified_at');
        }

        $volunteers = $query->paginate($perPage)->withQueryString();

        $stats = [
            'total'      => User::where('role', 'relawan')->count(),
            'verified'   => User::where('role', 'relawan')->whereNotNull('email_verified_at')->count(),
            'unverified' => User::where('role', 'relawan')->whereNull('email_verified_at')->count(),
        ];

        return view('admin.volunteers.index', compact('volunteers', 'stats', 'status', 'perPage'));
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

        $user->update([
            'email_verified_at' => now(),
            'status'            => 'active',
        ]);
        $user->refresh();

        return redirect()->route('admin.volunteers.index')->with('success', 'Relawan berhasil diverifikasi.');
    }

    public function update(Request $request, User $user)
    {
        if ($user->role !== 'relawan') {
            return redirect()->route('admin.volunteers.index')->with('error', 'Relawan tidak ditemukan.');
        }

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'phone'         => 'nullable|digits_between:8,15',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
        ]);

        $user->update($validated);

        return redirect()->route('admin.volunteers.show', $user)
            ->with('success', 'Data relawan berhasil diperbarui.');
    }
}
