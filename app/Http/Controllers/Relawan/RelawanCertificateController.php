<?php

namespace App\Http\Controllers\Relawan;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\VolunteerCertificate;
use Illuminate\Support\Facades\Auth;

class RelawanCertificateController extends Controller
{
    /**
     * Tampilkan sertifikat milik relawan yang sedang login untuk kampanye tertentu.
     */
    public function show(Campaign $campaign)
    {
        $certificate = VolunteerCertificate::with('campaign')
            ->where('user_id', Auth::id())
            ->where('assignment_id', $campaign->id)
            ->first();

        // Sertifikat belum diterbitkan admin — tampilkan halaman dengan pesan,
        // bukan error 404, karena ini kondisi normal (menunggu admin upload).
        return view('relawan.sertifikat', compact('certificate', 'campaign'));
    }
}