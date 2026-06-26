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
            'nik'            => ['required', 'digits:16', 'unique:users,nik'],
            'jenis_kelamin'  => ['required', 'in:L,P'],
            'tanggal_lahir'  => ['required', 'date', 'before:-17 years'],
            'phone'          => ['required', 'digits_between:10,15'],
            'alamat'         => ['required', 'string', 'max:500'],
            'keahlian'       => ['required', 'array', 'min:1'],
            'keahlian.*'     => ['in:medis,logistik,evakuasi,psikologi,dokumentasi,it,dapur,lainnya'],
            'pengalaman'     => ['nullable', 'string', 'max:1000'],
            'email'          => ['required', 'email', 'unique:users,email'],
            'password'       => ['required', 'min:8', 'confirmed'],
            'foto_ktp'       => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'setuju'         => ['accepted'],
        ], [
            'name.required'          => 'Nama lengkap wajib diisi.',
            'name.max'               => 'Nama maksimal 255 karakter.',
 
            'nik.required'           => 'NIK wajib diisi.',
            'nik.digits'             => 'NIK harus tepat 16 digit angka.',
            'nik.unique'             => 'NIK ini sudah terdaftar.',
 
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'       => 'Jenis kelamin tidak valid.',
 
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'     => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before'   => 'Usia minimal pendaftaran relawan adalah 17 tahun.',
 
            'phone.required'         => 'Nomor HP wajib diisi.',
            'phone.digits_between'   => 'Nomor HP harus 10–15 digit angka.',
 
            'alamat.required'        => 'Alamat domisili wajib diisi.',
            'alamat.max'             => 'Alamat maksimal 500 karakter.',
 
            'keahlian.required'      => 'Pilih minimal satu bidang keahlian.',
            'keahlian.min'           => 'Pilih minimal satu bidang keahlian.',
            'keahlian.*.in'          => 'Bidang keahlian yang dipilih tidak valid.',
 
            'pengalaman.max'         => 'Pengalaman maksimal 1000 karakter.',
 
            'email.required'         => 'Alamat email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'email.unique'           => 'Email ini sudah terdaftar, gunakan email lain.',
 
            'password.required'      => 'Kata sandi wajib diisi.',
            'password.min'           => 'Kata sandi minimal 8 karakter.',
            'password.confirmed'     => 'Konfirmasi kata sandi tidak cocok.',
 
            'foto_ktp.image'         => 'File foto KTP harus berupa gambar.',
            'foto_ktp.mimes'         => 'Foto KTP harus berformat JPG atau PNG.',
            'foto_ktp.max'           => 'Ukuran foto KTP maksimal 2MB.',
 
            'setuju.accepted'        => 'Anda harus menyetujui Syarat & Ketentuan SIGANA.',
        ]);

        // Upload foto KTP jika ada
        $fotoKtpPath = null;
        if ($request->hasFile('foto_ktp')) {
            $fotoKtpPath = $request->file('foto_ktp')
                ->store('relawan/ktp', 'public');
        }
        // Buat user dengan role relawan & status pending
        $user = User::create([
            'name'           => $request->name,
            'nik'            => $request->nik,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'phone'          => $request->phone,
            'alamat'         => $request->alamat,
            'keahlian'       => json_encode($request->keahlian),
            'pengalaman'     => $request->pengalaman,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'foto_ktp'       => $fotoKtpPath,
            'role'           => 'relawan',
            'status'         => 'pending', // menunggu verifikasi admin
        ]);
 
        Auth::login($user);
        return redirect()->route('relawan.dashboard');
    
    }
}