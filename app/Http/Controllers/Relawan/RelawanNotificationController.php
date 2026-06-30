<?php

namespace App\Http\Controllers\Relawan;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignVolunteer;
use Illuminate\Support\Facades\Auth;

class RelawanNotificationController extends Controller
{
    /**
     * Kembalikan JSON notifikasi untuk dropdown bell di topbar relawan.
     */
    public function unread()
    {
        $user = Auth::user();
        $notifications = collect();

        // 1. Verifikasi akun relawan oleh admin
        //    Indikator: email_verified_at terisi (set oleh admin)
        if (!is_null($user->email_verified_at)) {
            $notifications->push([
                'type'    => 'account_verified',
                'title'   => 'Akun Diverifikasi ✅',
                'message' => 'Akun relawan Anda telah diverifikasi oleh admin. Selamat bergabung!',
                'url'     => route('relawan.dashboard'),
                'time'    => $user->email_verified_at,
            ]);
        } else {
            $notifications->push([
                'type'    => 'account_pending',
                'title'   => 'Menunggu Verifikasi',
                'message' => 'Akun Anda sedang dalam proses verifikasi admin (1–3 hari kerja).',
                'url'     => route('relawan.dashboard'),
                'time'    => $user->created_at,
            ]);
        }

        // 2. Status penerimaan relawan di setiap kampanye bencana
        $joins = CampaignVolunteer::where('user_id', $user->id)
            ->with('campaign')
            ->latest()
            ->take(10)
            ->get();

        foreach ($joins as $join) {
            if (!$join->campaign) continue;

            // Notifikasi ditunjuk jadi Koordinator
            if ($join->is_coordinator && $join->verifikasi === 'diterima') {
                $notifications->push([
                    'type'    => 'coordinator_appointed',
                    'title'   => 'Ditunjuk sebagai Koordinator 🌟',
                    'message' => "Selamat! Anda ditunjuk sebagai Koordinator di kampanye \"{$join->campaign->title}\".",
                    'url'     => route('relawan.bencana-diikuti'),
                    'time'    => $join->updated_at,
                ]);
            }

            if ($join->verifikasi === 'diterima') {
                $notifications->push([
                    'type'    => 'join_accepted',
                    'title'   => 'Pendaftaran Diterima 🎉',
                    'message' => "Anda telah diterima sebagai relawan di \"{$join->campaign->title}\".",
                    'url'     => route('relawan.bencana-diikuti'),
                    'time'    => $join->updated_at,
                ]);
            } elseif ($join->verifikasi === 'ditolak') {
                $notifications->push([
                    'type'    => 'join_rejected',
                    'title'   => 'Pendaftaran Ditolak',
                    'message' => "Mohon maaf, pendaftaran Anda di \"{$join->campaign->title}\" tidak dapat diterima.",
                    'url'     => route('relawan.bencana-diikuti'),
                    'time'    => $join->updated_at,
                ]);
            } elseif ($join->verifikasi === 'menunggu') {
                $notifications->push([
                    'type'    => 'join_pending',
                    'title'   => 'Pendaftaran Sedang Diproses',
                    'message' => "Pendaftaran Anda di \"{$join->campaign->title}\" sedang menunggu verifikasi admin.",
                    'url'     => route('relawan.bencana-diikuti'),
                    'time'    => $join->created_at,
                ]);
            }
        }

        // 2.5. Sertifikat yang sudah diunggah admin
        $certificates = \App\Models\VolunteerCertificate::where('user_id', $user->id)
            ->with('campaign')
            ->latest()
            ->take(10)
            ->get();

        foreach ($certificates as $cert) {
            if (!$cert->campaign) continue;

            $notifications->push([
                'type'    => 'certificate_issued',
                'title'   => 'Sertifikat Telah Diunggah 🎓',
                'message' => "Sertifikat Anda untuk kampanye \"{$cert->campaign->title}\" telah diunggah admin.",
                'url'     => route('relawan.sertifikat', $cert->assignment_id),
                'time'    => $cert->created_at,
            ]);
        }

        // Sertifikat yang sudah diunggah admin
        $certificates = \App\Models\VolunteerCertificate::where('user_id', $user->id)
            ->with('campaign')
            ->latest()
            ->get();

        foreach ($certificates as $cert) {
            if (!$cert->campaign) continue;

            $notifications->push([
                'type'    => 'certificate_issued',
                'title'   => 'Sertifikat Telah Diunggah',
                'message' => "Sertifikat Anda untuk kampanye \"{$cert->campaign->title}\" telah diunggah admin.",
                'url'     => route('relawan.sertifikat', $cert->assignment_id),
                'time'    => $cert->created_at,
            ]);
        }

        // 3. Kampanye bencana baru yang tersedia (belum pernah diikuti relawan ini)
        $joinedIds = CampaignVolunteer::where('user_id', $user->id)->pluck('campaign_id');

        $newCampaigns = Campaign::where('report_status', 'disetujui')
            ->whereNotIn('id', $joinedIds)
            ->latest()
            ->take(5)
            ->get()
            ->reject(fn($c) => $c->is_expired);

        foreach ($newCampaigns as $campaign) {
            $notifications->push([
                'type'    => 'new_campaign',
                'title'   => 'Kampanye Bencana Baru',
                'message' => "Bencana \"{$campaign->title}\" di {$campaign->location} membutuhkan relawan.",
                'url'     => route('relawan.bencana'),
                'time'    => $campaign->created_at,
            ]);
        }

        $sorted = $notifications->sortByDesc('time')->values()->take(10);

        return response()->json([
            'count'         => $sorted->count(),
            'notifications' => $sorted,
        ]);
    }

    /**
     * Tampilkan halaman penuh semua notifikasi relawan.
     */
    public function index()
    {
        $user = Auth::user();
        $notifications = collect();

        // Verifikasi akun
        if (!is_null($user->email_verified_at)) {
            $notifications->push([
                'type'    => 'account_verified',
                'title'   => 'Akun Diverifikasi ✅',
                'message' => 'Akun relawan Anda telah diverifikasi oleh admin. Selamat bergabung!',
                'url'     => route('relawan.dashboard'),
                'time'    => $user->email_verified_at,
            ]);
        } else {
            $notifications->push([
                'type'    => 'account_pending',
                'title'   => 'Menunggu Verifikasi Akun',
                'message' => 'Akun Anda sedang dalam proses verifikasi admin (1–3 hari kerja).',
                'url'     => route('relawan.dashboard'),
                'time'    => $user->created_at,
            ]);
        }

        // Status pendaftaran kampanye (semua)
        $joins = CampaignVolunteer::where('user_id', $user->id)
            ->with('campaign')
            ->latest()
            ->get();

        foreach ($joins as $join) {
            if (!$join->campaign) continue;

            // Notifikasi ditunjuk jadi Koordinator
            if ($join->is_coordinator && $join->verifikasi === 'diterima') {
                $notifications->push([
                    'type'    => 'coordinator_appointed',
                    'title'   => 'Ditunjuk sebagai Koordinator 🌟',
                    'message' => "Selamat! Anda ditunjuk sebagai Koordinator di kampanye \"{$join->campaign->title}\".",
                    'url'     => route('relawan.bencana-diikuti'),
                    'time'    => $join->updated_at,
                ]);
            }

            if ($join->verifikasi === 'diterima') {
                $notifications->push([
                    'type'    => 'join_accepted',
                    'title'   => 'Pendaftaran Diterima',
                    'message' => "Anda telah diterima sebagai relawan di \"{$join->campaign->title}\".",
                    'url'     => route('relawan.bencana-diikuti'),
                    'time'    => $join->updated_at,
                ]);
            } elseif ($join->verifikasi === 'ditolak') {
                $notifications->push([
                    'type'    => 'join_rejected',
                    'title'   => 'Pendaftaran Ditolak',
                    'message' => "Mohon maaf, pendaftaran Anda di \"{$join->campaign->title}\" tidak dapat diterima.",
                    'url'     => route('relawan.bencana-diikuti'),
                    'time'    => $join->updated_at,
                ]);
            } elseif ($join->verifikasi === 'menunggu') {
                $notifications->push([
                    'type'    => 'join_pending',
                    'title'   => 'Pendaftaran Sedang Diproses',
                    'message' => "Pendaftaran Anda di \"{$join->campaign->title}\" sedang menunggu verifikasi admin.",
                    'url'     => route('relawan.bencana-diikuti'),
                    'time'    => $join->created_at,
                ]);
            }
        }

        // Kampanye bencana baru (semua, tidak hanya yg belum diikuti)
        $joinedIds = CampaignVolunteer::where('user_id', $user->id)->pluck('campaign_id');

        $newCampaigns = Campaign::where('report_status', 'disetujui')
            ->whereNotIn('id', $joinedIds)
            ->latest()
            ->get()
            ->reject(fn($c) => $c->is_expired);

        foreach ($newCampaigns as $campaign) {
            $notifications->push([
                'type'    => 'new_campaign',
                'title'   => 'Kampanye Bencana Baru',
                'message' => "Bencana \"{$campaign->title}\" di {$campaign->location} membutuhkan relawan.",
                'url'     => route('relawan.bencana'),
                'time'    => $campaign->created_at,
            ]);
        }

        $sorted = $notifications->sortByDesc('time')->values();

        return view('relawan.notifications.index', compact('sorted'));
    }
}
