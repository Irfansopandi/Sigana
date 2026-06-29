<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransparencyReport;
use Illuminate\Http\Request;
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

        return view('admin.transparency.index', compact(
            'reports', 'totalAll', 'totalAktif', 'totalPenyaluran', 'totalSelesai'
        ));
    }

    public function show(TransparencyReport $report)
    {
        $statusOptions = [
            'Aktif' => 'Aktif',
            'Dalam Penyaluran' => 'Dalam Penyaluran',
            'Hampir Selesai' => 'Hampir Selesai',
        ];

        return view('admin.transparency.show', compact('report', 'statusOptions'));
    }

    public function update(Request $request, TransparencyReport $report)
    {
        $validated = $request->validate([
            'status' => 'required|in:Aktif,Dalam Penyaluran,Hampir Selesai',
        ]);

        $report->update(array_merge($validated, $this->statusMeta($validated['status'])));
        $report->refresh();
        NotificationService::transparencyUpdated($report);

        return redirect()->route('admin.transparency.index')->with('success', 'Status laporan berhasil diperbarui.');
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
            default => [
                'status_class' => 'transparency-badge-aktif',
                'status_icon' => 'fa-solid fa-circle-dot',
            ],
        };
    }
}
