<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\VolunteerCertificate;
use App\Models\CampaignVolunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCertificateController extends Controller
{
    public function index(Request $request)
    {
        $perPage = request('per_page', 10);

        // Kampanye yang Laporan Transparansinya berstatus "Selesai"
        $allCampaigns = Campaign::with('transparencyReport')
            ->withCount([
                'volunteers as relawan_diterima' => fn($q) => $q->where('verifikasi', 'diterima'),
            ])
            ->whereHas('transparencyReport', fn($q) => $q->where('status', 'Selesai'))
            ->when($request->search, fn($q, $s) => $q->where('title', 'like', "%$s%"))
            ->get();

        $totalKampanye = $allCampaigns->count();
        $totalSertifikat = VolunteerCertificate::count();

        $page = request('page', 1);
        $campaigns = new \Illuminate\Pagination\LengthAwarePaginator(
            $allCampaigns->slice(($page - 1) * $perPage, $perPage)->values(),
            $totalKampanye,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.certificates.index', compact('campaigns', 'totalKampanye', 'totalSertifikat'));
    }

    public function show(Campaign $campaign, Request $request)
    {
        $volunteers = CampaignVolunteer::where('campaign_id', $campaign->id)
            ->where('verifikasi', 'diterima')
            ->with(['user', 'role'])
            ->when($request->search, function ($q, $s) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%$s%"));
            })
            ->get();

        // Koordinator dipisah, tampil sendiri di atas
        $coordinator = $volunteers->first(fn($cv) => $cv->is_coordinator);

        // Sisanya dikelompokkan per bagian tugas (logic sama persis kayak RelawanDashboardController)
        $grouped = $volunteers
            ->filter(fn($cv) => !$cv->is_coordinator)
            ->groupBy(function ($cv) {
                return $cv->role?->nama ?? ($cv->tugas_lain ?: 'Tanpa Tugas');
            });

        $certMap = VolunteerCertificate::where('assignment_id', $campaign->id)
            ->pluck('id', 'user_id');

        return view('admin.certificates.show', compact('campaign', 'coordinator', 'grouped', 'certMap'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'assignment_id' => 'required|exists:campaigns,id',
            'title'         => 'required|string|max:150',
            'issued_at'     => 'required|date',
            'notes'         => 'nullable|string',
            'files'         => 'required|array|min:1',
            'files.*'       => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Pastikan user_id yang dikirim memang relawan diterima di campaign ini (anti-tamper)
        $validUserIds = CampaignVolunteer::where('campaign_id', $validated['assignment_id'])
            ->where('verifikasi', 'diterima')
            ->pluck('user_id')
            ->toArray();

        $count = 0;
        foreach ($validated['files'] as $userId => $file) {
            if (!$file || !in_array($userId, $validUserIds)) continue;

            $path = $file->store('certificates', 'public');

            VolunteerCertificate::updateOrCreate(
                ['user_id' => $userId, 'assignment_id' => $validated['assignment_id']],
                [
                    'title'     => $validated['title'],
                    'file'      => $path,
                    'issued_at' => $validated['issued_at'],
                    'notes'     => $validated['notes'] ?? null,
                ]
            );
            $count++;
        }

        if ($count === 0) {
            return redirect()->back()->with('error', 'Tidak ada file yang diupload.');
        }

        return redirect()->route('admin.certificates.show', $validated['assignment_id'])
            ->with('success', "Sertifikat berhasil diberikan ke {$count} relawan.");
    }

    public function destroy(VolunteerCertificate $certificate)
    {
        if ($certificate->getRawOriginal('file')) {
            Storage::disk('public')->delete($certificate->getRawOriginal('file'));
        }
        $certificate->delete();

        return redirect()->back()->with('success', 'Sertifikat berhasil dihapus.');
    }
}