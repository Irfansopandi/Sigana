@extends('relawan.layouts.app')

@section('title', 'Laporan Bencana')
@section('page_title', 'Laporan Bencana')

@push('styles')
<style>
  .stat-card-item {
    transition: transform .2s ease, box-shadow .2s ease;
  }
  .stat-card-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(15, 23, 42, 0.10) !important;
  }
  .campaign-card {
    border-radius: 1rem;
    border: none;
    transition: transform .2s ease, box-shadow .2s ease;
    overflow: hidden;
  }
  .campaign-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(15, 23, 42, 0.10) !important;
  }
  .campaign-img {
    width: 100%;
    height: 150px;
    object-fit: cover;
  }
  .campaign-img-placeholder {
    width: 100%;
    height: 150px;
    background: linear-gradient(135deg, #e2e8f0, #f1f5f9);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 2.5rem;
  }

  .status-pill {
    font-size: 0.7rem;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 99px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }
  .status-pending  { background:#fef9c3; color:#854d0e; }
  .status-approved { background:#dcfce7; color:#166534; }
  .status-rejected { background:#fee2e2; color:#991b1b; }
  .status-none     { background:#f1f5f9; color:#64748b; }

  .btn-action { border-radius: 8px; font-size: 0.78rem; padding: 5px 10px; transition: all .2s ease; white-space: nowrap; }
  .btn-detail { background:#eff6ff; color:#2563eb; border:1.5px solid #bfdbfe; }
  .btn-detail:hover { background:#2563eb; color:#fff; border-color:#2563eb; transform:translateY(-1px); }
  .btn-edit   { background:#fffbeb; color:#92400e; border:1.5px solid #fde68a; }
  .btn-edit:hover   { background:#d97706; color:#fff; border-color:#d97706; transform:translateY(-1px); }
  .btn-create { background:#fffbeb; color:#92400e; border:1.5px solid #fde68a; }
  .btn-create:hover { background:#d97706; color:#fff; border-color:#d97706; transform:translateY(-1px); }
</style>
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-file-lines text-warning me-2"></i>Laporan Bencana</h5>
    <p class="text-muted small mb-0">Kelola laporan transparansi untuk bencana yang kamu koordinatori.</p>
  </div>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100 stat-card-item" style="border-radius:16px; border-left:4px solid #0a2540 !important;">
      <div class="card-body d-flex align-items-center gap-3 p-3">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(10,37,64,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="fa-solid fa-layer-group" style="color:#0a2540;font-size:1.2rem;"></i>
        </div>
        <div>
          <div class="small" style="color:#64748b;">Bencana Dikoordinatori</div>
          <div class="fw-bold" style="font-size:1.4rem;color:#0f172a;">{{ $stats['total_campaign'] }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100 stat-card-item" style="border-radius:16px; border-left:4px solid #d97706 !important;">
      <div class="card-body d-flex align-items-center gap-3 p-3">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(217,119,6,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="fa-solid fa-hourglass-half" style="color:#d97706;font-size:1.2rem;"></i>
        </div>
        <div>
          <div class="small" style="color:#64748b;">Menunggu</div>
          <div class="fw-bold" style="font-size:1.4rem;color:#0f172a;">{{ $stats['pending'] }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100 stat-card-item" style="border-radius:16px; border-left:4px solid #059669 !important;">
      <div class="card-body d-flex align-items-center gap-3 p-3">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(5,150,105,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="fa-solid fa-circle-check" style="color:#059669;font-size:1.2rem;"></i>
        </div>
        <div>
          <div class="small" style="color:#64748b;">Disetujui</div>
          <div class="fw-bold" style="font-size:1.4rem;color:#0f172a;">{{ $stats['approved'] }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100 stat-card-item" style="border-radius:16px; border-left:4px solid #dc2626 !important;">
      <div class="card-body d-flex align-items-center gap-3 p-3">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(220,38,38,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="fa-solid fa-circle-xmark" style="color:#dc2626;font-size:1.2rem;"></i>
        </div>
        <div>
          <div class="small" style="color:#64748b;">Ditolak</div>
          <div class="fw-bold" style="font-size:1.4rem;color:#0f172a;">{{ $stats['rejected'] }}</div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Tab Filter --}}
@php
  $tabs = [
    'all'      => ['label' => 'Semua', 'count' => $stats['total_campaign'], 'color' => '#0a2540'],
    'none'     => ['label' => 'Belum Lapor', 'count' => $stats['none'], 'color' => '#64748b'],
    'pending'  => ['label' => 'Menunggu', 'count' => $stats['pending'], 'color' => '#d97706'],
    'approved' => ['label' => 'Disetujui', 'count' => $stats['approved'], 'color' => '#059669'],
    'rejected' => ['label' => 'Ditolak', 'count' => $stats['rejected'], 'color' => '#dc2626'],
  ];
@endphp
<div class="d-flex gap-2 mb-4 flex-wrap">
  @foreach($tabs as $key => $tab)
    @php $isActive = $status === $key; @endphp
    <a href="{{ route('relawan.coordinator-reports.index', ['status' => $key]) }}"
      class="btn btn-sm"
      style="border-radius:8px; font-size:0.85rem; padding:6px 18px; transition:all .2s;
        {{ $isActive
          ? 'background:'.$tab['color'].'1a; color:'.$tab['color'].'; border:1.5px solid '.$tab['color'].'66; font-weight:600;'
          : 'background:#fff; color:#64748b; border:1.5px solid #e2e8f0;' }}">
      {{ $tab['label'] }}
      <span class="ms-1 badge rounded-pill" style="font-size:0.7rem; {{ $isActive ? 'background:'.$tab['color'].';color:#fff;' : 'background:#f1f5f9;color:#64748b;' }}">
        {{ $tab['count'] }}
      </span>
    </a>
  @endforeach
</div>

{{-- Campaign Cards --}}
<div class="row g-3">
  @forelse($campaigns as $campaign)
    @php $report = $campaign->reports->first(); @endphp
    <div class="col-lg-3 col-md-6">
      <div class="card campaign-card shadow-sm h-100">

        @if($campaign->image)
          <img src="{{ $campaign->image_url }}" alt="{{ $campaign->title }}" class="campaign-img">
        @else
          <div class="campaign-img-placeholder">
            <i class="fa-solid fa-image"></i>
          </div>
        @endif

        <div class="card-body p-3 d-flex flex-column">
          <h6 class="fw-bold mb-1" style="font-size:0.85rem; line-height:1.3;">{{ $campaign->title }}</h6>
          <div class="small text-muted mb-2" style="font-size:0.75rem;">
            <i class="fa-solid fa-location-dot me-1"></i>{{ $campaign->location }}
          </div>
          <div class="small mb-2" style="font-size:0.78rem;">
            <i class="fa-solid fa-sack-dollar text-success me-1"></i>Dana Terkumpul: <span class="fw-semibold text-dark">{{ $campaign->collected }}</span>
          </div>

          <div class="mb-3">
            @if(!$report)
              <span class="status-pill status-none"><i class="fa-solid fa-circle-minus"></i> Belum Ada Laporan</span>
            @elseif($report->status === 'pending')
              <span class="status-pill status-pending"><i class="fa-solid fa-hourglass-half"></i> Menunggu Verifikasi</span>
            @elseif($report->status === 'approved')
              <span class="status-pill status-approved"><i class="fa-solid fa-circle-check"></i> Disetujui</span>
            @else
              <span class="status-pill status-rejected"><i class="fa-solid fa-circle-xmark"></i> Ditolak</span>
            @endif
          </div>

          @if($report)
            <div class="d-flex gap-3 flex-wrap small mb-3 mt-auto" style="font-size:0.78rem;">
              <div><i class="fa-solid fa-users text-muted me-1"></i>{{ $report->victim_helped }} korban</div>
              <div><i class="fa-solid fa-sack-dollar text-muted me-1"></i>Rp{{ number_format($report->total_distribution, 0, ',', '.') }}</div>
            </div>
            @if($report->status === 'rejected' && $report->rejection_note)
              <div class="small mb-3 p-2" style="background:#fef2f2;border-radius:8px;color:#991b1b;font-size:0.75rem;">
                <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $report->rejection_note }}
              </div>
            @endif
          @else
            <div class="small text-muted mb-3 mt-auto fst-italic" style="font-size:0.78rem;">
              Kamu koordinator bencana ini. Buat laporan transparansi penyaluran bantuan.
            </div>
          @endif

          <div class="d-flex gap-2 mt-2">
            @if($report)
              <a href="{{ route('relawan.coordinator-reports.show', $report->id) }}" class="btn btn-sm btn-action btn-detail text-center flex-fill">
                <i class="fa-solid fa-eye me-1"></i>Detail
              </a>
              @if($report->status !== 'approved')
                <a href="{{ route('relawan.coordinator-reports.edit', $report->id) }}" class="btn btn-sm btn-action btn-edit text-center flex-fill">
                  @if($report->status === 'rejected')
                    <i class="fa-solid fa-rotate-right me-1"></i>Edit & Kirim Ulang
                  @else
                    <i class="fa-solid fa-pen me-1"></i>Edit
                  @endif
                </a>
              @endif
            @else
              <a href="{{ route('relawan.coordinator-reports.create', ['campaign_id' => $campaign->id]) }}" class="btn btn-sm btn-action btn-create text-center flex-fill">
                <i class="fa-solid fa-file-circle-plus me-1"></i>Buat Laporan
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>
  @empty
    <div class="col-12">
      <div class="text-center text-muted py-5 card border-0 shadow-sm" style="border-radius: 16px;">
        <i class="fa-solid fa-crown fa-2x mb-3 d-block opacity-30"></i>
        Kamu belum ditunjuk sebagai koordinator bencana manapun.
      </div>
    </div>
  @endforelse
</div>

@endsection

@push('scripts')
<script>
@if(session('success'))
  Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: '{{ session('success') }}',
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    background: '#f0fdf4',
    color: '#166534',
    iconColor: '#22c55e',
  });
@endif

@if(session('error'))
  Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'warning',
    title: '{{ session('error') }}',
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    background: '#fffbeb',
    color: '#92400e',
    iconColor: '#f59e0b',
  });
@endif
</script>
@endpush