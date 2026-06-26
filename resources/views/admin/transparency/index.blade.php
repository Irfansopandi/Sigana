@extends('admin.layouts.app')

@section('title', 'Laporan Transparansi')
@section('page_title', 'Laporan Transparansi')

@section('content')
<div class="mb-4">
  <h5 class="fw-bold mb-1"><i class="fa-solid fa-file-lines text-info me-2"></i>Laporan Transparansi</h5>
  <p class="text-muted small mb-0">Review dan verifikasi laporan transparansi untuk setiap kampanye.</p>
</div>

<div class="row g-3">
  @forelse($reports as $report)
  <div class="col-lg-6">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <div>
            <h6 class="fw-semibold mb-1">{{ $report->campaign->title ?? 'Kampanye tidak tersedia' }}</h6>
            <div class="small text-muted">{{ $report->date }}</div>
          </div>
          <span class="badge bg-secondary">{{ $report->status }}</span>
        </div>
        <p class="small text-muted">{{ Str::limit($report->description, 120, '...') }}</p>
        <div class="d-flex gap-3 mt-3">
          <div>
            <div class="small text-muted">Digunakan</div>
            <div class="fw-semibold">{{ $report->used }}</div>
          </div>
          <div>
            <div class="small text-muted">Sisa</div>
            <div class="fw-semibold">{{ $report->remaining }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @empty
  <div class="col-12 text-center text-muted">Belum ada laporan transparansi.</div>
  @endforelse
</div>

<div class="mt-4">{{ $reports->links() }}</div>
@endsection
