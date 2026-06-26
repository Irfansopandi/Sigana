<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;

class AdminDonationController extends Controller
{
    public function index()
    {
        $donations = Donation::latest()->paginate(12);
        return view('admin.donations.index', compact('donations'));
    }
}
