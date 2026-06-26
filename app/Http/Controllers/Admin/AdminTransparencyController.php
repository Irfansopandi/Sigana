<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransparencyReport;

class AdminTransparencyController extends Controller
{
    public function index()
    {
        $reports = TransparencyReport::latest()->paginate(10);
        return view('admin.transparency.index', compact('reports'));
    }
}
