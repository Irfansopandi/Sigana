<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminSettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function profile()
    {
        return view('admin.settings.profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini salah']);
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function system()
    {
        return view('admin.settings.system');
    }

    public function updateSystem(Request $request)
    {
        // Untuk saat ini, kita hanya kembalikan pesan sukses
        // Di masa depan, ini bisa menyimpan ke database atau file konfigurasi
        
        return back()->with('success', 'Pengaturan sistem berhasil disimpan');
    }
}
