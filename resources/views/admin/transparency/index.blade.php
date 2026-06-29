@extends('admin.layouts.app')

@section('title', 'Laporan Transparansi')
@section('page_title', 'Laporan Transparansi')

@push('styles')
<style>
  .stat-card-transparency {
    border-radius: 16px;
    padding: 1.25rem;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-left: 5px solid;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: box-shadow .2s, transform .2s;
  }
  .stat-card-transparency:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    transform: translateY(-2px);
  }
  .report-card {
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    border-left: 5px solid;
    overflow: hidden;
    transition: box-shadow .2s, transform .2s;
  }
  .report-card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    transform: translateY(-2px);
  }
  .report-card-img {
    width: 100%;
    height: 100px;
    object-fit: cover;
  }
  .report-card-img-placeholder {
    width: 100%;
    height: 100px;
    background: linear-gradient(135deg, #e2e8f0, #f1f5f9);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 2rem;
  }
  .border-aktif      { border-left-color: #3b82f6; }
  .border-penyaluran { border-left-color: #f59e0b; }
  .border-selesai    { border-left-color: #10b981; }
  .border-done { border-left-color: #7c3aed; }
  .badge-done  { background:#f5f3ff; color:#7c3aed; }
  
  .badge-aktif      { background:#eff6ff; color:#2563eb; }
  .badge-penyaluran { background:#fffbeb; color:#d97706; }
  .badge-selesai    { background:#ecfdf5; color:#059669; }

  .stat-total      { border-left-color: #0284c7; }
  .stat-aktif      { border-left-color: #2563eb; }
  .stat-penyaluran { border-left-color: #d97706; }
  .stat-selesai    { border-left-color: #059669; }
  .stat-done       { border-left-color: #7c3aed; }
  .stat-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
  }

  .btn-pill {
    border-radius: 999px;
    font-size: 0.75rem;
    padding: 5px 14px;
    font-weight: 500;
    border: 1.5px solid;
    transition: all .2s;
    display: inline-flex;
    align-items: center;
  }
  .btn-pill-view {
    background: #eff6ff;
    color: #2563eb;
    border-color: #bfdbfe;
    text-decoration: none;
  }
  .btn-pill-view:hover {
    background: #dbeafe;
    color: #1d4ed8;
    border-color: #93c5fd;
    transform: translateY(-1px);
  }
  .btn-pill-edit {
    background: #fff;
    color: #475569;
    border-color: #e2e8f0;
    text-decoration: none;
  }
  .btn-pill-edit:hover {
    background: #f8fafc;
    color: #1e293b;
    border-color: #cbd5e1;
    transform: translateY(-1px);
  }
</style>
@endpush

@section('content')
<div class="mb-4">
  <h5 class="fw-bold mb-1"><i class="fa-solid fa-file-lines text-info me-2"></i>Laporan Transparansi</h5>
  <p class="text-muted small mb-0">Review dan verifikasi laporan transparansi untuk setiap kampanye.</p>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
  <div class="col-6 col-md">
    <div class="stat-card-transparency stat-total">
      <div class="stat-icon" style="background:#e0f2fe; color:#0284c7;">
        <i class="fa-solid fa-file-lines"></i>
      </div>
      <div>
        <div class="small text-muted">Total</div>
        <div class="fw-bold fs-4">{{ $totalAll }}</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md">
    <div class="stat-card-transparency stat-aktif">
      <div class="stat-icon" style="background:#dbeafe; color:#2563eb;">
        <i class="fa-solid fa-circle-dot"></i>
      </div>
      <div>
        <div class="small text-muted">Aktif</div>
        <div class="fw-bold fs-4">{{ $totalAktif }}</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md">
    <div class="stat-card-transparency stat-penyaluran">
      <div class="stat-icon" style="background:#fef3c7; color:#d97706;">
        <i class="fa-solid fa-truck"></i>
      </div>
      <div>
        <div class="small text-muted">Dalam Penyaluran</div>
        <div class="fw-bold fs-4">{{ $totalPenyaluran }}</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md">
    <div class="stat-card-transparency stat-selesai">
      <div class="stat-icon" style="background:#d1fae5; color:#059669;">
        <i class="fa-solid fa-circle-check"></i>
      </div>
      <div>
        <div class="small text-muted">Hampir Selesai</div>
        <div class="fw-bold fs-4">{{ $totalSelesai }}</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md">
    <div class="stat-card-transparency stat-done">
      <div class="stat-icon" style="background:#f5f3ff; color:#7c3aed;">
        <i class="fa-solid fa-flag-checkered"></i>
      </div>
      <div>
        <div class="small text-muted">Selesai</div>
        <div class="fw-bold fs-4">{{ $totalDoneSelesai }}</div>
      </div>
    </div>
  </div>
</div>

{{-- Filter Tab --}}
<div class="d-flex gap-2 mb-4 flex-wrap">
  @php
    $tabs = [
      ''                 => ['label' => 'Semua',           'color' => '#2563eb', 'bg' => '#eff6ff', 'border' => '#bfdbfe', 'count' => $totalAll],
      'Aktif'            => ['label' => 'Aktif',           'color' => '#059669', 'bg' => '#ecfdf5', 'border' => '#a7f3d0', 'count' => $totalAktif],
      'Dalam Penyaluran' => ['label' => 'Dalam Penyaluran','color' => '#d97706', 'bg' => '#fffbeb', 'border' => '#fde68a', 'count' => $totalPenyaluran],
      'Hampir Selesai'   => ['label' => 'Hampir Selesai',  'color' => '#0284c7', 'bg' => '#f0f9ff', 'border' => '#bae6fd', 'count' => $totalSelesai],
      'Selesai'          => ['label' => 'Selesai',         'color' => '#7c3aed', 'bg' => '#f5f3ff', 'border' => '#ddd6fe', 'count' => $totalDoneSelesai],
    ];
    $currentStatus = request('status', '');
  @endphp

  @foreach($tabs as $val => $tab)
    <a href="{{ route('admin.transparency.index', $val ? ['status' => $val] : []) }}"
       class="btn btn-sm"
       style="border-radius:8px; font-size:0.85rem; padding:6px 18px; transition:all .2s;
         {{ $currentStatus === $val
           ? "background:{$tab['bg']}; color:{$tab['color']}; border:1.5px solid {$tab['border']}; font-weight:600;"
           : 'background:#fff; color:#64748b; border:1.5px solid #e2e8f0;' }}">
      {{ $tab['label'] }}
      <span class="ms-1 badge rounded-pill"
        style="font-size:0.7rem;
          {{ $currentStatus === $val
            ? "background:{$tab['color']}; color:#fff;"
            : 'background:#f1f5f9; color:#64748b;' }}">
        {{ $tab['count'] }}
      </span>
    </a>
  @endforeach
</div>

{{-- Cards --}}
<div class="row g-3">
  @forelse($reports as $report)
  @php
    $status = $report->status;
    $borderClass = match($status) {
      'Dalam Penyaluran' => 'border-penyaluran',
      'Hampir Selesai'   => 'border-selesai',
      'Selesai'          => 'border-done',
      default            => 'border-aktif',
    };
    $badgeClass = match($status) {
      'Dalam Penyaluran' => 'badge-penyaluran',
      'Hampir Selesai'   => 'badge-selesai',
      'Selesai'          => 'badge-done',
      default            => 'badge-aktif',
    };
    $icon = match($status) {
      'Dalam Penyaluran' => 'fa-truck',
      'Hampir Selesai'   => 'fa-circle-check',
      'Selesai'          => 'fa-flag-checkered',
      default            => 'fa-circle-dot',
    };
    $campaign = $report->campaign;
    $imgPath = $campaign?->getRawOriginal('image');
    $imgUrl = $imgPath
      ? (str_starts_with($imgPath, 'storage/') ? asset($imgPath) : asset('storage/' . $imgPath))
      : null;
  @endphp
  <div class="col-lg-3 col-md-6">
    <div class="report-card bg-white {{ $borderClass }} h-100">
      @if($imgUrl)
        <img src="{{ $imgUrl }}" alt="{{ $campaign->title }}" class="report-card-img">
      @else
        <div class="report-card-img-placeholder">
          <i class="fa-solid fa-image"></i>
        </div>
      @endif

      <div class="p-3">
        <h6 class="fw-semibold mb-0" style="font-size:0.85rem; line-height:1.3;">
          {{ $campaign->title ?? 'Kampanye tidak tersedia' }}
        </h6>
        <div class="small text-muted mt-1 mb-2" style="font-size:0.75rem;">
          <i class="fa-solid fa-calendar me-1"></i>{{ $report->date }}
        </div>

        <span class="badge rounded-pill px-2 py-1 mb-2 {{ $badgeClass }}" style="font-size:0.7rem;">
          <i class="fa-solid {{ $icon }} me-1"></i>{{ $status }}
        </span>

        <p class="small text-muted mb-3" style="font-size:0.78rem;">{{ Str::limit($report->description, 80) }}</p>

        <div class="d-flex gap-3 mb-3">
          <div>
            <div class="small text-muted" style="font-size:0.72rem;">Digunakan</div>
            <div class="fw-semibold text-danger" style="font-size:0.82rem;">{{ $report->used }}</div>
          </div>
          <div>
            <div class="small text-muted" style="font-size:0.72rem;">Sisa</div>
            <div class="fw-semibold text-success" style="font-size:0.82rem;">{{ $report->remaining }}</div>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <a href="{{ route('admin.transparency.edit', $report) }}" class="btn-pill btn-pill-edit">
            <i class="fa-solid fa-pen-to-square me-1"></i>Edit
          </a>
          <a href="{{ route('admin.transparency.show', $report) }}" class="btn-pill btn-pill-view">
            <i class="fa-solid fa-eye me-1"></i>Detail
          </a>
        </div>
      </div>
    </div>
  </div>
  @empty
  <div class="col-12 text-center py-5 text-muted">
    <i class="fa-solid fa-folder-open fa-2x mb-2 d-block"></i>
    Belum ada laporan transparansi.
  </div>
  @endforelse
</div>

<div class="mt-4">{{ $reports->links() }}</div>
@endsection