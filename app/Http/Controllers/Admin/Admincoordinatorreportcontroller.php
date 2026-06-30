<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoordinatorReport;
use Illuminate\Http\Request;
use App\Models\TransparencyReport;
use Illuminate\Support\Facades\DB;
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

        $coordinatorReport->load(['items', 'timelines', 'documents', 'photos']);

        DB::transaction(function () use ($coordinatorReport) {
            $coordinatorReport->update([
                'status'         => 'approved',
                'verified_at'    => now(),
                'verified_by'    => Auth::id(),
                'rejection_note' => null,
            ]);

            $this->syncToTransparencyReport($coordinatorReport);
        });

        return redirect()
            ->route('admin.coordinator-reports.index')
            ->with('success', 'Laporan berhasil diverifikasi dan dipublikasikan ke Laporan Transparansi.');
    }

    /**
     * Salin/akumulasi data laporan koordinator yang disetujui ke
     * Laporan Transparansi milik kampanye terkait.
     */
    private function syncToTransparencyReport(CoordinatorReport $coordinatorReport): void
    {
        $report = TransparencyReport::firstOrCreate(
            ['campaign_id' => $coordinatorReport->campaign_id],
            [
                'status'        => 'Aktif',
                'status_class'  => 'transparency-badge-aktif',
                'status_icon'   => 'fa-solid fa-circle-dot',
                'used'          => 0,
                'date'          => $coordinatorReport->reported_at,
                'description'   => $coordinatorReport->description,
                'beneficiaries' => 0,
            ]
        );

        // Akumulasi dana terpakai & korban terbantu
        $report->update([
            'used'          => $report->getRawOriginal('used') + $coordinatorReport->total_distribution,
            'beneficiaries' => $report->getRawOriginal('beneficiaries') + $coordinatorReport->victim_helped,
        ]);

        // Update tanggal laporan ke yang paling baru
        $existingDate = $report->getRawOriginal('date');
        $newDate      = optional($coordinatorReport->reported_at)->toDateString() ?? $coordinatorReport->reported_at;
        if (!$existingDate || \Carbon\Carbon::parse($newDate)->gt(\Carbon\Carbon::parse($existingDate))) {
            $report->update(['date' => $newDate]);
        }

        // Rincian Alokasi Belanja
        foreach ($coordinatorReport->items as $item) {
            $report->allocations()->create([
                'kategori' => $item->category,
                'nominal'  => $item->amount,
                'desc'     => $item->description,
                'icon'     => $this->mapAllocationIcon($item->category . ' ' . $item->description),
                'progress' => 0,
            ]);
        }

        // Timeline Penyaluran
        foreach ($coordinatorReport->timelines as $tl) {
            $report->timeline()->create([
                'tanggal'   => $tl->date,
                'judul'     => $tl->title,
                'deskripsi' => $tl->description,
                'icon'      => 'fa-solid fa-truck-fast',
            ]);
        }

        // Dokumen Pendukung — referensi file yang sama (tidak menyalin fisik file)
        foreach ($coordinatorReport->documents as $doc) {
            $report->docs()->create([
                'nama'    => $doc->name,
                'nominal' => 0,
                'doc_id'  => $doc->code,
                'file'    => $doc->file,
            ]);
        }

        // Galeri Bukti Foto Penyaluran
        foreach ($coordinatorReport->photos as $photo) {
            $report->evidence()->create([
                'url'  => $photo->photo,
                'desc' => $photo->caption,
            ]);
        }
    }

    private function mapAllocationIcon(string $text): string
    {
        $map = [
            'makan' => 'fa-bowl-food', 'nasi' => 'fa-bowl-food', 'logistik' => 'fa-truck-fast',
            'air' => 'fa-droplet', 'minum' => 'fa-droplet', 'selimut' => 'fa-mug-hot',
            'pakaian' => 'fa-shirt', 'baju' => 'fa-shirt', 'obat' => 'fa-kit-medical',
            'medis' => 'fa-kit-medical', 'kesehatan' => 'fa-kit-medical', 'tenda' => 'fa-campground',
            'evakuasi' => 'fa-people-carry-box', 'transport' => 'fa-truck', 'bensin' => 'fa-gas-pump',
            'operasional' => 'fa-briefcase', 'listrik' => 'fa-bolt', 'penerangan' => 'fa-lightbulb',
            'sanitasi' => 'fa-pump-soap', 'bayi' => 'fa-baby', 'anak' => 'fa-child-reaching',
        ];
        $text = strtolower($text);
        foreach ($map as $keyword => $icon) {
            if (str_contains($text, $keyword)) return 'fa-solid ' . $icon;
        }
        return 'fa-solid fa-box';
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