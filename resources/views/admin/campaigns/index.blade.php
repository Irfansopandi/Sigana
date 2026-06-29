@extends('admin.layouts.app')

@section('title', 'Kampanye Bencana')
@section('page_title', 'Kampanye Bencana')

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
    height: 100px; 
    object-fit: cover;
  }
.campaign-img-placeholder {
  width: 100%;
  height: 100px;
  background: linear-gradient(135deg, #e2e8f0, #f1f5f9);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #94a3b8;
  font-size: 2rem;
}

/* Progress animasi */
.progress-bar {
  transition: width 1s ease-in-out;
  animation: progressAnim 1.2s ease-in-out;
}
@keyframes progressAnim {
  from { width: 0%; }
  to   { width: var(--prog-width); }
}
  .btn-action { border-radius: 8px; font-size: 0.82rem; padding: 5px 14px; transition: all .2s ease; }
  .btn-approve { background:#dcfce7; color:#166534; border:1.5px solid #bbf7d0; }
  .btn-approve:hover { background:#bbf7d0; color:#14532d; border-color:#86efac; transform:translateY(-1px); }
  .btn-reject  { background:#fee2e2; color:#991b1b; border:1.5px solid #fecaca; }
  .btn-reject:hover  { background:#fecaca; color:#7f1d1d; border-color:#fca5a5; transform:translateY(-1px); }
  .btn-edit    { background:#eff6ff; color:#2563eb; border:1.5px solid #bfdbfe; }
  .btn-edit:hover    { background:#dbeafe; color:#1d4ed8; border-color:#93c5fd; transform:translateY(-1px); }
  .btn-detail  { background:#fff; color:#64748b; border:1.5px solid #e2e8f0; }
  .btn-detail:hover  { background:#f8fafc; color:#334155; border-color:#cbd5e1; transform:translateY(-1px); box-shadow:0 4px 12px rgba(37,99,235,0.10); }
  .btn-tambah  { background: #166534; color:#fff; border:none; border-radius:8px; transition: all .2s; }
  .btn-tambah:hover  { background:#14532d; transform:translateY(-1px); box-shadow:0 4px 12px rgba(5,150,105,0.2); color:#fff; }
</style>
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-hand-holding-heart text-success me-2"></i>Kampanye Bencana</h5>
    <p class="text-muted small mb-0">Kelola kampanye bencana dan tinjau progres setiap program.</p>
  </div>
  <a href="{{ route('admin.campaigns.create') }}" class="btn btn-sm btn-tambah px-4 py-2">
    <i class="fa-solid fa-plus me-2"></i>Tambah Kampanye
  </a>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100 stat-card-item" style="border-radius:16px; border-left:4px solid #2563eb !important;">
      <div class="card-body d-flex align-items-center gap-3 p-3">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(37,99,235,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="fa-solid fa-hand-holding-heart" style="color:#2563eb;font-size:1.2rem;"></i>
        </div>
        <div>
          <div class="small" style="color:#64748b;">Total</div>
          <div class="fw-bold" style="font-size:1.4rem;color:#0f172a;">{{ $stats['total'] }}</div>
        </div>
      </div>  
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100 stat-card-item" style="border-radius:16px; border-left:4px solid #059669 !important;">
      <div class="card-body d-flex align-items-center gap-3 p-4">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(5,150,105,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="fa-solid fa-circle-check" style="color:#059669;font-size:1.2rem;"></i>
        </div>
        <div>
          <div class="small" style="color:#64748b;">Disetujui</div>
          <div class="fw-bold" style="font-size:1.4rem;color:#0f172a;">{{ $stats['disetujui'] }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100 stat-card-item" style="border-radius:16px; border-left:4px solid #f59e0b !important;">
      <div class="card-body d-flex align-items-center gap-3 p-4">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(245,158,11,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="fa-solid fa-clock" style="color:#f59e0b;font-size:1.2rem;"></i>
        </div>
        <div>
          <div class="small" style="color:#64748b;">Menunggu</div>
          <div class="fw-bold" style="font-size:1.4rem;color:#0f172a;">{{ $stats['menunggu'] }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100 stat-card-item" style="border-radius:16px; border-left:4px solid #dc2626 !important;">
      <div class="card-body d-flex align-items-center gap-3 p-4">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(220,38,38,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="fa-solid fa-circle-xmark" style="color:#dc2626;font-size:1.2rem;"></i>
        </div>
        <div>
          <div class="small" style="color:#64748b;">Ditolak</div>
          <div class="fw-bold" style="font-size:1.4rem;color:#0f172a;">{{ $stats['ditolak'] }}</div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Tab Filter --}}
<div class="d-flex gap-2 mb-4 flex-wrap">
  @php
    $tabs = [
      'all'       => ['label' => 'Semua',    'color' => '#2563eb', 'bg' => '#eff6ff', 'border' => '#bfdbfe'],
      'disetujui' => ['label' => 'Disetujui','color' => '#166534', 'bg' => '#dcfce7', 'border' => '#bbf7d0'],
      'menunggu'  => ['label' => 'Menunggu', 'color' => '#854d0e', 'bg' => '#fef9c3', 'border' => '#fde68a'],
      'ditolak'   => ['label' => 'Ditolak',  'color' => '#991b1b', 'bg' => '#fee2e2', 'border' => '#fecaca'],
    ];
  @endphp

  @foreach($tabs as $val => $tab)
    <a href="{{ route('admin.campaigns.index', ['status' => $val]) }}"
      class="btn btn-sm"
      style="border-radius:8px; font-size:0.85rem; padding:6px 18px; transition:all .2s;
        {{ $status === $val
          ? "background:{$tab['bg']}; color:{$tab['color']}; border:1.5px solid {$tab['border']}; font-weight:600;"
          : 'background:#fff; color:#64748b; border:1.5px solid #e2e8f0;' }}">
      {{ $tab['label'] }}
      <span class="ms-1 badge rounded-pill"
        style="font-size:0.7rem;
          {{ $status === $val
            ? "background:{$tab['color']}; color:#fff;"
            : 'background:#f1f5f9; color:#64748b;' }}">
        {{ $val === 'all' ? $stats['total'] : $stats[$val] }}
      </span>
    </a>
  @endforeach
</div>

{{-- Campaign Cards --}}
<div class="row g-3">
  @forelse($campaigns as $campaign)
  <div class="col-lg-3 col-md-6">
    <div class="card campaign-card shadow-sm h-100">

      {{-- Foto --}}
      @php
        $imgPath = $campaign->getRawOriginal('image');
        $imgUrl = str_starts_with($imgPath, 'storage/')
          ? asset($imgPath)
          : asset('storage/' . $imgPath);
      @endphp

      @if($imgPath)
        <img src="{{ $imgUrl }}" alt="{{ $campaign->title }}" class="campaign-img">
      @else
        <div class="campaign-img-placeholder">
          <i class="fa-solid fa-image"></i>
        </div>
      @endif

      <div class="card-body p-3">
        {{-- Judul & Lokasi --}}
        <h6 class="fw-bold mb-1" style="font-size:0.85rem; line-height:1.3;">{{ $campaign->title }}</h6>
        <div class="small text-muted mb-2"><i class="fa-solid fa-location-dot me-1"></i>{{ $campaign->location }}</div>

        {{-- Badge Status --}}
        <div class="d-flex gap-1 flex-wrap mb-3">
          @if($campaign->report_status)
            <span class="badge rounded-pill px-2 py-1"
              style="font-size:0.7rem;
                {{ $campaign->report_status === 'disetujui' ? 'background:#dcfce7;color:#166534;' : ($campaign->report_status === 'ditolak' ? 'background:#fee2e2;color:#991b1b;' : 'background:#fef9c3;color:#854d0e;') }}">
              {{ ucfirst($campaign->report_status) }}
            </span>
          @endif
          <span class="badge rounded-pill px-2 py-1" style="font-size:0.7rem; {{ $campaign->status_class_inline ?? 'background:#f1f5f9;color:#475569;' }}">
            {{ $campaign->status }}
          </span>
        </div>

        {{-- Progress --}}
        <div class="small text-muted mb-1" style="font-size:0.75rem;">
          Terkumpul <span class="fw-semibold text-dark">{{ $campaign->collected }}</span> dari <span class="fw-semibold text-dark">{{ $campaign->target }}</span>
        </div>
        <div class="progress mb-1" style="height:5px;border-radius:99px;">
          <div class="progress-bar" role="progressbar"
            style="width:{{ $campaign->progress_raw }}%; background:{{ $campaign->progress_color }}; border-radius:99px;">
          </div>
        </div>
        <div class="small text-muted mb-3" style="font-size:0.75rem;">{{ $campaign->progress }}</div>

        {{-- Actions --}}
        <div class="d-flex gap-1 flex-wrap">
          @if($campaign->report_status === 'menunggu')
            <form action="{{ route('admin.campaigns.approve', $campaign) }}" method="POST">
              @csrf
              <button type="submit" class="btn btn-sm btn-action btn-approve" style="font-size:0.75rem; padding:4px 10px;">
                <i class="fa-solid fa-check me-1"></i>Setujui
              </button>
            </form>
            <form action="{{ route('admin.campaigns.reject', $campaign) }}" method="POST">
              @csrf
              <button type="submit" class="btn btn-sm btn-action btn-reject" style="font-size:0.75rem; padding:4px 10px;">
                <i class="fa-solid fa-xmark me-1"></i>Tolak
              </button>
            </form>
          @endif
          <a href="{{ route('admin.campaigns.edit', $campaign) }}" class="btn btn-sm btn-action btn-edit" style="font-size:0.75rem; padding:4px 10px;">
            <i class="fa-solid fa-pen me-1"></i>Edit
          </a>
          <a href="{{ route('admin.campaigns.show', $campaign) }}" class="btn btn-sm btn-action btn-detail" style="font-size:0.75rem; padding:4px 10px;">
            <i class="fa-solid fa-eye me-1"></i>Detail
          </a>
        </div>
      </div>
    </div>
  </div>
  @empty
  <div class="col-12">
    <div class="text-center text-muted py-5">
      <i class="fa-solid fa-hand-holding-heart fa-2x mb-3 d-block opacity-30"></i>
      Belum ada kampanye saat ini.
    </div>
  </div>
  @endforelse
</div>

<div class="mt-4">{{ $campaigns->links() }}</div>

@endsection