<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\Request;

class AdminAssignmentController extends Controller
{
    public function index()
    {
        $assignments = Campaign::with('assignedVolunteer')->latest()->paginate(12);
        return view('admin.assignments.index', compact('assignments'));
    }

    public function create()
    {
        $campaigns = Campaign::with('assignedVolunteer')->get();
        $volunteers = User::where('role', 'relawan')->get();
        return view('admin.assignments.create', compact('campaigns', 'volunteers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'volunteer_id' => 'required|exists:users,id',
        ]);

        $campaign = Campaign::findOrFail($validated['campaign_id']);
        $volunteer = User::where('role', 'relawan')->findOrFail($validated['volunteer_id']);

        $campaign->update(['assigned_to' => $volunteer->id]);

        return redirect()->route('admin.assignments.index')->with('success', 'Relawan berhasil ditugaskan.');
    }
}
