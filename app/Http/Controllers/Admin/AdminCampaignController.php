<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminCampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::latest()->paginate(12);
        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        return view('admin.campaigns.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateCampaign($request);

        $slug = Str::slug($validated['title']) . '-' . time();
        $validated['slug'] = $slug;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('campaigns', 'public');
            $validated['image'] = $imagePath;
        } else {
            $validated['image'] = 'campaigns/default.jpg';
        }

        Campaign::create($validated);

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

        if ($request->hasFile('image')) {
            if ($campaign->image && Storage::disk('public')->exists($campaign->image)) {
                Storage::disk('public')->delete($campaign->image);
            }

            $validated['image'] = $request->file('image')->store('campaigns', 'public');
        }

        // Handle documentation files
        foreach (['documentation_1', 'documentation_2', 'documentation_3'] as $field) {
            if ($request->hasFile($field)) {
                if ($campaign->$field && Storage::disk('public')->exists($campaign->$field)) {
                    Storage::disk('public')->delete($campaign->$field);
                }
                $validated[$field] = $request->file($field)->store('reports', 'public');
            }
        }

        $campaign->update($validated);

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
        return redirect()->route('admin.campaigns.index')->with('success', 'Laporan bencana berhasil disetujui!');
    }

    public function reject(Campaign $campaign)
    {
        $campaign->update(['report_status' => 'ditolak']);
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
        ]);
    }
}
