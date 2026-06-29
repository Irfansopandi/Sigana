<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoordinatorReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCoordinatorReportController extends Controller
{
    /**
     * Daftar semua laporan koordinator
     */
    public function index(Request $request)
    {
        $query = CoordinatorReport::with(['campaign', 'user'])
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by campaign
        if ($request->filled('campaign_id')) {
            $query->where('campaign_id', $request->campaign_id);
        }

        // Search by title atau nama koordinator
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $reports = $query->paginate(10)->withQueryString();

        $campaigns = \App\Models\Campaign::orderBy('title')->get(['id', 'title']);

        $stats = [
            'total'    => CoordinatorReport::count(),
            'pending'  => CoordinatorReport::where('status', 'pending')->count(),
            'approved' => CoordinatorReport::where('status', 'approved')->count(),
            'rejected' => CoordinatorReport::where('status', 'rejected')->count(),
        ];

        return view('admin.coordinator-reports.index', compact('reports', 'campaigns', 'stats'));
    }

    /**
     * Detail laporan + aksi approve/reject
     */
    public function show(CoordinatorReport $coordinatorReport)
    {
        $coordinatorReport->load([
            'campaign',
            'user',
            'photos',
            'items',
            'timelines',
            'documents',
            'verifiedBy',
        ]);

        return view('admin.coordinator-reports.show', compact('coordinatorReport'));
    }

    /**
     * Approve laporan
     */
    public function approve(CoordinatorReport $coordinatorReport)
    {
        if ($coordinatorReport->status !== 'pending') {
            return back()->with('error', 'Laporan ini sudah diproses sebelumnya.');
        }

        $coordinatorReport->update([
            'status'      => 'approved',
            'verified_at' => now(),
            'verified_by' => Auth::id(),
            'rejection_note' => null,
        ]);

        return redirect()
            ->route('admin.coordinator-reports.index')
            ->with('success', 'Laporan berhasil diverifikasi dan dipublikasikan.');
    }

    /**
     * Reject laporan
     */
    public function reject(Request $request, CoordinatorReport $coordinatorReport)
    {
        $request->validate([
            'rejection_note' => 'required|string|min:10|max:1000',
        ], [
            'rejection_note.required' => 'Catatan penolakan wajib diisi.',
            'rejection_note.min'      => 'Catatan minimal 10 karakter.',
        ]);

        if ($coordinatorReport->status !== 'pending') {
            return back()->with('error', 'Laporan ini sudah diproses sebelumnya.');
        }

        $coordinatorReport->update([
            'status'         => 'rejected',
            'rejection_note' => $request->rejection_note,
            'verified_at'    => now(),
            'verified_by'    => Auth::id(),
        ]);

        return redirect()
            ->route('admin.coordinator-reports.index')
            ->with('success', 'Laporan telah ditolak dengan catatan.');
    }
}