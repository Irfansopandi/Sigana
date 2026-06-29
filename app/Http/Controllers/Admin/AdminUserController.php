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

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'phone'         => 'nullable|digits_between:8,15',
            'role'          => 'required|in:user,relawan,admin',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'nik'           => 'nullable|string|max:16',
            'alamat'        => 'nullable|string',
            'pengalaman'    => 'nullable|string',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}