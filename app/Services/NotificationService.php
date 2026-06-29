<?php
namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    // Kampanye disetujui admin
    public static function campaignApproved($campaign)
    {
        Notification::create([
            'user_id' => $campaign->submitted_by,
            'type'    => 'campaign_approved',
            'title'   => 'Laporan Disetujui',
            'message' => "Laporan bencana \"{$campaign->title}\" telah disetujui oleh admin.",
            'url'     => route('user.lapor-bencana'),
        ]);
    }

    // Kampanye ditolak admin
    public static function campaignRejected($campaign)
    {
        Notification::create([
            'user_id' => $campaign->submitted_by,
            'type'    => 'campaign_rejected',
            'title'   => 'Laporan Ditolak',
            'message' => "Laporan bencana \"{$campaign->title}\" ditolak oleh admin.",
            'url'     => route('user.lapor-bencana'),
        ]);
    }

    // Donasi berhasil
    public static function donationSuccess($donation)
    {
        Notification::create([
            'user_id' => $donation->user_id,
            'type'    => 'donation_success',
            'title'   => 'Donasi Berhasil',
            'message' => "Donasi sebesar Rp " . number_format((float) $donation->getRawOriginal('amount'), 0, ',', '.') . " berhasil dikirim.",
            'url'     => route('user.donation-history'),
        ]);
    }

    // Transparansi dana diupdate
    public static function transparencyUpdated($report)
    {
        // Kirim ke semua user yang punya donasi di campaign ini
        $userIds = \App\Models\Donation::where('campaign_id', $report->campaign_id)
            ->where('payment_status', 'success')
            ->whereNotNull('user_id')
            ->pluck('user_id')
            ->unique();

        foreach ($userIds as $userId) {
            Notification::create([
                'user_id' => $userId,
                'type'    => 'transparency_update',
                'title'   => 'Laporan Transparansi Dana',
                'message' => "Laporan transparansi dana untuk kampanye \"{$report->campaign->title}\" telah diperbarui.",
                'url'     => route('user.transparency'),
            ]);
        }
    }

    // Kampanye baru disetujui (notif ke semua user)
    public static function newCampaignPublished($campaign)
    {
        $users = User::where('role', 'user')->get();
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'type'    => 'new_campaign',
                'title'   => 'Kampanye Bencana Baru',
                'message' => "Kampanye bencana baru \"{$campaign->title}\" telah dibuka. Yuk bantu!",
                'url'     => route('bencana.detail', $campaign->slug),
            ]);
        }
    }
}