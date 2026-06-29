<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Models\CampaignVolunteer;
use App\Models\User;
use Illuminate\Http\Request;

class AdminAssignmentController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 10);

        $campaigns = Campaign::withCount([
            'volunteers',
            'volunteers as menunggu_count' => fn($q) => $q->where('verifikasi', 'menunggu'),
            'volunteers as diterima_count'  => fn($q) => $q->where('verifikasi', 'diterima'),
        ])
        ->when(request('search'), fn($q, $s) => $q->where('title', 'like', "%$s%"))
        ->latest()
        ->paginate($perPage)
        ->withQueryString();

        $totalMenunggu = \App\Models\CampaignVolunteer::where('verifikasi', 'menunggu')->count();
        $totalDiterima = \App\Models\CampaignVolunteer::where('verifikasi', 'diterima')->count();
        $totalDitolak  = \App\Models\CampaignVolunteer::where('verifikasi', 'ditolak')->count();

        return view('admin.assignments.index', compact('campaigns','totalMenunggu', 'totalDiterima', 'totalDitolak'));
    }

    public function show(Campaign $campaign)
    {
        $campaign->load(['roles', 'roles.volunteers.user']);

        $perPage = request('per_page', 10);
        $filterTab = request('tab', 'semua');

        $query = $campaign->volunteers()->with(['user', 'role'])->latest();

        if ($filterTab !== 'semua') {
            $query->where('verifikasi', $filterTab);
        }

        $volunteers = $query->paginate($perPage)->withQueryString();

        return view('admin.assignments.show', compact('campaign', 'volunteers', 'filterTab'));
    }

    public function storeRole(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'kuota'     => 'nullable|integer|min:0',
        ]);

        $campaign->roles()->create($validated);

        return redirect()->route('admin.assignments.show', $campaign)
            ->with('success', 'Bagian tugas berhasil ditambahkan.');
    }

    public function destroyRole(CampaignRole $role)
    {
        $campaignId = $role->campaign_id;
        $role->delete();

        return redirect()->route('admin.assignments.show', $campaignId)
            ->with('success', 'Bagian tugas berhasil dihapus.');
    }

    public function verifikasi(Request $request, CampaignVolunteer $volunteer)
    {
        $validated = $request->validate([
            'verifikasi'    => 'required|in:diterima,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $volunteer->update([
            'verifikasi'    => $validated['verifikasi'],
            'catatan_admin' => $validated['catatan_admin'] ?? null,
            'status'        => $validated['verifikasi'] === 'diterima' ? 'aktif' : 'selesai',
        ]);

        return redirect()->route('admin.assignments.show', $volunteer->campaign_id)
            ->with('success', 'Status relawan berhasil diperbarui.');
    }

    public function setKoordinator(CampaignVolunteer $volunteer)
    {
        // Lepas koordinator lama di kampanye ini dulu
        CampaignVolunteer::where('campaign_id', $volunteer->campaign_id)
            ->where('is_coordinator', true)
            ->update(['is_coordinator' => false]);

        // Tunjuk yang baru
        $volunteer->update(['is_coordinator' => true]);

        return redirect()->route('admin.assignments.show', $volunteer->campaign_id)
            ->with('success', 'Koordinator berhasil ditunjuk.');
    }

    public function unsetKoordinator(CampaignVolunteer $volunteer)
    {
        $volunteer->update(['is_coordinator' => false]);

        return redirect()->route('admin.assignments.show', $volunteer->campaign_id)
            ->with('success', 'Koordinator berhasil dilepas.');
    }
}