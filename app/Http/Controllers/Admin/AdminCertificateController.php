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
    // Index: kampanye yang progress donasi = 100%
    public function index(Request $request)
    {
        $perPage = request('per_page', 10);

        $allCampaigns = Campaign::withCount([
            'volunteers as relawan_diterima' => fn($q) => $q->where('verifikasi', 'diterima'),
        ])
        ->when($request->search, fn($q, $s) => $q->where('title', 'like', "%$s%"))
        ->get()
        ->filter(function ($c) {
            $target = $c->getRawOriginal('target_amount') ?? $c->target_amount;
            $collected = $c->getRawOriginal('collected_amount') ?? $c->collected_amount;
            return $target > 0 && $collected >= $target;
        })->values();

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

    // Detail: relawan diterima dalam kampanye ini
    public function show(Campaign $campaign, Request $request)
    {
        $perPage = request('per_page', 10);

        $volunteers = CampaignVolunteer::with(['user', 'role'])
            ->where('campaign_id', $campaign->id)
            ->where('verifikasi', 'diterima')
            ->when($request->search, function ($q, $s) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%$s%"));
            })
            ->paginate($perPage)
            ->withQueryString();

        $certMap = VolunteerCertificate::where('assignment_id', $campaign->id)
            ->pluck('id', 'user_id');

        return view('admin.certificates.show', compact('campaign', 'volunteers', 'certMap'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'       => 'required|exists:users,id',
            'assignment_id' => 'required|exists:campaigns,id',
            'title'         => 'required|string|max:150',
            'file'          => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'issued_at'     => 'required|date',
            'notes'         => 'nullable|string',
        ]);

        $path = $request->file('file')->store('certificates', 'public');

        VolunteerCertificate::create([
            'user_id'       => $validated['user_id'],
            'assignment_id' => $validated['assignment_id'],
            'title'         => $validated['title'],
            'file'          => $path,
            'issued_at'     => $validated['issued_at'],
            'notes'         => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin.certificates.show', $validated['assignment_id'])
            ->with('success', 'Sertifikat berhasil diberikan.');
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