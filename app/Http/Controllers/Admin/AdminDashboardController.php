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

        // Garfik 1: status bencana
        $statsChart = Campaign::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total','status')
            ->toArray();

        $statsChart = array_merge([
            'Darurat' => 0,
            'Waspada' => 0,
            'Aktif'   => 0,
            'Selesai' => 0,
        ], $statsChart);

        // Garik 2: Donasi per kampanye (top 6)
        $donationChart = Donation::where('payment_status', 'success')
            ->join('campaigns', 'donations.campaign_id', '=', 'campaigns.id')
            ->selectRaw('campaigns.title, SUM(donations.amount) as total')
            ->groupBy('campaigns.id', 'campaigns.title')
            ->orderByDesc('total')
            ->get();

        $recentUsers = User::latest()->take(5)->get();
        $recentCampaigns = Campaign::latest()->take(5)->get();
        $recentDonations = Donation::where('payment_status', 'success')->latest()->take(5)->get();

        $recentActivities = collect();
            foreach ($recentUsers as $user) {
            $recentActivities->push([
                'type'        => 'user',
                'icon'        => 'fa-solid fa-user-plus',
                'title'       => 'Pengguna baru terdaftar',
                'description' => $user->name . ' bergabung sebagai ' . $user->role,
                'time'        => $user->created_at->diffForHumans(),
            ]);
        }

        foreach ($recentCampaigns as $campaign) {
            $recentActivities->push([
                'type'        => 'campaign',
                'icon'        => 'fa-solid fa-hand-holding-heart',
                'title'       => 'Kampanye terbaru dibuat',
                'description' => $campaign->title,
                'time'        => $campaign->created_at->diffForHumans(),
            ]);
        }

        foreach ($recentDonations as $donation) {
            $recentActivities->push([
                'type'        => 'donation',
                'icon'        => 'fa-solid fa-coins',
                'title'       => 'Donasi berhasil masuk',
                'description' => $donation->name . ' berdonasi Rp ' . number_format(( float)$donation->getRawOriginal('amount'), 0, ',', '.'),
                'time'        => $donation->created_at->diffForHumans(),
            ]);
        }

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentCampaigns', 'recentDonations', 'recentActivities','statsChart', 'donationChart'));
    }
}