<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'campaigns' => Campaign::count(),
            'active_campaigns' => Campaign::where('status', 'Aktif')->count(),
            'volunteers' => User::where('role', 'relawan')->count(),
            'donations' => Donation::where('payment_status', 'success')->sum('amount'),
            'success_donations' => Donation::where('payment_status', 'success')->count(),
        ];

        $recentUsers = User::latest()->take(3)->get();
        $recentCampaigns = Campaign::latest()->take(3)->get();
        $recentDonations = Donation::where('payment_status', 'success')->latest()->take(3)->get();

        $recentActivities = collect([
            [
                'type' => 'user',
                'icon' => 'fa-solid fa-user-plus',
                'title' => 'Pengguna baru terdaftar',
                'description' => $recentUsers->first()?->name ? $recentUsers->first()->name . ' bergabung sebagai ' . $recentUsers->first()->role : 'Belum ada aktivitas pengguna',
                'time' => $recentUsers->first()?->created_at?->diffForHumans() ?? '-',
            ],
            [
                'type' => 'campaign',
                'icon' => 'fa-solid fa-hand-holding-heart',
                'title' => 'Kampanye terbaru dibuat',
                'description' => $recentCampaigns->first()?->title ?? 'Belum ada kampanye baru',
                'time' => $recentCampaigns->first()?->created_at?->diffForHumans() ?? '-',
            ],
            [
                'type' => 'donation',
                'icon' => 'fa-solid fa-coins',
                'title' => 'Donasi berhasil masuk',
                'description' => $recentDonations->first()?->name ? $recentDonations->first()->name . ' berdonasi ' . $recentDonations->first()->amount : 'Belum ada donasi berhasil',
                'time' => $recentDonations->first()?->created_at?->diffForHumans() ?? '-',
            ],
        ]);

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentCampaigns', 'recentDonations', 'recentActivities'));
    }
}