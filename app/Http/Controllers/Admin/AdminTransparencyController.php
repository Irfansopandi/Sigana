<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransparencyReport;
use Illuminate\Http\Request;

class AdminTransparencyController extends Controller
{
    public function index()
    {
        $reports = TransparencyReport::latest()->paginate(10);
        return view('admin.transparency.index', compact('reports'));
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
