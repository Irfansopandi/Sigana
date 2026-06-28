<?php

namespace App\Http\Controllers;
use App\Models\Campaign;
use App\Models\TransparencyReport;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman Beranda.
     */
    public function index()
    {

        $campaigns = Campaign::orderByDesc('date_published')->take(3)->get();
        $transparansi = Campaign::with('transparencyReport')->orderByDesc('date_published')->take(3)->get();
        $totalDonasi = Campaign::sum('collected_raw');
        $totalDonatur = \App\Models\Donation::count();
        $totalKampanye = Campaign::count();
        $totalKorbanTerbantu = \App\Models\TransparencyReport::sum('beneficiaries');

        // Mapbox markers — hanya campaign yang punya koordinat
        $campaignMarkers = Campaign::whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get()
        ->map(fn($c) => [
            'title'     => $c->title,
            'location'  => $c->location,
            'status'    => $c->status,
            'category'  => $c->category,
            'slug'      => $c->slug,
            'latitude'  => (float) $c->latitude,
            'longitude' => (float) $c->longitude,
            'collected' => $c->collected,
            'progress'  => $c->progress,
        ]);

        return view('home.index', compact('campaigns','transparansi', 'totalDonasi', 'totalDonatur', 'totalKampanye','totalKorbanTerbantu','campaignMarkers'));
    }

    /**
     * Tampilkan halaman Tentang Kami.
     */
    public function tentang()
    {
        return view('tentang.index');
    }

    /**
     * Tampilkan halaman Daftar Bencana.
     */
    public function bencana()
    {
        $campaigns = Campaign::orderByDesc('date_published')->get();
        return view('bencana.index', compact('campaigns'));    }


    /**
     * Tampilkan halaman Donasi Bencana.
     */
    public function bencanaDonasiPage($slug)
    {
        $campaign = Campaign::where('slug', $slug)->firstOrFail();

        return view('bencana.donasi', compact('campaign'));
    }

    /**
     * Tampilkan halaman Transparansi Donasi.
     */
    public function transparansi()
    {
        $campaigns = Campaign::with('transparencyReport')->orderByDesc('date_published')->get();

        $totalCollected = $campaigns->sum('collected_raw');
        $totalUsed = $campaigns->sum(fn($c) => $c->transparencyReport->getRawOriginal('used') ?? 0);
        $totalRemaining = $totalCollected - $totalUsed;
        $totalDonors = \App\Models\Donation::count();

        return view('transparansi.index', compact('campaigns', 'totalCollected', 'totalUsed', 'totalRemaining', 'totalDonors'));
    }

    

    /**
     * Tampilkan halaman detail transparansi bencana tertentu.
     */
    public function transparansiDetail($slug)
    {
        $campaign = Campaign::where('slug', $slug)->firstOrFail();

        $report = TransparencyReport::with(['allocations', 'timeline', 'evidence', 'docs'])
            ->where('campaign_id', $campaign->id)
            ->firstOrFail();

        return view('transparansi.detail', compact('campaign', 'report'));
    }

    /**
     * Tampilkan halaman Kontak Kami.
     */
    public function kontak()
    {
        return view('kontak.index');
    }

}
