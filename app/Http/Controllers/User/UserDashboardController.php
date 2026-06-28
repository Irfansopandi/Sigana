<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\TransparencyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $reports = Campaign::where('submitted_by', Auth::id())
            ->latest()
            ->get();

        return view('user.dashboard', compact('reports'));
    }

    public function campaigns()
    {
        $campaigns = Campaign::where('report_status', 'disetujui')
            ->latest()
            ->get();

        return view('user.campaigns', compact('campaigns'));
    }

    /**
     * Kampanye yang sudah selesai (expired)
     */
    public function archivedCampaigns()
    {
        $campaigns = Campaign::where('report_status', 'disetujui')
            ->latest()
            ->get()
            ->filter(fn($c) => $c->is_expired)
            ->values();
 
        return view('user.campaigns-archived', compact('campaigns'));
    }

    public function donationHistory()
    {
        $donations = Donation::where('user_id', Auth::id())->latest()->get();
        return view('user.donation-history', compact('donations'));
    }

    public function transparency()
    {
        $reports = TransparencyReport::with('campaign')
            ->whereHas('campaign', function ($q) {
                $q->where('submitted_by', Auth::id())
                ->where('report_status', 'disetujui');
            })
            ->latest()
            ->get();


        return view('user.transparency', compact('reports'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function updateInfo(Request $request)
    {
        $user = \App\Models\User::find(Auth::id());
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'phone'         => 'nullable|digits_between:10,15',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
        ]);
        

        $user->name          = $request->name;
        $user->email         = $request->email;
        $user->phone         = $request->phone;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->save();

        return redirect()->route('user.profile')->with('success', 'Informasi profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = \App\Models\User::find(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('user.profile')->with('error', 'Password lama tidak sesuai.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('user.profile')->with('success', 'Password berhasil diubah.');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate(['photo' => 'required|image|mimes:jpeg,png,jpg|max:2048']);

        $user = \App\Models\User::find(Auth::id());

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $path = $request->file('photo')->store('foto-profile', 'public');
        $user->photo = $path;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil diperbarui.',
            'url'     => asset('storage/' . $path),
        ]);
    }

    public function indexReport()
    {
        $allReports      = Campaign::where('submitted_by', Auth::id())->latest()->get();
        $menunggu        = $allReports->where('report_status', 'menunggu');
        $disetujui       = $allReports->where('report_status', 'disetujui');
        $ditolak         = $allReports->where('report_status', 'ditolak');

        return view('user.reports.index', compact('allReports', 'menunggu', 'disetujui', 'ditolak'));
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
            'victims' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'documentation' => 'nullable|array|max:3',
            'documentation.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'description_short' => 'required|string|max:500',
            'description_long' => 'required|string',
        ]);

        $slug = Str::slug($validated['title']) . '-' . time();

        $validated['slug'] = $slug;
        $validated['status'] = 'Waspada';
        $validated['target_raw'] = 0;
        $validated['days_left'] = 0;
        $validated['date_published'] = now()->toDateString();
        $validated['submitted_by'] = Auth::id();
        $validated['report_status'] = 'menunggu';

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('campaigns', 'public');
        }

        // Pecah array documentation[] jadi documentation_1, 2, 3
        if ($request->hasFile('documentation')) {
            foreach ($request->file('documentation') as $index => $file) {
                $fieldName = 'documentation_' . ($index + 1);
                $validated[$fieldName] = $file->store('reports', 'public');
            }
        }

        // Buang key 'documentation' karena bukan nama kolom di tabel campaigns
        unset($validated['documentation']);

        Campaign::create($validated);

        return redirect()->route('user.lapor-bencana')->with('success', 'Laporan bencana berhasil dikirim dan menunggu verifikasi admin.');
    }

    public function editReport(Campaign $campaign)
    {
        // Pastikan cuma pemilik laporan yang bisa edit
        if ($campaign->submitted_by !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengedit laporan ini.');
        }

        // Laporan yang sudah disetujui tidak bisa diedit lagi
        if ($campaign->report_status === 'disetujui') {
            return redirect()->route('user.lapor-bencana')
                ->with('error', 'Laporan yang sudah disetujui tidak dapat diedit.');
        }

        return view('user.reports.edit', compact('campaign'));
    }

    public function updateReport(Request $request, Campaign $campaign)
    {
        if ($campaign->submitted_by !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengedit laporan ini.');
        }

        if ($campaign->report_status === 'disetujui') {
            return redirect()->route('user.lapor-bencana')
                ->with('error', 'Laporan yang sudah disetujui tidak dapat diedit.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'victims' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'documentation' => 'nullable|array|max:3',
            'documentation.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'description_short' => 'required|string|max:500',
            'description_long' => 'required|string',
        ]);

        // Ganti foto utama cuma kalau user upload yang baru
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('campaigns', 'public');
        }

        // Ganti dokumentasi cuma kalau user upload yang baru
        if ($request->hasFile('documentation')) {
            foreach ($request->file('documentation') as $index => $file) {
                $fieldName = 'documentation_' . ($index + 1);
                $validated[$fieldName] = $file->store('reports', 'public');
            }
        }
        unset($validated['documentation']);

        // Laporan yang diedit balik jadi "menunggu" lagi untuk diverifikasi ulang
        $validated['report_status'] = 'menunggu';

        $campaign->update($validated);

        return redirect()->route('user.lapor-bencana')->with('success', 'Laporan berhasil diperbarui dan menunggu verifikasi ulang.');
    }

    public function destroyReport(Campaign $campaign)
    {
        if ($campaign->submitted_by !== Auth::id()) {
            abort(403, 'Anda tidak berhak menghapus laporan ini.');
        }

        if ($campaign->report_status === 'disetujui') {
            return redirect()->route('user.lapor-bencana')
                ->with('error', 'Laporan yang sudah disetujui tidak dapat dihapus.');
        }

        // Hapus file gambar & dokumentasi jika ada
        if ($campaign->image) Storage::disk('public')->delete($campaign->image);
        if ($campaign->documentation_1) Storage::disk('public')->delete($campaign->documentation_1);
        if ($campaign->documentation_2) Storage::disk('public')->delete($campaign->documentation_2);
        if ($campaign->documentation_3) Storage::disk('public')->delete($campaign->documentation_3);

        $campaign->delete();

        return redirect()->route('user.lapor-bencana')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}