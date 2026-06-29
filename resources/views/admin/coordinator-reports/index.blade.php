@extends('admin.layouts.app')

@section('title', 'Laporan Koordinator')
@section('page_title', 'Laporan Koordinator')

@push('styles')
<style>
  .page-header {
      margin-bottom: 20px;
  }
  .page-header-title {
      font-size: 1.15rem;
      font-weight: 700;
      color: #0f172a;
      display: flex;
      align-items: center;
      gap: 10px;
  }
  .page-header-desc {
      font-size: .85rem;
      color: #64748b;
      margin-top: 4px;
      margin-left: 34px;
  }

  .stat-card {
      border-radius: 16px;
      padding: 18px 20px;
      display: flex;
      align-items: center;
      gap: 14px;
      border: none;
      border-left: 4px solid transparent;
      box-shadow: 0 1px 4px rgba(0,0,0,.06);
      transition: box-shadow .2s, transform .2s;
  }
  .stat-card:hover {
      box-shadow: 0 4px 14px rgba(0,0,0,.1);
      transform: translateY(-2px);
  }
  .stat-card.border-blue   { border-left-color: #3b82f6; }
  .stat-card.border-yellow { border-left-color: #f59e0b; }
  .stat-card.border-green  { border-left-color: #22c55e; }
  .stat-card.border-red    { border-left-color: #ef4444; }

  .stat-icon {
      width: 46px; height: 46px;
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.1rem;
      flex-shrink: 0;
  }
  .stat-label { font-size: .72rem; color: #64748b; font-weight: 500; }
  .stat-value { font-size: 1.5rem; font-weight: 700; color: #0f172a; line-height: 1; }

  .status-tabs {
      display: flex;
      gap: 8px;
      margin-bottom: 20px;
      flex-wrap: wrap;
  }
  .status-tab {
      padding: 8px 14px;
      border-radius: 10px;
      font-size: .85rem;
      font-weight: 600;
      text-decoration: none;
      border: 1px solid #e2e8f0;
      color: #475569;
      background: #fff;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: all .15s;
  }
  .status-tab:hover { border-color: #cbd5e1; color: #0f172a; }

  .status-tab .count {
      padding: 1px 9px;
      border-radius: 20px;
      font-size: .75rem;
      font-weight: 700;
      color: #fff;
  }
  .status-tab.all .count       { background: #3b82f6; }
  .status-tab.approved .count  { background: #22c55e; }
  .status-tab.pending .count   { background: #f59e0b; }
  .status-tab.rejected .count  { background: #ef4444; }

  .status-tab.active.all       { border-color: #3b82f6; background:#eff6ff; color:#1d4ed8; }
  .status-tab.active.approved  { border-color: #22c55e; background:#f0fdf4; color:#15803d; }
  .status-tab.active.pending   { border-color: #f59e0b; background:#fffbeb; color:#b45309; }
  .status-tab.active.rejected  { border-color: #ef4444; background:#fef2f2; color:#b91c1c; }

</style>
@endpush

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
  <div class="page-header-title">
    <i class="fa-solid fa-file-lines text-primary"></i>
    Laporan Koordinator
  </div>
  <div class="page-header-desc">Review dan verifikasi laporan koordinator untuk setiap kampanye.</div>
</div>

{{-- STATS --}}
<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="stat-card bg-white border-blue">
      <div class="stat-icon" style="background:#eff6ff">
        <i class="fa-solid fa-file-lines" style="color:#3b82f6"></i>
      </div>
      <div>
        <div class="stat-label">Total Laporan</div>
        <div class="stat-value">{{ $stats['total'] }}</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card bg-white border-yellow">
      <div class="stat-icon" style="background:#fef3c7">
        <i class="fa-solid fa-clock" style="color:#f59e0b"></i>
      </div>
      <div>
        <div class="stat-label">Menunggu</div>
        <div class="stat-value">{{ $stats['pending'] }}</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card bg-white border-green">
      <div class="stat-icon" style="background:#dcfce7">
        <i class="fa-solid fa-circle-check" style="color:#22c55e"></i>
      </div>
      <div>
        <div class="stat-label">Disetujui</div>
        <div class="stat-value">{{ $stats['approved'] }}</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card bg-white border-red">
      <div class="stat-icon" style="background:#fee2e2">
        <i class="fa-solid fa-circle-xmark" style="color:#ef4444"></i>
      </div>
      <div>
        <div class="stat-label">Ditolak</div>
        <div class="stat-value">{{ $stats['rejected'] }}</div>
      </div>
    </div>
  </div>
</div>

{{-- STATUS TABS --}}
<div class="status-tabs">
  <a href="{{ route('admin.coordinator-reports.index', array_filter(request()->except(['status','page']))) }}"
     class="status-tab all {{ !request('status') ? 'active' : '' }}">
    Semua <span class="count">{{ $stats['total'] }}</span>
  </a>
  <a href="{{ route('admin.coordinator-reports.index', array_filter(array_merge(request()->except('page'), ['status' => 'approved']))) }}"
     class="status-tab approved {{ request('status') == 'approved' ? 'active' : '' }}">
    Disetujui <span class="count">{{ $stats['approved'] }}</span>
  </a>
  <a href="{{ route('admin.coordinator-reports.index', array_filter(array_merge(request()->except('page'), ['status' => 'pending']))) }}"
     class="status-tab pending {{ request('status') == 'pending' ? 'active' : '' }}">
    Menunggu <span class="count">{{ $stats['pending'] }}</span>
  </a>
  <a href="{{ route('admin.coordinator-reports.index', array_filter(array_merge(request()->except('page'), ['status' => 'rejected']))) }}"
     class="status-tab rejected {{ request('status') == 'rejected' ? 'active' : '' }}">
    Ditolak <span class="count">{{ $stats['rejected'] }}</span>
  </a>
</div>

{{-- FILTER BAR --}}
<div class="filter-bar">
  <form method="GET" action="{{ route('admin.coordinator-reports.index') }}" class="row g-2 align-items-end">
    <div class="col-12 col-md-3">
      <label class="form-label small fw-semibold mb-1">Cari Laporan</label>
      <div class="input-group input-group-sm">
        <span class="input-group-text bg-white"><i class="fa-solid fa-search text-muted"></i></span>
        <input type="text" name="search" class="form-control" placeholder="Judul / nama koordinator..."
               value="{{ request('search') }}">
      </div>
    </div>
    <div class="col-6 col-md-2">
      <label class="form-label small fw-semibold mb-1">Status</label>
      <select name="status" class="form-select form-select-sm">
        <option value="">Semua Status</option>
        <option value="pending"  {{ request('status') == 'pending'  ? 'selected' : '' }}>Menunggu</option>
        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
      </select>
    </div>
    <div class="col-6 col-md-3">
      <label class="form-label small fw-semibold mb-1">Kampanye</label>
      <select name="campaign_id" class="form-select form-select-sm">
        <option value="">Semua Kampanye</option>
        @foreach($campaigns as $campaign)
          <option value="{{ $campaign->id }}" {{ request('campaign_id') == $campaign->id ? 'selected' : '' }}>
            {{ $campaign->title }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="col-6 col-md-2">
      <label class="form-label small fw-semibold mb-1">Tampilkan</label>
      <select name="per_page" class="form-select form-select-sm">
        @foreach([10, 25, 50, 100] as $size)
          <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
            {{ $size }} / halaman
          </option>
        @endforeach
      </select>
    </div>
    <div class="col-6 col-md-2 d-flex gap-2">
      <button type="submit" class="btn btn-primary btn-sm w-100">
        <i class="fa-solid fa-filter me-1"></i> Filter
      </button>
      <a href="{{ route('admin.coordinator-reports.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fa-solid fa-xmark"></i>
      </a>
    </div>
  </form>
</div>

{{-- TABLE --}}
<div class="card border-0 shadow-sm" style="border-radius:12px; overflow:hidden">
  <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
    <span class="fw-semibold" style="color:#0f172a">
      <i class="fa-solid fa-clipboard-list me-2 text-primary"></i>Daftar Laporan Koordinator
    </span>
    <span class="text-muted small">{{ $reports->total() }} laporan ditemukan</span>
  </div>

  <div class="table-responsive">
    <table class="table table-hover mb-0 align-middle">
      <thead style="background:#f8fafc; font-size:.78rem; color:#64748b; text-transform:uppercase; letter-spacing:.04em">
        <tr>
          <th class="px-4 py-3">#</th>
          <th class="py-3">Koordinator</th>
          <th class="py-3">Judul Laporan</th>
          <th class="py-3">Kampanye</th>
          <th class="py-3">Tgl Laporan</th>
          <th class="py-3">Dana Disalurkan</th>
          <th class="py-3">Status</th>
          <th class="py-3 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($reports as $report)
        <tr class="report-row">
          <td class="px-4 text-muted small">{{ $loop->iteration + ($reports->currentPage() - 1) * $reports->perPage() }}</td>
          <td>
            <div class="d-flex align-items-center gap-2">
              <div style="width:32px;height:32px;border-radius:50%;background:#e0f2fe;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700;color:#0369a1;flex-shrink:0">
                {{ strtoupper(substr($report->user->name ?? '-', 0, 1)) }}
              </div>
              <span class="small fw-semibold">{{ $report->user->name ?? '-' }}</span>
            </div>
          </td>
          <td>
            <div class="fw-semibold small" style="max-width:220px">{{ Str::limit($report->title, 50) }}</div>
            <div class="text-muted" style="font-size:.7rem">{{ $report->victim_helped }} korban terbantu</div>
          </td>
          <td>
            <span class="small text-muted">{{ Str::limit($report->campaign->title ?? '-', 35) }}</span>
          </td>
          <td>
            <span class="small">{{ $report->reported_at->format('d M Y') }}</span>
          </td>
          <td>
            <span class="small fw-semibold">Rp {{ number_format($report->total_distribution, 0, ',', '.') }}</span>
          </td>
          <td>
            @if($report->status === 'pending')
              <span class="badge-status badge-pending">Menunggu</span>
            @elseif($report->status === 'approved')
              <span class="badge-status badge-approved">Disetujui</span>
            @else
              <span class="badge-status badge-rejected">Ditolak</span>
            @endif
          </td>
          <td class="text-center">
            <a href="{{ route('admin.coordinator-reports.show', $report) }}"
               class="btn btn-sm btn-outline-primary" style="border-radius:8px; font-size:.78rem">
              <i class="fa-solid fa-eye me-1"></i> Detail
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="text-center py-5 text-muted">
            <i class="fa-solid fa-inbox fa-2x mb-2 d-block opacity-30"></i>
            Belum ada laporan koordinator
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($reports->hasPages())
  <div class="card-footer bg-white border-top px-4 py-3">
    {{ $reports->links('pagination::bootstrap-5') }}
  </div>
  @endif
</div>

@endsection