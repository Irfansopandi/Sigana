<?php

namespace App\Http\Controllers\Relawan;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignVolunteer;
use App\Models\CoordinatorReport;
use App\Models\CoordinatorReportPhoto;
use App\Models\CoordinatorReportItem;
use App\Models\CoordinatorReportTimeline;
use App\Models\CoordinatorReportDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RelawanCoordinatorReportController extends Controller
{
    /**
     * Display a listing of the coordinator reports.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all'); // all | none | pending | approved | rejected

        $campaigns = Campaign::whereHas('volunteers', function ($q) {
                $q->where('user_id', Auth::id())
                ->where('is_coordinator', true)
                ->where('verifikasi', 'diterima');
            })
            ->with(['reports' => function ($q) {
                $q->where('user_id', Auth::id())->latest();
            }])
            ->latest()
            ->get();

        $stats = [
            'total_campaign' => $campaigns->count(),
            'none'           => $campaigns->filter(fn($c) => $c->reports->isEmpty())->count(),
            'pending'        => CoordinatorReport::where('user_id', Auth::id())->where('status', 'pending')->count(),
            'approved'       => CoordinatorReport::where('user_id', Auth::id())->where('status', 'approved')->count(),
            'rejected'       => CoordinatorReport::where('user_id', Auth::id())->where('status', 'rejected')->count(),
        ];

        if ($status !== 'all') {
            $campaigns = $campaigns->filter(function ($c) use ($status) {
                $report = $c->reports->first();
                if ($status === 'none') return !$report;
                return $report && $report->status === $status;
            });
        }

        return view('relawan.coordinator-reports.index', compact('campaigns', 'stats', 'status'));
    }

    /**
     * Show the form for creating a new coordinator report.
     */
    public function create(Request $request)
    {
        // Get all campaigns where the user is an active coordinator
        $campaigns = Campaign::whereHas('volunteers', function ($q) {
            $q->where('user_id', Auth::id())
              ->where('is_coordinator', true)
              ->where('verifikasi', 'diterima');
        })->get();

        if ($campaigns->isEmpty()) {
            return redirect()->route('relawan.dashboard')
                ->with('error', 'Anda harus ditunjuk sebagai koordinator bencana terlebih dahulu.');
        }

        $selectedCampaignId = $request->get('campaign_id');

        return view('relawan.coordinator-reports.create', compact('campaigns', 'selectedCampaignId'));
    }

    /**
     * Store a newly created coordinator report in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'campaign_id'        => 'required|exists:campaigns,id',
            'title'              => 'required|string|max:255',
            'description'        => 'required|string',
            'reported_at'        => 'required|date',
            'victim_helped'      => 'required|integer|min:0',
            'total_distribution' => 'required|numeric|min:0',
            'photos'             => 'nullable|array',
            'photos.*'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'photo_captions'     => 'nullable|array',
            'items'              => 'nullable|array',
            'items.*.category'   => 'required_with:items|string|max:100',
            'items.*.description'=> 'nullable|string',
            'items.*.amount'     => 'required_with:items|numeric|min:0',
            'timelines'          => 'nullable|array',
            'timelines.*.date'   => 'required_with:timelines|date',
            'timelines.*.title'  => 'required_with:timelines|string|max:150',
            'timelines.*.description' => 'nullable|string',
            'documents'          => 'nullable|array',
            'documents.*'        => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:5120',
            'document_names'     => 'nullable|array',
            'document_codes'     => 'nullable|array',
        ], [
            'campaign_id.required' => 'Kampanye bencana wajib dipilih.',
            'title.required'       => 'Judul laporan wajib diisi.',
            'description.required' => 'Deskripsi laporan wajib diisi.',
            'reported_at.required' => 'Tanggal laporan wajib diisi.',
            'victim_helped.required' => 'Jumlah korban terbantu wajib diisi.',
            'total_distribution.required' => 'Total dana disalurkan wajib diisi.',
        ]);

        // Double check authorization: is user a coordinator for this campaign?
        $isCoordinator = CampaignVolunteer::where('user_id', Auth::id())
            ->where('campaign_id', $request->campaign_id)
            ->where('is_coordinator', true)
            ->where('verifikasi', 'diterima')
            ->exists();

        if (!$isCoordinator) {
            return back()->withErrors(['campaign_id' => 'Anda bukan koordinator untuk kampanye bencana ini.']);
        }

        try {
            DB::beginTransaction();

            // 1. Create main report
            $report = CoordinatorReport::create([
                'campaign_id'        => $request->campaign_id,
                'user_id'            => Auth::id(),
                'title'              => $request->title,
                'description'        => $request->description,
                'victim_helped'      => $request->victim_helped ?? 0,
                'total_distribution' => $request->total_distribution ?? 0,
                'reported_at'        => $request->reported_at,
                'status'             => 'pending',
            ]);

            // 2. Save photos documentation
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $index => $photoFile) {
                    if ($photoFile->isValid()) {
                        $path = $photoFile->store('coordinator_reports/photos', 'public');
                        $report->photos()->create([
                            'photo'   => $path,
                            'caption' => $request->photo_captions[$index] ?? null,
                            'order'   => $index + 1,
                        ]);
                    }
                }
            }

            // 3. Save financial items detail
            if ($request->has('items') && is_array($request->items)) {
                foreach ($request->items as $item) {
                    if (!empty($item['category'])) {
                        $report->items()->create([
                            'category'    => $item['category'],
                            'description' => $item['description'] ?? null,
                            'amount'      => $item['amount'] ?? 0,
                        ]);
                    }
                }
            }

            // 4. Save timelines
            if ($request->has('timelines') && is_array($request->timelines)) {
                foreach ($request->timelines as $tl) {
                    if (!empty($tl['date']) && !empty($tl['title'])) {
                        $report->timelines()->create([
                            'date'        => $tl['date'],
                            'title'       => $tl['title'],
                            'description' => $tl['description'] ?? null,
                        ]);
                    }
                }
            }

            // 5. Save supporting documents
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $index => $docFile) {
                    if ($docFile->isValid()) {
                        $path = $docFile->store('coordinator_reports/docs', 'public');
                        $report->documents()->create([
                            'name' => $request->document_names[$index] ?? $docFile->getClientOriginalName(),
                            'file' => $path,
                            'code' => $request->document_codes[$index] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('relawan.coordinator-reports.index')
                ->with('success', 'Laporan koordinator berhasil dikirim dan menunggu verifikasi admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified coordinator report.
     */
    public function show(CoordinatorReport $coordinatorReport)
    {
        abort_if($coordinatorReport->user_id !== Auth::id(), 403);

        $coordinatorReport->load([
            'campaign',
            'photos',
            'items',
            'timelines',
            'documents',
            'verifiedBy'
        ]);

        return view('relawan.coordinator-reports.show', compact('coordinatorReport'));
    }

    /**
     * Show the form for editing (not usually allowed for submitted reports unless rejected)
     */
    public function edit(CoordinatorReport $coordinatorReport)
    {
        abort_if($coordinatorReport->user_id !== Auth::id(), 403);
        
        // Only allow editing if report is rejected or pending
        if ($coordinatorReport->status === 'approved') {
            return redirect()->route('relawan.coordinator-reports.index')
                ->with('error', 'Laporan yang telah disetujui tidak dapat diubah.');
        }

        $coordinatorReport->load(['photos', 'items', 'timelines', 'documents']);
        
        $campaigns = Campaign::whereHas('volunteers', function ($q) {
            $q->where('user_id', Auth::id())
              ->where('is_coordinator', true)
              ->where('verifikasi', 'diterima');
        })->get();

        return view('relawan.coordinator-reports.edit', compact('coordinatorReport', 'campaigns'));
    }

    /**
     * Update the specified coordinator report in storage.
     */
    public function update(Request $request, CoordinatorReport $coordinatorReport)
    {
        abort_if($coordinatorReport->user_id !== Auth::id(), 403);

        if ($coordinatorReport->status === 'approved') {
            return redirect()->route('relawan.coordinator-reports.index')
                ->with('error', 'Laporan yang telah disetujui tidak dapat diubah.');
        }

        $request->validate([
            'campaign_id'        => 'required|exists:campaigns,id',
            'title'              => 'required|string|max:255',
            'description'        => 'required|string',
            'reported_at'        => 'required|date',
            'victim_helped'      => 'required|integer|min:0',
            'total_distribution' => 'required|numeric|min:0',
            'photos'             => 'nullable|array',
            'photos.*'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'photo_captions'     => 'nullable|array',
            'items'              => 'nullable|array',
            'items.*.category'   => 'required_with:items|string|max:100',
            'items.*.description'=> 'nullable|string',
            'items.*.amount'     => 'required_with:items|numeric|min:0',
            'timelines'          => 'nullable|array',
            'timelines.*.date'   => 'required_with:timelines|date',
            'timelines.*.title'  => 'required_with:timelines|string|max:150',
            'timelines.*.description' => 'nullable|string',
            'documents'          => 'nullable|array',
            'documents.*'        => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:5120',
            'document_names'     => 'nullable|array',
            'document_codes'     => 'nullable|array',
        ]);

        try {
            DB::beginTransaction();

            // 1. Update main report details and reset status to pending
            $coordinatorReport->update([
                'campaign_id'        => $request->campaign_id,
                'title'              => $request->title,
                'description'        => $request->description,
                'victim_helped'      => $request->victim_helped ?? 0,
                'total_distribution' => $request->total_distribution ?? 0,
                'reported_at'        => $request->reported_at,
                'status'             => 'pending', // Re-evaluate status to pending upon update
                'rejection_note'     => null, // Reset rejection note
            ]);

            // 2. Add new photos (keep existing, delete handled optionally, let's keep it simple: append new ones)
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $index => $photoFile) {
                    if ($photoFile->isValid()) {
                        $path = $photoFile->store('coordinator_reports/photos', 'public');
                        $coordinatorReport->photos()->create([
                            'photo'   => $path,
                            'caption' => $request->photo_captions[$index] ?? null,
                            'order'   => $coordinatorReport->photos()->count() + 1,
                        ]);
                    }
                }
            }

            // 3. Update financial items (replace existing for simplicity or sync)
            $coordinatorReport->items()->delete();
            if ($request->has('items') && is_array($request->items)) {
                foreach ($request->items as $item) {
                    if (!empty($item['category'])) {
                        $coordinatorReport->items()->create([
                            'category'    => $item['category'],
                            'description' => $item['description'] ?? null,
                            'amount'      => $item['amount'] ?? 0,
                        ]);
                    }
                }
            }

            // 4. Update timelines (replace existing)
            $coordinatorReport->timelines()->delete();
            if ($request->has('timelines') && is_array($request->timelines)) {
                foreach ($request->timelines as $tl) {
                    if (!empty($tl['date']) && !empty($tl['title'])) {
                        $coordinatorReport->timelines()->create([
                            'date'        => $tl['date'],
                            'title'       => $tl['title'],
                            'description' => $tl['description'] ?? null,
                        ]);
                    }
                }
            }

            // 5. Add new documents
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $index => $docFile) {
                    if ($docFile->isValid()) {
                        $path = $docFile->store('coordinator_reports/docs', 'public');
                        $coordinatorReport->documents()->create([
                            'name' => $request->document_names[$index] ?? $docFile->getClientOriginalName(),
                            'file' => $path,
                            'code' => $request->document_codes[$index] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('relawan.coordinator-reports.index')
                ->with('success', 'Laporan koordinator berhasil diperbarui dan dikirim ulang.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Delete a report photo (AJAX/Redirect helper)
     */
    public function destroyPhoto(CoordinatorReportPhoto $photo)
    {
        $report = $photo->coordinatorReport;
        abort_if($report->user_id !== Auth::id(), 403);
        abort_if($report->status === 'approved', 403);

        Storage::disk('public')->delete($photo->photo);
        $photo->delete();

        return back()->with('success', 'Foto dokumentasi berhasil dihapus.');
    }

    /**
     * Delete a report document (AJAX/Redirect helper)
     */
    public function destroyDocument(CoordinatorReportDocument $document)
    {
        $report = $document->coordinatorReport;
        abort_if($report->user_id !== Auth::id(), 403);
        abort_if($report->status === 'approved', 403);

        Storage::disk('public')->delete($document->file);
        $document->delete();

        return back()->with('success', 'Dokumen pendukung berhasil dihapus.');
    }

    /**
     * Delete the entire report (only if pending or rejected)
     */
    public function destroy(CoordinatorReport $coordinatorReport)
    {
        abort_if($coordinatorReport->user_id !== Auth::id(), 403);
        
        if ($coordinatorReport->status === 'approved') {
            return redirect()->route('relawan.coordinator-reports.index')
                ->with('error', 'Laporan yang telah disetujui tidak dapat dihapus.');
        }

        try {
            DB::beginTransaction();

            // Delete files
            foreach ($coordinatorReport->photos as $photo) {
                Storage::disk('public')->delete($photo->photo);
            }
            foreach ($coordinatorReport->documents as $doc) {
                Storage::disk('public')->delete($doc->file);
            }

            // Database cascade delete handles child items
            $coordinatorReport->delete();

            DB::commit();

            return redirect()->route('relawan.coordinator-reports.index')
                ->with('success', 'Laporan koordinator berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus laporan: ' . $e->getMessage());
        }
    }
}
