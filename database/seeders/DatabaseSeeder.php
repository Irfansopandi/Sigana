<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::truncate();
        // Dummy per role
        User::create([
            'name'     => 'Admin SIGANA',
            'email'    => 'admin@sigana.com',
            'phone'    => '081111111111',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Relawan SIGANA',
            'email'    => 'relawan@sigana.com',
            'phone'    => '082222222222',
            'password' => Hash::make('password'),
            'role'     => 'relawan',
        ]);

        User::create([
            'name'     => 'User SIGANA',
            'email'    => 'user@sigana.com',
            'phone'    => '083333333333',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        $this->call([
            DataBencanaSeeder::class,
            LaporanTransparansiSeeder::class,
        ]);
    }
}