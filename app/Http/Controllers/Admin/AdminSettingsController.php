<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminSettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }
}
