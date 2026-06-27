<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class AdminDonationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search  = $request->get('search');

        $query = Donation::where('payment_status', 'success')->latest();

        if ($search) {
            $query->where('name', 'like', "%$search%");
        }

        $donations = $query->paginate($perPage)->withQueryString();

        $stats = [
            'total_donatur' => Donation::where('payment_status', 'success')->count(),
            'total_nominal' => Donation::where('payment_status', 'success')->sum('amount'),
        ];

        return view('admin.donations.index', compact('donations', 'stats', 'perPage', 'search'));
    }
}