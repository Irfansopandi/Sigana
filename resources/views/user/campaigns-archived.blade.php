@extends('user.layouts.app')

@section('title', 'Kampanye Selesai')
@section('page_title', 'Kampanye Selesai')

@push('styles')
<style>
  .page-header {
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
  .page-header h5 { color: #fff; font-weight: 700; margin: 0; }
  .page-header p  { color: rgba(255,255,255,.6); margin: 4px 0 0; font-size: 0.85rem; }

  .summary-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    padding: 18px 22px;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: transform .2s, box-shadow .2s;
  }
  .summary-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(10,37,64,.08); }
  .summary-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; flex-shrink: 0;
  }
  .summary-label { font-size: 0.75rem; color: #94a3b8; font-weight: 500; }
  .summary-value { font-size: 1.35rem; font-weight: 700; color: #0a2540; line-height: 1.1; }

  .campaign-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    transition: transform .2s, box-shadow .2s;
    height: 100%;
  }
  .campaign-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 28px rgba(10,37,64,.10);
  }
  .campaign-img {
    width: 100%; height: 150px;
    object-fit: cover;
  }
  .campaign-img-placeholder {
    width: 100%; height: 150px;
    background: linear-gradient(135deg, #e2e8f0, #f1f5f9);
    display: flex; align-items: center; justify-content: center;
    color: #94a3b8; font-size: 2rem;
  }
  .campaign-body { padding: 16px; }
  .campaign-location { font-size: 0.75rem; color: #64748b; margin-bottom: 4px; }
  .campaign-title {
    font-size: 0.9rem; font-weight: 700; color: #0a2540;
    margin-bottom: 10px; line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  .progress-label { font-size: 0.73rem; color: #64748b; }
  .progress-label strong { color: #0a2540; }
  .progress { height: 6px; border-radius: 3px; background: #f1f5f9; margin: 4px 0 8px; }
  .campaign-meta {
    display: flex; justify-content: space-between;
    font-size: 0.73rem; color: #94a3b8; margin-bottom: 12px;
  }
  .info-row {
    display: flex; justify-content: space-between; align-items: center;
    background: #f8fafc; border: 1px solid #e2e8f0;
    border-radius: 10px; padding: 8px 12px; margin-bottom: 12px;
    font-size: 0.75rem;
  }
  .info-row span { color: #64748b; }
  .info-row strong { color: #0a2540; font-size: 0.8rem; }

  .badge-selesai {
    background: #f0fdf4; color: #16a34a;
    border: 1px solid #bbf7d0;
    font-size: 0.68rem; font-weight: 600;
    padding: 3px 10px; border-radius: 20px;
  }
  .badge-cat {
    font-size: 0.68rem; font-weight: 500;
    padding: 3px 10px; border-radius: 20px;
    background: rgba(0,0,0,.4); color: #fff;
    backdrop-filter: blur(4px);
  }
  .btn-detail {
    display: block; width: 100%; text-align: center;
    background: #f8fafc; border: 1px solid #e2e8f0;
    color: #0a2540; border-radius: 10px;
    font-size: 0.82rem; font-weight: 600;
    padding: 8px; text-decoration: none;
    transition: all .2s;
  }
  .btn-detail:hover { background: #0a2540; color: #fff; border-color: #0a2540; }

  .empty-box {
    background: #fff; border-radius: 16px;
    border: 1px solid #e2e8f0;
    padding: 60px 20px; text-align: center;
  }
  .empty-box i { font-size: 3rem; color: #cbd5e1; margin-bottom: 16px; display: block; }
  .empty-box h5 { color: #64748b; font-weight: 600; }
  .empty-box p  { color: #94a3b8; font-size: 0.88rem; }

  .filter-bar {
    background: #fff; border-radius: 14px;
    border: 1px solid #e2e8f0; padding: 14px 18px;
    margin-bottom: 20px;
  }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
  <div>
    <h5><i class="fa-solid fa-clock-rotate-left me-2"></i>Kampanye Bencana Selesai</h5>
    <p>Arsip kampanye donasi bencana yang telah berakhir masa aktifnya.</p>
  </div>
  <a href="{{ route('user.campaigns') }}" class="btn btn-sm btn-light rounded-pill px-4">
    <i class="fa-solid fa-arrow-left me-1"></i> Kampanye Aktif
  </a>
</div>

{{-- Summary Cards --}}
<div class="row g-3 mb-4">
  <div class="col-6 col-lg-3">
    <div class="summary-card" style="border-left: 4px solid #16a34a;">
      <div class="summary-icon" style="background:#f0fdf4;">
        <i class="fa-solid fa-circle-check" style="color:#16a34a;"></i>
      </div>
      <div>
        <div class="summary-label">Total Selesai</div>
        <div class="summary-value">{{ $campaigns->count() }}</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="summary-card" style="border-left: 4px solid #3b82f6;">
      <div class="summary-icon" style="background:#eff6ff;">
        <i class="fa-solid fa-hand-holding-heart" style="color:#3b82f6;"></i>
      </div>
      <div>
        <div class="summary-label">Total Terkumpul</div>
        <div class="summary-value" style="font-size:1.05rem;">
          Rp{{ number_format($campaigns->sum('collected_raw'), 0, ',', '.') }}
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="summary-card" style="border-left: 4px solid #f59e0b;">
      <div class="summary-icon" style="background:#fefce8;">
        <i class="fa-solid fa-bullseye" style="color:#f59e0b;"></i>
      </div>
      <div>
        <div class="summary-label">Total Target</div>
        <div class="summary-value" style="font-size:1.05rem;">
          Rp{{ number_format($campaigns->sum('target_raw'), 0, ',', '.') }}
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="summary-card" style="border-left: 4px solid #9333ea;">
      <div class="summary-icon" style="background:#fdf4ff;">
        <i class="fa-solid fa-percent" style="color:#9333ea;"></i>
      </div>
      <div>
        <div class="summary-label">Rata-rata Capaian</div>
        <div class="summary-value">
          {{ $campaigns->count() > 0 ? round($campaigns->avg('progress_raw'), 1) : 0 }}%
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Filter --}}
<div class="filter-bar">
  <div class="row g-3 align-items-center">
    <div class="col-12 col-md-6">
      <div class="input-group">
        <span class="input-group-text bg-white border-end-0">
          <i class="fa-solid fa-magnifying-glass text-muted"></i>
        </span>
        <input type="text" id="searchInput" class="form-control border-start-0"
          placeholder="Cari judul atau lokasi...">
      </div>
    </div>
    <div class="col-6 col-md-3">
      <select id="categoryFilter" class="form-select">
        <option value="">Semua Kategori</option>
        <option value="banjir">Banjir</option>
        <option value="gempa">Gempa</option>
        <option value="erupsi">Erupsi</option>
        <option value="lainnya">Lainnya</option>
      </select>
    </div>
    <div class="col-6 col-md-3">
      <select id="sortFilter" class="form-select">
        <option value="newest">Terbaru</option>
        <option value="oldest">Terlama</option>
        <option value="progress">Capaian Tertinggi</option>
      </select>
    </div>
  </div>
</div>

{{-- Grid Kampanye Selesai --}}
@if($campaigns->count())
<div class="row g-3" id="campaignGrid">
  @foreach($campaigns as $campaign)
  @php
    $imgPath = $campaign->getRawOriginal('image');
    if (!$imgPath) {
        $imgUrl = null;
    } elseif (str_starts_with($imgPath, 'http')) {
        $imgUrl = $imgPath;
    } elseif (str_starts_with($imgPath, 'storage/')) {
        $imgUrl = asset($imgPath);
    } else {
        $imgUrl = asset('storage/' . $imgPath);
    }
  @endphp
  <div class="col-12 col-md-6 col-lg-4 col-xl-3 campaign-item"
    data-name="{{ strtolower($campaign->title . ' ' . $campaign->location) }}"
    data-category="{{ strtolower($campaign->category) }}"
    data-progress="{{ $campaign->progress_raw }}"
    data-date="{{ strtotime($campaign->getRawOriginal('date_published')) }}">
    <div class="campaign-card">

      {{-- Gambar --}}
      <div class="position-relative">
        @if($imgUrl)
          <img src="{{ $imgUrl }}" alt="{{ $campaign->title }}" class="campaign-img">
        @else
          <div class="campaign-img-placeholder">
            <i class="fa-solid fa-image"></i>
          </div>
        @endif
        <div class="position-absolute top-0 start-0 p-2">
          <span class="badge-selesai"><i class="fa-solid fa-circle-check me-1"></i>Selesai</span>
        </div>
        <div class="position-absolute top-0 end-0 p-2">
          <span class="badge-cat">{{ ucfirst($campaign->category) }}</span>
        </div>
      </div>

      <div class="campaign-body">
        {{-- Lokasi --}}
        <div class="campaign-location">
          <i class="fa-solid fa-location-dot text-danger me-1"></i>{{ $campaign->location }}
        </div>

        {{-- Judul --}}
        <div class="campaign-title">{{ $campaign->title }}</div>

        {{-- Progress --}}
        <div class="d-flex justify-content-between progress-label">
          <span>Terkumpul: <strong>{{ $campaign->collected }}</strong></span>
          <strong style="color:{{ $campaign->progress_color }}">{{ $campaign->progress }}</strong>
        </div>
        <div class="progress">
          <div class="progress-bar"
            style="width:{{ min($campaign->progress_raw, 100) }}%; background-color:{{ $campaign->progress_color }} !important;"
            role="progressbar">
          </div>
        </div>

        {{-- Meta --}}
        <div class="campaign-meta">
          <span><i class="fa-solid fa-bullseye me-1"></i>{{ $campaign->target }}</span>
          <span><i class="fa-regular fa-calendar me-1"></i>{{ $campaign->deadline }}</span>
        </div>

        {{-- Durasi --}}
        <div class="info-row">
          <span><i class="fa-solid fa-hourglass-end me-1"></i>Durasi Kampanye</span>
          <strong>{{ $campaign->duration }} hari</strong>
        </div>

        {{-- Tombol Detail (tanpa tombol Donasi) --}}
        <a href="{{ route ('transparansi.detail', $campaign->slug) }}" class="btn-detail">
          <i class="fa-solid fa-file-lines me-1"></i> Lihat Laporan
        </a>
      </div>
    </div>
  </div>
  @endforeach
</div>

{{-- Empty state saat filter tidak ada hasil --}}
<div id="emptyFilter" class="empty-box d-none mt-3">
  <i class="fa-regular fa-folder-open"></i>
  <h5>Tidak Ditemukan</h5>
  <p>Tidak ada kampanye yang cocok dengan pencarian atau filter Anda.</p>
</div>

@else
<div class="empty-box">
  <i class="fa-solid fa-clock-rotate-left"></i>
  <h5>Belum Ada Kampanye Selesai</h5>
  <p>Kampanye yang telah habis masa aktifnya akan muncul di sini.</p>
  <a href="{{ route('user.campaigns') }}" class="btn btn-primary rounded-pill px-4 mt-2">
    <i class="fa-solid fa-hand-holding-heart me-1"></i> Lihat Kampanye Aktif
  </a>
</div>
@endif

@endsection

@push('scripts')
<script>
  const items     = document.querySelectorAll('.campaign-item');
  const emptyBox  = document.getElementById('emptyFilter');
  const searchEl  = document.getElementById('searchInput');
  const catEl     = document.getElementById('categoryFilter');
  const sortEl    = document.getElementById('sortFilter');
  const grid      = document.getElementById('campaignGrid');

  function applyFilter() {
    const keyword = searchEl.value.toLowerCase();
    const cat     = catEl.value.toLowerCase();
    let visible   = [];

    items.forEach(item => {
      const matchName = item.dataset.name.includes(keyword);
      const matchCat  = !cat || item.dataset.category === cat;
      const show      = matchName && matchCat;
      item.style.display = show ? '' : 'none';
      if (show) visible.push(item);
    });

    // Sort
    const sort = sortEl.value;
    visible.sort((a, b) => {
      if (sort === 'oldest')   return a.dataset.date - b.dataset.date;
      if (sort === 'progress') return b.dataset.progress - a.dataset.progress;
      return b.dataset.date - a.dataset.date; // newest default
    });
    visible.forEach(el => grid.appendChild(el));

    emptyBox?.classList.toggle('d-none', visible.length > 0);
  }

  searchEl?.addEventListener('input', applyFilter);
  catEl?.addEventListener('change', applyFilter);
  sortEl?.addEventListener('change', applyFilter);
</script>
@endpush