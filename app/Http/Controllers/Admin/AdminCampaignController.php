<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\TransparencyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\NotificationService;
use Carbon\Carbon;

class AdminCampaignController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        // Ambil SEMUA campaign dulu (tanpa filter status), buang yang sudah expired
        $allCampaigns = Campaign::latest()->get();
        $activeCampaigns = $allCampaigns->reject(function ($c) {
            return $c->report_status === 'disetujui' && $c->is_expired;
        });

        // Stats dihitung dari campaign yang masih aktif (konsisten dengan tab & listing)
        $stats = [
            'total'     => $activeCampaigns->count(),
            'disetujui' => $activeCampaigns->where('report_status', 'disetujui')->count(),
            'menunggu'  => $activeCampaigns->where('report_status', 'menunggu')->count(),
            'ditolak'   => $activeCampaigns->where('report_status', 'ditolak')->count(),
        ];

        // Baru filter berdasarkan tab status yang dipilih
        if ($status !== 'all') {
            $activeCampaigns = $activeCampaigns->where('report_status', $status);
        }

        // Paginate manual karena filternya di level Collection, bukan query DB
        $campaigns = $this->paginateCollection($activeCampaigns->values(), 8, $request);

        return view('admin.campaigns.index', compact('campaigns', 'stats', 'status'));
    }

    public function create()
    {
        return view('admin.campaigns.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateCampaign($request);
        $needs = $validated['needs'] ?? [];
        unset($validated['needs']);

        $slug = Str::slug($validated['title']) . '-' . time();
        $validated['slug'] = $slug;
        $validated['report_status'] = 'disetujui'; // Campaign buatan admin otomatis disetujui

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('campaigns', 'public');
            $validated['image'] = $imagePath;
        } else {
            $validated['image'] = 'campaigns/default.jpg';
        }

        // Dokumentasi - handle array upload (sama seperti di update())
        if ($request->hasFile('documentation')) {
            $files = $request->file('documentation');
            foreach ($files as $i => $file) {
                if ($i < 3) {
                    $field = 'documentation_' . ($i + 1);
                    $validated[$field] = $file->store('documentation', 'public');
                }
            }
        }

        $campaign = Campaign::create($validated);

        // Simpan kebutuhan logistik
        foreach ($needs as $need) {
            if (!empty($need['name'])) {
                $campaign->needs()->create([
                    'name' => $need['name'],
                    'qty'  => $need['qty'] ?? null,
                ]);
            }
        }

        // Kampanye buatan admin otomatis disetujui — buat laporan transparansi awal
        TransparencyReport::firstOrCreate(
            ['campaign_id' => $campaign->id],
            [
                'status'        => 'Aktif',
                'status_class'  => 'transparency-badge-aktif',
                'status_icon'   => 'fa-solid fa-circle-dot',
                'date'          => now()->toDateString(),
                'description'   => 'Laporan transparansi penyaluran dana untuk kampanye "' . $campaign->title . '" akan segera diperbarui oleh admin.',
                'beneficiaries' => 0,
            ]
        );

        return redirect()->route('admin.campaigns.index')->with('success', 'Kampanye berhasil ditambahkan!');
    }

    public function show(Campaign $campaign)
    {
        return view('admin.campaigns.show', compact('campaign'));
    }

    public function edit(Campaign $campaign)
    {
        return view('admin.campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $validated = $this->validateCampaign($request);
        $needs = $validated['needs'] ?? [];
        unset($validated['needs']);

        if ($request->hasFile('image')) {
            if ($campaign->image && Storage::disk('public')->exists($campaign->image)) {
                Storage::disk('public')->delete($campaign->image);
            }

            $validated['image'] = $request->file('image')->store('campaigns', 'public');
        }

        // Dokumentasi - handle array upload
        if ($request->hasFile('documentation')) {
            $files = $request->file('documentation');
            foreach ($files as $i => $file) {
                $field = 'documentation_' . ($i + 1);
                if ($i < 3) {
                    $path = $file->store('documentation', 'public');
                    $validated[$field] = $path;
                }
            }
        }

        $campaign->update($validated);
        // Sinkronkan kebutuhan logistik: hapus lama, simpan baru
        $campaign->needs()->delete();
        foreach ($needs as $need) {
            if (!empty($need['name'])) {
                $campaign->needs()->create([
                    'name' => $need['name'],
                    'qty'  => $need['qty'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.campaigns.show', $campaign)->with('success', 'Kampanye berhasil diperbarui!');
    }

    public function destroy(Campaign $campaign)
    {
        if ($campaign->image && Storage::disk('public')->exists($campaign->image)) {
            Storage::disk('public')->delete($campaign->image);
        }

        foreach (['documentation_1', 'documentation_2', 'documentation_3'] as $field) {
            if ($campaign->$field && Storage::disk('public')->exists($campaign->$field)) {
                Storage::disk('public')->delete($campaign->$field);
            }
        }

        $campaign->delete();

        return redirect()->route('admin.campaigns.index')->with('success', 'Kampanye berhasil dihapus.');
    }

    public function approve(Campaign $campaign)
    {
        $campaign->update(['report_status' => 'disetujui']);

        // Otomatis buat record transparansi awal kalau belum ada
        \App\Models\TransparencyReport::firstOrCreate(
            ['campaign_id' => $campaign->id],
            [
                'status'        => 'Aktif',
                'status_class'  => 'transparency-badge-aktif',
                'status_icon'   => 'fa-solid fa-circle-dot',
                'date'          => now()->toDateString(),
                'description'   => 'Laporan transparansi penyaluran dana untuk kampanye "' . $campaign->title . '" akan segera diperbarui oleh admin.',
                'beneficiaries' => 0,
            ]
        );

        NotificationService::campaignApproved($campaign);
        NotificationService::newCampaignPublished($campaign);
        return redirect()->route('admin.campaigns.index')->with('success', 'Laporan bencana berhasil disetujui!');
    }

    public function reject(Campaign $campaign)
    {
        $campaign->update(['report_status' => 'ditolak']);
        NotificationService::campaignRejected($campaign);
        return redirect()->route('admin.campaigns.index')->with('success', 'Laporan bencana berhasil ditolak!');
    }

    private function validateCampaign(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string|in:Aktif,Darurat,Waspada',
            'target_raw' => 'required|numeric|min:0',
            'days_left' => 'required|integer|min:0',
            'date_published' => 'required|date',
            'description_short' => 'required|string|max:500',
            'description_long' => 'required|string',
            'victims' => 'nullable|integer|min:0',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'report_status' => 'nullable|string|in:menunggu,disetujui,ditolak',
            'documentation_1' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documentation_2' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documentation_3' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'needs' => 'nullable|array',
            'needs.*.name' => 'nullable|string|max:255',
            'needs.*.qty' => 'nullable|string|max:100',
        ]);
    }

    public function archived(Request $request)
    {
        $search   = $request->get('search');
        $category = $request->get('category');
        $sort     = $request->get('sort', 'newest');

        $query = Campaign::where('report_status', 'disetujui')->get();

        // Filter hanya yang sudah expired
        $archived = $query->filter(fn($c) => $c->is_expired);

        if ($search) {
            $archived = $archived->filter(fn($c) =>
                str_contains(strtolower($c->title), strtolower($search)) ||
                str_contains(strtolower($c->location), strtolower($search))
            );
        }

        if ($category) {
            $archived = $archived->filter(fn($c) =>
                strtolower($c->category) === strtolower($category)
            );
        }

        $archived = match ($sort) {
            'oldest'   => $archived->sortBy(fn($c) => strtotime($c->getRawOriginal('date_published'))),
            'progress' => $archived->sortByDesc(fn($c) => $c->progress_raw),
            default    => $archived->sortByDesc(fn($c) => strtotime($c->getRawOriginal('date_published'))),
        };

        $totalArchived  = $archived->count();
        $totalCollected = $archived->sum('collected_raw');
        $totalTarget    = $archived->sum('target_raw');
        $avgProgress    = $totalArchived > 0 ? round($archived->avg('progress_raw'), 1) : 0;

        $campaigns = $this->paginateCollection($archived, 12, $request);

        return view('admin.campaigns.archived', compact(
            'campaigns', 'totalArchived', 'totalCollected', 'totalTarget', 'avgProgress'
        ));
    }

    private function paginateCollection($collection, int $perPage, Request $request)
    {
        $page  = $request->get('page', 1);
        $total = $collection->count();
        $items = $collection->forPage($page, $perPage)->values();

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items, $total, $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    }
}
