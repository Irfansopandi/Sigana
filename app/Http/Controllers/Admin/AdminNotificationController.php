<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\CoordinatorReport;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    public function unread(Request $request)
    {
        $notifications = collect();

        // 1. Laporan bencana menunggu verifikasi
        $pendingReports = Campaign::where('report_status', 'menunggu')
            ->latest()
            ->take(5)
            ->get();

        foreach ($pendingReports as $report) {
            $notifications->push([
                'type'    => 'campaign_pending',
                'title'   => 'Laporan Bencana Baru',
                'message' => "\"{$report->title}\" menunggu verifikasi.",
                'url'     => route('admin.campaigns.show', $report->id),
                'time'    => $report->created_at,
            ]);
        }

        // 2. Donasi sukses terbaru
        $recentDonations = Donation::where('payment_status', 'success')
            ->latest()
            ->take(5)
            ->get();

        foreach ($recentDonations as $donation) {
            $notifications->push([
                'type'    => 'donation_success',
                'title'   => 'Donasi Berhasil',
                'message' => "{$donation->name} berdonasi Rp " . number_format((float) $donation->getRawOriginal('amount'), 0, ',', '.'),
                'url'     => route('admin.donations.index'),
                'time'    => $donation->created_at,
            ]);
        }

        // 3. Laporan koordinator menunggu verifikasi
        $pendingCoordinatorReports = CoordinatorReport::where('status', 'menunggu')
            ->with('campaign')
            ->latest()
            ->take(5)
            ->get();

        foreach ($pendingCoordinatorReports as $coordReport) {
            $notifications->push([
                'type'    => 'coordinator_report',
                'title'   => 'Laporan Koordinator',
                'message' => "Laporan untuk \"{$coordReport->campaign->title}\" menunggu verifikasi.",
                'url'     => route('admin.coordinator-reports.show', $coordReport->id),
                'time'    => $coordReport->created_at,
            ]);
        }

        // 4. Kampanye yang sudah expired tapi belum berstatus Selesai
        $expiredCampaigns = Campaign::where('report_status', 'disetujui')
            ->where('status', '!=', 'Selesai')
            ->get()
            ->filter(fn($c) => $c->is_expired)
            ->take(5);

        foreach ($expiredCampaigns as $campaign) {
            $notifications->push([
                'type'    => 'campaign_expired',
                'title'   => 'Kampanye Selesai Waktu',
                'message' => "Kampanye \"{$campaign->title}\" sudah melewati batas waktu.",
                'url'     => route('admin.campaigns.show', $campaign->id),
                'time'    => $campaign->updated_at,
            ]);
        }

        $sorted = $notifications->sortByDesc('time')->values()->take(10);

        return response()->json([
            'count'         => $sorted->count(),
            'notifications' => $sorted,
        ]);
    }

    public function index()
    {
        $notifications = collect();

        $pendingReports = Campaign::where('report_status', 'menunggu')->latest()->get();
        foreach ($pendingReports as $report) {
            $notifications->push([
                'type'    => 'campaign_pending',
                'title'   => 'Laporan Bencana Baru',
                'message' => "\"{$report->title}\" menunggu verifikasi.",
                'url'     => route('admin.campaigns.show', $report->id),
                'time'    => $report->created_at,
            ]);
        }

        $recentDonations = Donation::where('payment_status', 'success')->latest()->take(20)->get();
        foreach ($recentDonations as $donation) {
            $notifications->push([
                'type'    => 'donation_success',
                'title'   => 'Donasi Berhasil',
                'message' => "{$donation->name} berdonasi Rp " . number_format((float) $donation->getRawOriginal('amount'), 0, ',', '.'),
                'url'     => route('admin.donations.index'),
                'time'    => $donation->created_at,
            ]);
        }

        $pendingCoordinatorReports = CoordinatorReport::where('status', 'menunggu')->with('campaign')->latest()->get();
        foreach ($pendingCoordinatorReports as $coordReport) {
            $notifications->push([
                'type'    => 'coordinator_report',
                'title'   => 'Laporan Koordinator',
                'message' => "Laporan untuk \"{$coordReport->campaign->title}\" menunggu verifikasi.",
                'url'     => route('admin.coordinator-reports.show', $coordReport->id),
                'time'    => $coordReport->created_at,
            ]);
        }

        $expiredCampaigns = Campaign::where('report_status', 'disetujui')
            ->where('status', '!=', 'Selesai')
            ->get()
            ->filter(fn($c) => $c->is_expired);
        foreach ($expiredCampaigns as $campaign) {
            $notifications->push([
                'type'    => 'campaign_expired',
                'title'   => 'Kampanye Selesai Waktu',
                'message' => "Kampanye \"{$campaign->title}\" sudah melewati batas waktu.",
                'url'     => route('admin.campaigns.show', $campaign->id),
                'time'    => $campaign->updated_at,
            ]);
        }

        $sorted = $notifications->sortByDesc('time')->values();

        return view('admin.notifications.index', compact('sorted'));
    }
}