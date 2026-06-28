<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\TransparencyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserDashboardController extends Controller
{
    public function index()
    {
        $reports = Campaign::where('submitted_by', auth()->id())
            ->latest()
            ->get();

        return view('user.dashboard', compact('reports'));
    }

    public function campaigns()
    {
        $campaigns = Campaign::latest()->get();
        return view('user.campaigns', compact('campaigns'));
    }

    public function donationHistory()
    {
        $donations = Donation::where('name', auth()->user()->name)->latest()->get();
        return view('user.donation-history', compact('donations'));
    }

    public function transparency()
    {
        $reports = TransparencyReport::latest()->get();
        return view('user.transparency', compact('reports'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    public function createReport()
    {
        return view('user.reports.create');
    }

    public function storeReport(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'documentation_1' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documentation_2' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documentation_3' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'description_short' => 'required|string|max:500',
            'description_long' => 'required|string',
        ]);

        $slug = Str::slug($validated['title']) . '-' . time();

        $validated['slug'] = $slug;
        $validated['status'] = 'Waspada';
        $validated['target_raw'] = 0;
        $validated['days_left'] = 0;
        $validated['date_published'] = now()->toDateString();
        $validated['submitted_by'] = auth()->id();
        $validated['report_status'] = 'menunggu';

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('campaigns', 'public');
        }

        foreach (['documentation_1', 'documentation_2', 'documentation_3'] as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('reports', 'public');
            }
        }

        Campaign::create($validated);

        return redirect()->route('user.dashboard')->with('success', 'Laporan bencana berhasil dikirim dan menunggu verifikasi admin.');
    }
}