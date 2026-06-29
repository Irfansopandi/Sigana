@extends('admin.layouts.app')

@section('title', 'Riwayat Kampanye Selesai')
@section('page_title', 'Riwayat Kampanye')

@push('styles')
<style>
  .stat-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    border-left-width: 4px;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    transition: transform .2s ease, box-shadow .2s ease;
    cursor: default;
  }
  .stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(10,37,64,.1);
  }
  .stat-card.green  { border-left-color: #16a34a; }
  .stat-card.blue   { border-left-color: #3b82f6; }
  .stat-card.yellow { border-left-color: #ca8a04; }
  .stat-card.purple { border-left-color: #9333ea; }

  .stat-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
  }
  .stat-label { font-size: 0.78rem; color: #94a3b8; font-weight: 500; }
  .stat-value { font-size: 1.5rem; font-weight: 700; color: #0a2540; line-height: 1.1; }

  .filter-bar {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    padding: 16px 20px;
  }

  .archive-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    transition: box-shadow .2s, transform .2s;
  }
  .archive-card:hover {
    box-shadow: 0 8px 24px rgba(10,37,64,.08);
    transform: translateY(-2px);
  }
  .archive-img {
    height: 140px;
    object-fit: cover;
    width: 100%;
  }
  .archive-card {
    border-radius: 16px !important;
  }
  .archive-body { padding: 16px; }
  .archive-location {
    font-size: 0.78rem;
    color: #64748b;
    margin-bottom: 6px;
  }
  .archive-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: #0a2540;
    margin-bottom: 10px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  .progress-wrap { margin-bottom: 10px; }
  .progress-labels {
    display: flex;
    justify-content: space-between;
    font-size: 0.75rem;
    margin-bottom: 4px;
    color: #64748b;
  }
  .progress-labels strong { color: #0a2540; }
  .progress { height: 6px; border-radius: 3px; background: #f1f5f9; }
  .archive-meta {
    display: flex;
    justify-content: space-between;
    font-size: 0.75rem;
    color: #94a3b8;
    margin-bottom: 14px;
  }
  .badge-selesai {
    background: #f0fdf4;
    color: #16a34a;
    border: 1px solid #bbf7d0;
    font-size: 0.7rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
  }
  .badge-cat {
    background: #f8fafc;
    color: #475569;
    border: 1px solid #e2e8f0;
    font-size: 0.7rem;
    font-weight: 500;
    padding: 3px 10px;
    border-radius: 20px;
  }
  .btn-detail-arc {
    width: 100%;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    color: #0a2540;
    border-radius: 10px;
    font-size: 0.82rem;
    font-weight: 600;
    padding: 8px;
    transition: all .2s;
    text-decoration: none;
    display: block;
    text-align: center;
  }
  .btn-detail-arc:hover {
    background: #0a2540;
    color: #fff;
    border-color: #0a2540;
  }

  .empty-box {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    padding: 60px 20px;
    text-align: center;
  }
  .empty-box i { font-size: 3rem; color: #cbd5e1; margin-bottom: 16px; }
  .empty-box h5 { color: #64748b; font-weight: 600; }
  .empty-box p { color: #94a3b8; font-size: 0.88rem; }

  .page-header-box {
    background: linear-gradient(135deg, #0a2540 0%, #173f66 100%);
    border-radius: 16px;
    padding: 24px 28px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
  }
  .page-header-box h4 { color: #fff; font-weight: 700; margin: 0; font-size: 1.2rem; }
  .page-header-box p { color: rgba(255,255,255,.6); margin: 4px 0 0; font-size: 0.85rem; }
  .breadcrumb-arc a { color: rgba(255,255,255,.5); text-decoration: none; font-size: 0.8rem; }
  .breadcrumb-arc span { color: rgba(255,255,255,.8); font-size: 0.8rem; }
  .breadcrumb-arc i { color: rgba(255,255,255,.3); font-size: 0.65rem; margin: 0 6px; }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header-box">
  <div>
    <div class="breadcrumb-arc mb-2">
      <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge me-1"></i>Dashboard</a>
      <i class="fa-solid fa-chevron-right"></i>
      <a href="{{ route('admin.campaigns.index') }}">Kampanye</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span>Riwayat Selesai</span>
    </div>
    <h4><i class="fa-solid fa-clock-rotate-left me-2"></i>Riwayat Kampanye Selesai</h4>
    <p>Arsip seluruh kampanye bencana yang telah berakhir masa aktifnya.</p>
  </div>
  <a href="{{ route('admin.campaigns.index') }}" class="btn btn-sm btn-light rounded-pill px-4">
    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Aktif
  </a>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
  <div class="col-6 col-lg-3">
    <div class="stat-card green">
      <div class="stat-icon" style="background:#f0fdf4;">
        <i class="fa-solid fa-circle-check" style="color:#16a34a;"></i>
      </div>
      <div>
        <div class="stat-label">Total Selesai</div>
        <div class="stat-value">{{ $totalArchived }}</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="stat-card blue">
      <div class="stat-icon" style="background:#eff6ff;">
        <i class="fa-solid fa-hand-holding-heart" style="color:#3b82f6;"></i>
      </div>
      <div>
        <div class="stat-label">Total Terkumpul</div>
        <div class="stat-value" style="font-size:1.1rem;">Rp{{ number_format($totalCollected, 0, ',', '.') }}</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="stat-card yellow">
      <div class="stat-icon" style="background:#fefce8;">
        <i class="fa-solid fa-bullseye" style="color:#f59e0b;"></i>
      </div>
      <div>
        <div class="stat-label">Total Target</div>
        <div class="stat-value" style="font-size:1.1rem;">Rp{{ number_format($totalTarget, 0, ',', '.') }}</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="stat-card purple">
      <div class="stat-icon" style="background:#fdf4ff;">
        <i class="fa-solid fa-percent" style="color:#9333ea;"></i>
      </div>
      <div>
        <div class="stat-label">Rata-rata Capaian</div>
        <div class="stat-value">{{ $avgProgress }}%</div>
      </div>
    </div>
  </div>
</div>

{{-- Filter Bar --}}
<div class="filter-bar mb-4">
  <form method="GET" action="{{ route('admin.campaigns.archived') }}" class="row g-3 align-items-center">
    <div class="col-12 col-md-5">
      <div class="input-group">
        <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
        <input type="text" name="search" value="{{ request('search') }}"
          class="form-control border-start-0" placeholder="Cari judul atau lokasi kampanye...">
      </div>
    </div>
    <div class="col-6 col-md-3">
      <select name="category" class="form-select">
        <option value="">Semua Kategori</option>
        <option value="banjir"  {{ request('category') == 'banjir'  ? 'selected' : '' }}>Banjir</option>
        <option value="gempa"   {{ request('category') == 'gempa'   ? 'selected' : '' }}>Gempa</option>
        <option value="erupsi"  {{ request('category') == 'erupsi'  ? 'selected' : '' }}>Erupsi</option>
        <option value="lainnya" {{ request('category') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
      </select>
    </div>
    <div class="col-6 col-md-2">
      <select name="sort" class="form-select">
        <option value="newest"   {{ request('sort') == 'newest'   ? 'selected' : '' }}>Terbaru</option>
        <option value="oldest"   {{ request('sort') == 'oldest'   ? 'selected' : '' }}>Terlama</option>
        <option value="progress" {{ request('sort') == 'progress' ? 'selected' : '' }}>Capaian</option>
      </select>
    </div>
    <div class="col-12 col-md-2 d-flex gap-2">
      <button type="submit" class="btn btn-primary flex-fill rounded-pill">
        <i class="fa-solid fa-filter me-1"></i> Filter
      </button>
      @if(request()->hasAny(['search','category','sort']))
        <a href="{{ route('admin.campaigns.archived') }}" class="btn btn-outline-secondary rounded-pill px-3">
          <i class="fa-solid fa-xmark"></i>
        </a>
      @endif
    </div>
  </form>
</div>

{{-- Grid Kampanye Selesai --}}
@if($campaigns->count())
<div class="row g-3 mb-4">
  @foreach($campaigns as $campaign)
  @php
    $imgPath = $campaign->getRawOriginal('image');
    if (!$imgPath) {
        $imgUrl = null;
    } elseif (str_starts_with($imgPath, 'http')) {
        $imgUrl = $imgPath;
    } elseif (str_starts_with($imgPath, 'storage/')) {
        // data dummy: storage/assets/bencana/xxx.png
        $imgUrl = asset($imgPath);
    } else {
        // upload user: campaigns/xxx.png
        $imgUrl = asset('storage/' . $imgPath);
    }
  @endphp
  <div class="col-lg-3 col-md-6">
    <div class="archive-card">

      {{-- Gambar --}}
      <div class="position-relative">
        @if($imgUrl)
          <img src="{{ $imgUrl }}" alt="{{ $campaign->title }}" class="archive-img">
        @else
          <div class="archive-img d-flex align-items-center justify-content-center" style="background:linear-gradient(135deg,#e2e8f0,#f1f5f9);">
            <i class="fa-solid fa-image fa-2x text-muted opacity-50"></i>
          </div>
        @endif
        {{-- Badge overlay --}}
        <div class="position-absolute top-0 start-0 p-2 d-flex gap-1 flex-wrap">
          <span class="badge-selesai"><i class="fa-solid fa-circle-check me-1"></i>Selesai</span>
        </div>
        <div class="position-absolute top-0 end-0 p-2">
          <span class="badge rounded-pill px-2 py-1" style="font-size:0.68rem; background:rgba(0,0,0,0.45); color:#fff; backdrop-filter:blur(4px);">
            {{ ucfirst($campaign->category) }}
          </span>
        </div>
      </div>

      <div class="archive-body">

        {{-- Lokasi --}}
        <div class="archive-location mb-1">
          <i class="fa-solid fa-location-dot text-danger me-1"></i>{{ $campaign->location }}
        </div>

        {{-- Judul --}}
        <div class="archive-title">{{ $campaign->title }}</div>

        {{-- Progress --}}
        <div class="progress-wrap">
          <div class="progress-labels">
            <span>Terkumpul: <strong>{{ $campaign->collected }}</strong></span>
            <strong style="color:{{ $campaign->progress_color }}">{{ $campaign->progress }}</strong>
          </div>
          <div class="progress">
            <div class="progress-bar"
              style="width:{{ min($campaign->progress_raw, 100) }}%; background-color:{{ $campaign->progress_color }} !important;"
              role="progressbar">
            </div>
          </div>
        </div>

        {{-- Meta --}}
        <div class="archive-meta mt-2">
          <span><i class="fa-solid fa-bullseye me-1"></i>{{ $campaign->target }}</span>
          <span><i class="fa-regular fa-calendar me-1"></i>{{ $campaign->deadline }}</span>
        </div>

        {{-- Durasi --}}
        <div class="d-flex justify-content-between align-items-center mb-3 px-3 py-2 rounded-3" style="background:#f8fafc; border:1px solid #e2e8f0;">
          <span style="font-size:0.75rem; color:#64748b;">
            <i class="fa-solid fa-hourglass-end me-1 text-muted"></i>Durasi Kampanye
          </span>
          <strong style="font-size:0.8rem; color:#0a2540;">{{ $campaign->duration }} hari</strong>
        </div>

        {{-- Action --}}
        <a href="{{ route('admin.campaigns.show', $campaign) }}" class="btn-detail-arc">
          <i class="fa-solid fa-eye me-1"></i> Lihat Detail
        </a>
      </div>
    </div>
  </div>
  @endforeach
</div>

{{-- Pagination --}}
<div class="d-flex justify-content-center">
  {{ $campaigns->withQueryString()->links() }}
</div>

@else
{{-- Empty State --}}
<div class="empty-box">
  <i class="fa-regular fa-folder-open d-block"></i>
  <h5>Belum Ada Kampanye Selesai</h5>
  <p>Kampanye yang telah habis masa aktifnya akan muncul di sini secara otomatis.</p>
</div>
@endif

@endsection