<?php

namespace App\Http\Controllers\Relawan;

use App\Http\Controllers\Controller;

class RelawanDashboardController extends Controller
{
    public function index()
    {
        return view('relawan.dashboard');
    }
}