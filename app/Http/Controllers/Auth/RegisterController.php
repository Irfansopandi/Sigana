<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.registrasi');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'phone'    => ['required', 'digits_between:10,15'],
            'password' => ['required', 'min:8', 'confirmed'],
            'agree'    => ['accepted'],
        ], [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'name.max'          => 'Nama lengkap maksimal 255 karakter.',

            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format alamat email tidak valid.',
            'email.unique'      => 'Email ini sudah terdaftar, silakan gunakan email lain.',

            'phone.required'        => 'Nomor HP wajib diisi.',
            'phone.digits_between'  => 'Nomor HP harus berupa angka, minimal 10 dan maksimal 15 digit.',

            'password.required'  => 'Kata sandi wajib diisi.',
            'password.min'        => 'Kata sandi minimal 8 karakter.',
            'password.confirmed'  => 'Konfirmasi kata sandi tidak cocok.',

            'agree.accepted'    => 'Anda harus menyetujui Syarat & Ketentuan SIGANA.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'user', // default
        ]);

        Auth::login($user);

        return redirect()->route('user.dashboard')
            ->with('register_success', $user->name);
    }

    // Registrasi relawan
    public function showRelawan()
    {
        return view('auth.register-relawan');
    }

    public function storeRelawan(Request $request) 
    {
        $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'jenis_kelamin'  => ['required', 'in:L,P'],
            'tanggal_lahir'  => ['required', 'date', 'before:-17 years'],
            'phone'          => ['required', 'digits_between:10,15'],
            'email'          => ['required', 'email', 'unique:users,email'],
            'password'       => ['required', 'min:8', 'confirmed'],
            'setuju'         => ['accepted'],
        ], [
            'name.required'          => 'Nama lengkap wajib diisi.',
            'name.max'               => 'Nama maksimal 255 karakter.',
 
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'       => 'Jenis kelamin tidak valid.',
 
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'     => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before'   => 'Usia minimal pendaftaran relawan adalah 17 tahun.',
 
            'phone.required'         => 'Nomor HP wajib diisi.',
            'phone.digits_between'   => 'Nomor HP harus 10–15 digit angka.',
 
            'email.required'         => 'Alamat email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'email.unique'           => 'Email ini sudah terdaftar, gunakan email lain.',
 
            'password.required'      => 'Kata sandi wajib diisi.',
            'password.min'           => 'Kata sandi minimal 8 karakter.',
            'password.confirmed'     => 'Konfirmasi kata sandi tidak cocok.',
 
            'setuju.accepted'        => 'Anda harus menyetujui Syarat & Ketentuan SIGANA.',
        ]);

        // Buat user dengan role relawan & status pending
        $user = User::create([
            'name'           => $request->name,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'phone'          => $request->phone,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'role'           => 'relawan',
            'status'         => 'pending', // menunggu verifikasi admin
        ]);
 
        Auth::login($user);
        return redirect()->route('relawan.dashboard');
    }
}
