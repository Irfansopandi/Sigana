<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CampaignVolunteer;
use Illuminate\Http\Request;

class AdminCoordinatorSelectionController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 10);
        $filterTab = request('tab', 'semua');

        $query = CampaignVolunteer::where('minat_koordinator', true)
            ->with(['user', 'campaign', 'role'])
            ->latest();

        if ($filterTab !== 'semua') {
            $query->where('verifikasi', $filterTab);
        }

        $candidates = $query->paginate($perPage)->withQueryString();

        // Hitung total statis kandidat koordinator
        $totalMenunggu = CampaignVolunteer::where('minat_koordinator', true)->where('verifikasi', 'menunggu')->count();
        $totalDiterima = CampaignVolunteer::where('minat_koordinator', true)->where('verifikasi', 'diterima')->count();
        $totalDitolak  = CampaignVolunteer::where('minat_koordinator', true)->where('verifikasi', 'ditolak')->count();

        return view('admin.coordinator-selections.index', compact('candidates', 'filterTab', 'totalMenunggu', 'totalDiterima', 'totalDitolak'));
    }

    public function verifikasi(Request $request, CampaignVolunteer $volunteer)
    {
        $validated = $request->validate([
            'verifikasi'    => 'required|in:diterima,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $isDiterima = $validated['verifikasi'] === 'diterima';

        $volunteer->update([
            'verifikasi'     => $validated['verifikasi'],
            'catatan_admin'  => $validated['catatan_admin'] ?? null,
            'status'         => $isDiterima ? 'aktif' : 'selesai',
            // Jika diterima sebagai koordinator, otomatis set is_coordinator ke true
            'is_coordinator' => $isDiterima ? true : false,
        ]);

        // Lepas koordinator lama di kampanye yang sama jika baru saja ditunjuk koordinator baru
        if ($isDiterima) {
            CampaignVolunteer::where('campaign_id', $volunteer->campaign_id)
                ->where('id', '!=', $volunteer->id)
                ->where('is_coordinator', true)
                ->update(['is_coordinator' => false]);
        }

        return redirect()->route('admin.coordinator-selections.index')
            ->with('success', 'Status calon koordinator berhasil diperbarui.');
    }
}
