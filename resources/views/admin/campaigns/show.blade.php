@extends('admin.layouts.app')

@section('title', 'Detail Kampanye')
@section('page_title', 'Detail Kampanye')

@push('styles')
<style>
  .form-section {
    background: #fff;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 4px rgba(15,23,42,0.07);
    border: none;
  }
  .section-title {
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: #64748b;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .info-box {
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 14px 16px;
    height: 100%;
  }
  .info-box .info-label { font-size: 0.75rem; color: #64748b; margin-bottom: 4px; }
  .info-box .info-value { font-size: 0.92rem; font-weight: 600; color: #0f172a; }

  .campaign-cover {
    width: 100%;
    max-height: 320px;
    object-fit: cover;
    border-radius: 12px;
  }

  .btn-action-detail {
    border-radius: 8px;
    font-size: 0.85rem;
    padding: 7px 18px;
    transition: all .2s ease;
    border: 1.5px solid transparent;
  }
  .btn-edit-detail { background:#eff6ff; color:#2563eb; border-color:#bfdbfe; }
  .btn-edit-detail:hover { background:#dbeafe; color:#1d4ed8; border-color:#93c5fd; transform:translateY(-1px); box-shadow:0 4px 12px rgba(37,99,235,0.15); }

  .btn-delete-detail { background:#fee2e2; color:#991b1b; border-color:#fecaca; }
  .btn-delete-detail:hover { background:#fecaca; color:#7f1d1d; border-color:#fca5a5; transform:translateY(-1px); box-shadow:0 4px 12px rgba(220,38,38,0.15); }

  .btn-back-detail { background:#fff; color:#64748b; border-color:#e2e8f0; }
  .btn-back-detail:hover { background:#f8fafc; color:#334155; border-color:#cbd5e1; transform:translateY(-1px); box-shadow:0 4px 12px rgba(15,23,42,0.08); }

  .coord-box {
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 12px 16px;
  }

  #detailMap { height: 200px; border-radius: 10px; border: 1.5px solid #e2e8f0; margin-top: 12px; }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-circle-info text-primary me-2"></i>{{ $campaign->title }}</h5>
    <p class="text-muted small mb-0">Rincian lengkap kampanye bencana dan status dana terkumpul.</p>
  </div>
  <div class="d-flex flex-wrap gap-2">
    <a href="{{ route('admin.campaigns.edit', $campaign) }}" class="btn-action-detail btn-edit-detail text-decoration-none">
      <i class="fa-solid fa-pen-to-square me-2"></i>Edit
    </a>
    <form action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kampanye ini?');" class="d-inline">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn-action-detail btn-delete-detail">
        <i class="fa-solid fa-trash me-2"></i>Hapus
      </button>
    </form>
    <a href="{{ route('admin.campaigns.index') }}" class="btn-action-detail btn-back-detail text-decoration-none">
      <i class="fa-solid fa-arrow-left me-2"></i>Kembali
    </a>
  </div>
</div>

<div class="row g-4">
  <div class="col-xl-8">

    {{-- Foto --}}
    @php
      $imgPath = $campaign->getRawOriginal('image');
      if (!$imgPath) {
          $imgUrl = asset('storage/assets/default-campaign.jpg');
      } elseif (str_starts_with($imgPath, 'http')) {
          $imgUrl = $imgPath;
      } elseif (str_starts_with($imgPath, 'storage/')) {
          $imgUrl = asset($imgPath);
      } else {
          $imgUrl = asset('storage/' . $imgPath);
      }
    @endphp
    <div class="form-section">
      <img src="{{ $imgUrl }}" class="campaign-cover" alt="{{ $campaign->title }}">
    </div>

    {{-- Deskripsi --}}
    <div class="form-section">
      <div class="section-title"><i class="fa-solid fa-align-left text-secondary"></i>Deskripsi Singkat</div>
      <p class="text-muted mb-4">{{ $campaign->description_short }}</p>

      <div class="section-title"><i class="fa-solid fa-align-left text-secondary"></i>Deskripsi Lengkap</div>
      <p class="text-muted mb-0">{{ $campaign->description_long }}</p>
    </div>

    {{-- Info Tambahan --}}
    <div class="form-section">
      <div class="section-title"><i class="fa-solid fa-circle-info text-primary"></i>Informasi Tambahan</div>
      <div class="row g-3">
        <div class="col-md-6">
          <div class="info-box">
            <div class="info-label"><i class="fa-solid fa-tag me-1"></i>Kategori</div>
            <div class="info-value">{{ $campaign->category }}</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="info-box">
            <div class="info-label"><i class="fa-solid fa-location-dot me-1"></i>Lokasi</div>
            <div class="info-value">{{ $campaign->location }}</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="info-box">
            <div class="info-label"><i class="fa-regular fa-calendar me-1"></i>Tanggal Publikasi</div>
            <div class="info-value">{{ $campaign->date_published }}</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="info-box">
            <div class="info-label"><i class="fa-solid fa-people-group me-1"></i>Orang Terdampak</div>
            <div class="info-value">{{ $campaign->victims ?? '-' }} orang</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-4">

    {{-- Status & Progress --}}
    <div class="form-section">
      <div class="section-title"><i class="fa-solid fa-chart-line text-success"></i>Status Kampanye</div>

      <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
          <div class="small text-muted mb-1">Status</div>
          <span class="badge {{ $campaign->status_class }}">{{ $campaign->status }}</span>
        </div>
        <div class="text-end">
          <div class="small text-muted mb-1">Sisa Hari</div>
          <div class="fw-semibold">{{ $campaign->days_left }} hari</div>
        </div>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="small text-muted">Target Donasi</span>
        <span class="fw-semibold">{{ $campaign->target }}</span>
      </div>
      <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="small text-muted">Terkumpul</span>
        <span class="fw-semibold">{{ $campaign->collected }}</span>
      </div>
      <div class="progress" style="height: 10px; border-radius: 99px;">
        <div class="progress-bar" role="progressbar"
          style="width: {{ $campaign->progress_raw }}%; background: {{ $campaign->progress_color }}; border-radius: 99px;"
          aria-valuenow="{{ $campaign->progress_raw }}" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <div class="mt-2 small text-muted">{{ $campaign->progress }} terkumpul</div>
    </div>

    {{-- Koordinat --}}
    <div class="form-section">
      <div class="section-title"><i class="fa-solid fa-location-crosshairs text-danger"></i>Koordinat Lokasi</div>
      <div class="coord-box mb-2">
        <div class="small text-muted mb-1">Latitude</div>
        <div class="fw-semibold">{{ $campaign->latitude ?? '-' }}</div>
      </div>
      <div class="coord-box">
        <div class="small text-muted mb-1">Longitude</div>
        <div class="fw-semibold">{{ $campaign->longitude ?? '-' }}</div>
      </div>

      @if($campaign->latitude && $campaign->longitude)
        <div id="detailMap"></div>
      @endif
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@if($campaign->latitude && $campaign->longitude)
<script>
  const detailMap = L.map('detailMap', {
    zoomControl: true,
    dragging: false,
    scrollWheelZoom: false,
    doubleClickZoom: false
  }).setView([{{ $campaign->latitude }}, {{ $campaign->longitude }}], 13);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
  }).addTo(detailMap);

  L.marker([{{ $campaign->latitude }}, {{ $campaign->longitude }}]).addTo(detailMap);
</script>
@endif
@endpush