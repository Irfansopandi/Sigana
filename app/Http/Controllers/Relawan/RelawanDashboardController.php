<?php

namespace App\Http\Controllers\Relawan;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\TransparencyReport;
use App\Models\CampaignVolunteer;
use Illuminate\Support\Facades\Auth;

class RelawanDashboardController extends Controller
{
    public function index()
    {
        return view('relawan.dashboard');
    }

    public function bencana()
    {
        $campaigns = Campaign::where('report_status', 'disetujui')
            ->with('transparencyReport')
            ->latest()
            ->get()
            ->reject(fn($c) => $c->is_expired)
            ->values();

        $joinedCampaignIds = CampaignVolunteer::where('user_id', Auth::id())
            ->pluck('campaign_id')
            ->toArray();

        return view('relawan.bencana', compact('campaigns', 'joinedCampaignIds'));
    }

    public function bencanaDiikuti()
    {
        $volunteerCampaigns = CampaignVolunteer::where('user_id', Auth::id())
            ->with('campaign.transparencyReport')
            ->latest()
            ->get();

        $stats = [
            'total'   => $volunteerCampaigns->count(),
            'aktif'   => $volunteerCampaigns->filter(fn($cv) => $cv->campaign && !$cv->campaign->is_expired)->count(),
            'selesai' => $volunteerCampaigns->filter(fn($cv) => $cv->campaign && $cv->campaign->is_expired)->count(),
        ];

        // Pass full pivot records (with is_coordinator flag) instead of just Campaign objects
        $campaigns = $volunteerCampaigns
            ->filter(fn($cv) => $cv->campaign && !$cv->campaign->is_expired)
            ->values();

        return view('relawan.bencana-diikuti', compact('campaigns', 'stats'));
    }

    public function bencanaDiikutiSelesai()
    {
        $volunteerCampaigns = CampaignVolunteer::where('user_id', Auth::id())
            ->with('campaign.transparencyReport')
            ->latest()
            ->get();

        $stats = [
            'total'   => $volunteerCampaigns->count(),
            'aktif'   => $volunteerCampaigns->filter(fn($cv) => $cv->campaign && !$cv->campaign->is_expired)->count(),
            'selesai' => $volunteerCampaigns->filter(fn($cv) => $cv->campaign && $cv->campaign->is_expired)->count(),
        ];

        $campaigns = $volunteerCampaigns->map(fn($cv) => $cv->campaign)
            ->filter(fn($c) => $c && $c->is_expired)
            ->values();

        return view('relawan.bencana-diikuti-selesai', compact('campaigns', 'stats'));
    }

    public function bencanaDiikutiDetail(Campaign $campaign)
    {
        // Ambil semua relawan yang diterima (verifikasi = diterima), eager-load user & role
        $volunteers = CampaignVolunteer::where('campaign_id', $campaign->id)
            ->where('verifikasi', 'diterima')
            ->with(['user', 'role'])
            ->get();

        // Pisahkan koordinator dari relawan biasa
        $coordinator = $volunteers->first(fn($cv) => $cv->is_coordinator);

        // Kelompokkan relawan NON-koordinator per nama tugas
        $grouped = $volunteers
            ->filter(fn($cv) => !$cv->is_coordinator)
            ->groupBy(function ($cv) {
                return $cv->role?->nama ?? ($cv->tugas_lain ?: 'Tanpa Tugas');
            });

        return view('relawan.bencana-diikuti-detail', compact('campaign', 'grouped', 'coordinator'));
    }

    public function transparansi()
    {
        $campaigns = Campaign::whereHas('transparencyReport')
            ->with('transparencyReport')
            ->latest()
            ->get();

        return view('relawan.transparansi', compact('campaigns'));
    }

    public function show(TransparencyReport $report)
    {
        $report->load(['campaign', 'allocations', 'timeline', 'docs', 'evidence']);

        return view('relawan.transparansi-detail', compact('report'));
    }

    
}