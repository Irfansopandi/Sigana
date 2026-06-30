<?php

namespace App\Http\Controllers\Relawan;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignVolunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VolunteerJoinController extends Controller
{
    public function create(Campaign $campaign)
    {
        $campaign->load('roles');

        $sudahDaftar = CampaignVolunteer::where('campaign_id', $campaign->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($sudahDaftar) {
            return redirect()
                ->route('relawan.dashboard')
                ->with('error', 'Kamu sudah terdaftar sebagai relawan di kampanye ini.');
        }

        return view('relawan.volunteer-join.create', compact('campaign'));
    }

    public function store(Request $request, Campaign $campaign)
    {
        $sudahDaftar = CampaignVolunteer::where('campaign_id', $campaign->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($sudahDaftar) {
            return redirect()
                ->route('relawan.dashboard')
                ->with('error', 'Kamu sudah terdaftar sebagai relawan di kampanye ini.');
        }

        $minatKoordinator = $request->boolean('minat_koordinator');

        // ── Validasi Fase 1: Data Diri ──
        $rules = [
            'name'              => 'required|string|max:100',
            'phone'             => 'required|numeric|digits_between:9,15',
            'tanggal_lahir'     => 'required|date|before_or_equal:' . now()->subYears(17)->format('Y-m-d'),
            'jenis_kelamin'     => 'required|in:laki-laki,perempuan',
            'minat_koordinator' => 'required|boolean',

            // ── Fase 2: Keahlian & Tugas ──
            'keahlian'          => 'required|array|min:1',
            'keahlian.*'        => 'string|max:50',
            'campaign_role_id'  => 'nullable|exists:campaign_roles,id',
            'tugas_lain'        => 'nullable|required_without:campaign_role_id|string|max:150',
            'alasan'            => 'required|string|max:1000',
        ];

        if ($minatKoordinator) {
            $rules['pengalaman'] = 'required|string|max:1000';
            $rules['dokumen_1']  = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
            $rules['dokumen_2']  = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048';
            $rules['dokumen_3']  = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048';
        } else {
            $rules['pengalaman'] = 'nullable|string|max:1000';
        }

        $messages = [
            'tanggal_lahir.before_or_equal' => 'Usia minimal untuk mendaftar relawan adalah 17 tahun.',
        ];

        $validated = $request->validate($rules, $messages);

        // Update data diri user (boleh diedit ulang dari fase 1)
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'name'          => $validated['name'],
            'phone'         => $validated['phone'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
        ]);

        $data = [
            'campaign_id'       => $campaign->id,
            'user_id'           => $user->id,
            'campaign_role_id'  => $validated['campaign_role_id'] ?? null,
            'tugas_lain'        => $validated['tugas_lain'] ?? null,
            'minat_koordinator' => $minatKoordinator,
            'keahlian'          => $validated['keahlian'],
            'alasan'            => $validated['alasan'],
            'pengalaman'        => $validated['pengalaman'] ?? null,
            'joined_at'         => now(),
            'status'            => 'menunggu',
            'verifikasi'        => 'menunggu',
        ];

        if ($minatKoordinator) {
            foreach (['dokumen_1', 'dokumen_2', 'dokumen_3'] as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $request->file($field)->store('campaign-volunteers/documents', 'public');
                }
            }
        }

        CampaignVolunteer::create($data);

        return redirect()
            ->route('relawan.dashboard')
            ->with('success', 'Pendaftaran relawan berhasil dikirim, menunggu verifikasi admin.');
    }
}