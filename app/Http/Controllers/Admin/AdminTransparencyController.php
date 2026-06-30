<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransparencyReport;
use App\Models\ReportAllocation;
use App\Models\ReportTimeline;
use App\Models\ReportDoc;
use App\Models\ReportEvidence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\NotificationService;

class AdminTransparencyController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');

        $query = TransparencyReport::with('campaign')->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $reports        = $query->paginate(8)->withQueryString();
        $totalAll       = TransparencyReport::count();
        $totalAktif     = TransparencyReport::where('status', 'Aktif')->count();
        $totalPenyaluran = TransparencyReport::where('status', 'Dalam Penyaluran')->count();
        $totalSelesai   = TransparencyReport::where('status', 'Hampir Selesai')->count();
        $totalDoneSelesai = TransparencyReport::where('status', 'Selesai')->count();

        return view('admin.transparency.index', compact(
            'reports', 'totalAll', 'totalAktif', 'totalPenyaluran', 'totalSelesai','totalDoneSelesai'
        ));
    }

    public function show(TransparencyReport $report)
    {
        $report->load(['campaign', 'allocations', 'timeline', 'docs']);

        $statusOptions = [
            'Aktif'            => 'Aktif',
            'Dalam Penyaluran' => 'Dalam Penyaluran',
            'Hampir Selesai'   => 'Hampir Selesai',
            'Selesai'          => 'Selesai',
        ];

        return view('admin.transparency.show', compact('report', 'statusOptions'));
    }

    public function edit(TransparencyReport $report)
    {
        $report->load(['campaign', 'allocations', 'timeline', 'docs']);

        $statusOptions = [
            'Aktif'            => 'Aktif',
            'Dalam Penyaluran' => 'Dalam Penyaluran',
            'Hampir Selesai'   => 'Hampir Selesai',
        ];

        return view('admin.transparency.edit', compact('report', 'statusOptions'));
    }

    public function update(Request $request, TransparencyReport $report)
    {
        $validated = $request->validate([
            'status' => 'required|in:Aktif,Dalam Penyaluran,Hampir Selesai,Selesai',
        ]);

        $report->update(array_merge($validated, $this->statusMeta($validated['status'])));
        $report->refresh();
        NotificationService::transparencyUpdated($report);

        return redirect()->route('admin.transparency.show', $report)->with('success', 'Status laporan berhasil diperbarui.');
    }

    public function updateInfo(Request $request, TransparencyReport $report)
    {
        $validated = $request->validate([
            'status'        => 'required|in:Aktif,Dalam Penyaluran,Hampir Selesai, Selesai',
            'description'   => 'required|string',
            'beneficiaries' => 'nullable|integer|min:0',
        ]);

        $report->update(array_merge($validated, $this->statusMeta($validated['status'])));
        $report->refresh();
        NotificationService::transparencyUpdated($report);

        return redirect()->route('admin.transparency.edit', $report)->with('success', 'Informasi laporan berhasil diperbarui.');
    }

    // ====== Alokasi Belanja ======

    public function storeAllocation(Request $request, TransparencyReport $report)
    {
        $validated = $request->validate([
            'kategori' => 'required|string|max:100',
            'nominal'  => 'required|numeric|min:0',
            'progress' => 'nullable|numeric|min:0|max:100',
            'icon'     => 'nullable|string|max:50',
            'desc'     => 'nullable|string',
        ]);

        $report->allocations()->create($validated);

        return redirect()->route('admin.transparency.edit', $report)->with('success', 'Alokasi belanja berhasil ditambahkan.');
    }

    public function updateAllocation(Request $request, ReportAllocation $allocation)
    {
        $validated = $request->validate([
            'kategori' => 'required|string|max:100',
            'nominal'  => 'required|numeric|min:0',
            'progress' => 'nullable|numeric|min:0|max:100',
            'icon'     => 'nullable|string|max:50',
            'desc'     => 'nullable|string',
        ]);

        $allocation->update($validated);

        return redirect()->route('admin.transparency.edit', $allocation->report_id)->with('success', 'Alokasi belanja berhasil diperbarui.');
    }

    public function destroyAllocation(ReportAllocation $allocation)
    {
        $reportId = $allocation->report_id;
        $allocation->delete();

        return redirect()->route('admin.transparency.edit', $reportId)->with('success', 'Alokasi belanja berhasil dihapus.');
    }

    // ====== Timeline Penyaluran ======

    public function storeTimeline(Request $request, TransparencyReport $report)
    {
        $validated = $request->validate([
            'tanggal'   => 'required|date',
            'judul'     => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'icon'      => 'nullable|string|max:50',
        ]);

        $report->timeline()->create($validated);

        return redirect()->route('admin.transparency.edit', $report)->with('success', 'Timeline penyaluran berhasil ditambahkan.');
    }

    public function updateTimeline(Request $request, ReportTimeline $timeline)
    {
        $validated = $request->validate([
            'tanggal'   => 'required|date',
            'judul'     => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'icon'      => 'nullable|string|max:50',
        ]);

        $timeline->update($validated);

        return redirect()->route('admin.transparency.edit', $timeline->report_id)->with('success', 'Timeline penyaluran berhasil diperbarui.');
    }

    public function destroyTimeline(ReportTimeline $timeline)
    {
        $reportId = $timeline->report_id;
        $timeline->delete();

        return redirect()->route('admin.transparency.edit', $reportId)->with('success', 'Timeline penyaluran berhasil dihapus.');
    }

    // ====== Dokumen Pendukung ======

    public function storeDoc(Request $request, TransparencyReport $report)
    {
        $validated = $request->validate([
            'nama'    => 'required|string|max:150',
            'nominal' => 'nullable|numeric|min:0',
            'doc_id'  => 'nullable|string|max:50',
            'file'    => 'required|file|max:5120',
        ]);

        $path = $request->file('file')->store('transparency_docs', 'public');

        $report->docs()->create([
            'nama'    => $validated['nama'],
            'nominal' => $validated['nominal'] ?? 0,
            'doc_id'  => $validated['doc_id'] ?? null,
            'file'    => $path,
        ]);

        return redirect()->route('admin.transparency.edit', $report)->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function destroyDoc(ReportDoc $doc)
    {
        $reportId = $doc->report_id;

        if ($doc->getRawOriginal('file')) {
            Storage::disk('public')->delete($doc->getRawOriginal('file'));
        }

        $doc->delete();

        return redirect()->route('admin.transparency.edit', $reportId)->with('success', 'Dokumen berhasil dihapus.');
    }

    private function statusMeta(string $status): array
    {
        return match ($status) {
            'Dalam Penyaluran' => [
                'status_class' => 'transparency-badge-penyaluran',
                'status_icon' => 'fa-solid fa-truck',
            ],
            'Hampir Selesai' => [
                'status_class' => 'transparency-badge-selesai',
                'status_icon' => 'fa-solid fa-circle-check',
            ],
            'Selesai' => [                                        
                'status_class' => 'transparency-badge-selesai-done',
                'status_icon'  => 'fa-solid fa-flag-checkered',
            ],
            default => [
                'status_class' => 'transparency-badge-aktif',
                'status_icon' => 'fa-solid fa-circle-dot',
            ],
        };
    }

    // ====== Galeri Bukti Foto Penyaluran ======

    public function storeEvidence(Request $request, TransparencyReport $report)
    {
        $validated = $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'desc'  => 'nullable|string|max:255',
        ]);

        $path = $request->file('photo')->store('evidence', 'public');

        $report->evidence()->create([
            'url'  => $path,
            'desc' => $validated['desc'] ?? null,
        ]);

        return redirect()->route('admin.transparency.edit', $report)->with('success', 'Foto bukti penyaluran berhasil ditambahkan.');
    }

    public function destroyEvidence(ReportEvidence $evidence)
    {
        $reportId = $evidence->report_id;

        if ($evidence->url) {
            Storage::disk('public')->delete($evidence->url);
        }

        $evidence->delete();

        return redirect()->route('admin.transparency.edit', $reportId)->with('success', 'Foto bukti penyaluran berhasil dihapus.');
    }
}