@extends('relawan.layouts.app')

@section('title', 'Bencana Diikuti - Selesai')
@section('page_title', 'Bencana Diikuti')

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

  /* Progress animasi */
  .progress-bar {
    transition: width 1s ease-in-out;
  }
  .btn-action { border-radius: 8px; font-size: 0.82rem; padding: 5px 14px; transition: all .2s ease; }
  .btn-detail  { background:#eff6ff; color:#2563eb; border:1.5px solid #bfdbfe; }
  .btn-detail:hover  { background:#2563eb; color:#fff; border-color:#2563eb; transform:translateY(-1px); }
</style>
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-clipboard-list text-success me-2"></i>Bencana Diikuti</h5>
    <p class="text-muted small mb-0">Kelola dan pantau program bencana yang kamu ikuti sebagai relawan.</p>
  </div>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
  <div class="col-6 col-md-4">
    <div class="card border-0 shadow-sm h-100 stat-card-item" style="border-radius:16px; border-left:4px solid #2563eb !important;">
      <div class="card-body d-flex align-items-center gap-3 p-3">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(37,99,235,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="fa-solid fa-layer-group" style="color:#2563eb;font-size:1.2rem;"></i>
        </div>
        <div>
          <div class="small" style="color:#64748b;">Total Bencana Diikuti</div>
          <div class="fw-bold" style="font-size:1.4rem;color:#0f172a;">{{ $stats['total'] }}</div>
        </div>
      </div>  
    </div>
  </div>
  <div class="col-6 col-md-4">
    <div class="card border-0 shadow-sm h-100 stat-card-item" style="border-radius:16px; border-left:4px solid #059669 !important;">
      <div class="card-body d-flex align-items-center gap-3 p-3">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(5,150,105,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="fa-solid fa-circle-check" style="color:#059669;font-size:1.2rem;"></i>
        </div>
        <div>
          <div class="small" style="color:#64748b;">Bencana Aktif</div>
          <div class="fw-bold" style="font-size:1.4rem;color:#0f172a;">{{ $stats['aktif'] }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-4">
    <div class="card border-0 shadow-sm h-100 stat-card-item" style="border-radius:16px; border-left:4px solid #dc2626 !important;">
      <div class="card-body d-flex align-items-center gap-3 p-3">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(220,38,38,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="fa-solid fa-circle-xmark" style="color:#dc2626;font-size:1.2rem;"></i>
        </div>
        <div>
          <div class="small" style="color:#64748b;">Bencana Selesai</div>
          <div class="fw-bold" style="font-size:1.4rem;color:#0f172a;">{{ $stats['selesai'] }}</div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Tab Filter --}}
<div class="d-flex gap-2 mb-4">
  <a href="{{ route('relawan.bencana-diikuti') }}"
    class="btn btn-sm"
    style="border-radius:8px; font-size:0.85rem; padding:6px 18px; transition:all .2s;
      background:#fff; color:#64748b; border:1.5px solid #e2e8f0;">
    Bencana Aktif
    <span class="ms-1 badge rounded-pill" style="font-size:0.7rem; background:#f1f5f9; color:#64748b;">
      {{ $stats['aktif'] }}
    </span>
  </a>
  <a href="{{ route('relawan.bencana-diikuti.selesai') }}"
    class="btn btn-sm"
    style="border-radius:8px; font-size:0.85rem; padding:6px 18px; transition:all .2s;
      background:#eff6ff; color:#2563eb; border:1.5px solid #bfdbfe; font-weight:600;">
    Bencana Selesai
    <span class="ms-1 badge rounded-pill" style="font-size:0.7rem; background:#2563eb; color:#fff;">
      {{ $stats['selesai'] }}
    </span>
  </a>
</div>

{{-- Campaign Cards --}}
<div class="row g-3">
  @forelse($campaigns as $campaign)
  <div class="col-lg-3 col-md-6">
    <div class="card campaign-card shadow-sm h-100">

      {{-- Foto --}}
      @if($campaign->image)
        <img src="{{ $campaign->image_url }}" alt="{{ $campaign->title }}" class="campaign-img">
      @else
        <div class="campaign-img-placeholder">
          <i class="fa-solid fa-image"></i>
        </div>
      @endif

      <div class="card-body p-3 d-flex flex-column">
        {{-- Judul & Lokasi --}}
        <h6 class="fw-bold mb-1" style="font-size:0.85rem; line-height:1.3;">{{ $campaign->title }}</h6>
        <div class="small text-muted mb-2"><i class="fa-solid fa-location-dot me-1"></i>{{ $campaign->location }}</div>
        @if($campaign->user)
          <div class="small text-muted mb-2" style="font-size:0.75rem;">
            <i class="fa-solid fa-user me-1"></i>Pelapor: <span class="fw-semibold text-dark">{{ $campaign->user->name }}</span>
          </div>
        @else
          <div class="small text-muted mb-2" style="font-size:0.75rem;">
            <i class="fa-solid fa-user-shield me-1"></i><span class="fst-italic">Dibuat oleh Admin</span>
          </div>
        @endif

        {{-- Badge Status --}}
        <div class="d-flex gap-1 flex-wrap mb-3">
          <span class="badge rounded-pill px-2 py-1" style="font-size:0.7rem; {{ $campaign->status === 'Darurat' ? 'background:#fee2e2;color:#991b1b;' : ($campaign->status === 'Waspada' ? 'background:#fef9c3;color:#854d0e;' : 'background:#dcfce7;color:#166534;') }}">
            {{ $campaign->status }}
          </span>
        </div>

        {{-- Progress --}}
        <div class="small text-muted mb-1 mt-auto" style="font-size:0.75rem;">
          Terkumpul <span class="fw-semibold text-dark">{{ $campaign->collected }}</span> dari <span class="fw-semibold text-dark">{{ $campaign->target }}</span>
        </div>
        <div class="progress mb-1" style="height:5px;border-radius:99px;">
          <div class="progress-bar" role="progressbar"
            style="width:{{ $campaign->progress_raw }}%; background:{{ $campaign->progress_color }}; border-radius:99px;">
          </div>
        </div>
        <div class="small text-muted mb-3" style="font-size:0.75rem;">{{ $campaign->progress }}</div>

        {{-- Actions --}}
        <div class="d-grid mt-2">
          <a href="{{ route('relawan.sertifikat', $campaign->id) }}" class="btn btn-sm btn-action btn-detail text-center">
            <i class="fa-solid fa-certificate me-1"></i>Lihat Sertifikat
          </a>
        </div>
      </div>
    </div>
  </div>
  @empty
  <div class="col-12">
    <div class="text-center text-muted py-5 card border-0 shadow-sm" style="border-radius: 16px;">
      <i class="fa-solid fa-hand-holding-heart fa-2x mb-3 d-block opacity-30"></i>
      Belum ada kampanye bencana selesai yang diikuti.
    </div>
  </div>
  @endforelse
</div>

@endsection
