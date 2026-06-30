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
        // Hanya kampanye aktif (belum expired)
        $campaigns = Campaign::where('report_status', 'disetujui')
            ->orderByDesc('date_published')
            ->get()
            ->filter(fn($c) => !$c->is_expired)
            ->take(3)
            ->values();

        $transparansi = Campaign::where('report_status', 'disetujui')
            ->has('transparencyReport')
            ->with('transparencyReport')
            ->orderByDesc('date_published')
            ->get()
            ->filter(fn($c) => !$c->is_expired)
            ->take(3)
            ->values();

        $totalDonasi        = Campaign::where('report_status', 'disetujui')->sum('collected_raw');
        $totalDonatur       = \App\Models\Donation::count();
        $totalKampanye      = Campaign::where('report_status', 'disetujui')->get()->filter(fn($c) => !$c->is_expired)->count();
        $totalKorbanTerbantu = \App\Models\TransparencyReport::sum('beneficiaries');

        // Mapbox markers — hanya campaign aktif yang punya koordinat
        $campaignMarkers = Campaign::where('report_status', 'disetujui')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->filter(fn($c) => !$c->is_expired)
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
            ])
            ->values();

        return view('home.index', compact(
            'campaigns', 'transparansi',
            'totalDonasi', 'totalDonatur',
            'totalKampanye', 'totalKorbanTerbantu',
            'campaignMarkers'
        ));
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
        // Filter expired di PHP karena days_left adalah accessor
        $campaigns = Campaign::where('report_status', 'disetujui')
            ->orderByDesc('date_published')
            ->get()
            ->filter(fn($c) => !$c->is_expired)
            ->values();

        return view('bencana.index', compact('campaigns'));
    }

    /**
     * Tampilkan halaman Donasi Bencana.
     */
    public function bencanaDonasiPage($slug)
    {
        $campaign = Campaign::where('slug', $slug)
            ->where('report_status', 'disetujui')
            ->firstOrFail();

        // Blokir akses donasi kalau kampanye sudah selesai
        if ($campaign->is_expired) {
            return redirect()->route('bencana')->with('error', 'Kampanye ini sudah berakhir dan tidak menerima donasi.');
        }

        return view('bencana.donasi', compact('campaign'));
    }

    /**
     * Tampilkan halaman Transparansi Donasi.
     */
    public function transparansi()
    {
        $campaigns = Campaign::where('report_status', 'disetujui')
            ->with('transparencyReport')
            ->orderByDesc('date_published')
            ->get();

        $totalCollected  = $campaigns->sum('collected_raw');
        $totalUsed       = $campaigns->sum(fn($c) => $c->transparencyReport?->getRawOriginal('used') ?? 0);
        $totalRemaining  = $totalCollected - $totalUsed;
        $totalDonors     = \App\Models\Donation::count();

        return view('transparansi.index', compact(
            'campaigns', 'totalCollected',
            'totalUsed', 'totalRemaining', 'totalDonors'
        ));
    }

    /**
     * Tampilkan halaman detail transparansi bencana tertentu.
     */
    public function transparansiDetail($slug)
    {
        $campaign = Campaign::where('slug', $slug)
            ->where('report_status', 'disetujui')
            ->firstOrFail();

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