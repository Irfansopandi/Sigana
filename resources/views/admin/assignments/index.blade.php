@extends('admin.layouts.app')

@section('title', 'Penugasan Relawan')
@section('page_title', 'Penugasan Relawan')

@push('styles')
<style>
  .filter-bar {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.25rem;
    display: flex;
    gap: .75rem;
    align-items: center;
    flex-wrap: wrap;
  }
  .filter-bar .form-control,
  .filter-bar .form-select {
    border-radius: 8px;
    border: 1.5px solid #e2e8f0;
    font-size: .85rem;
    color: #374151;
  }
  .filter-bar .form-control:focus,
  .filter-bar .form-select:focus {
    border-color: #93c5fd;
    box-shadow: 0 0 0 3px rgba(59,130,246,.1);
  }
  .btn-reset {
    width: 36px; height: 36px;
    border-radius: 8px;
    border: 1.5px solid #e2e8f0;
    background: #fff;
    color: #64748b;
    display: flex; align-items: center; justify-content: center;
    transition: all .2s;
  }
  .btn-reset:hover { background: #f8fafc; border-color: #cbd5e1; color: #334155; }

  .table-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    overflow: hidden;
  }
  .table-card table { margin: 0; }
  .table-card thead th {
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: #64748b;
    padding: .85rem 1.25rem;
  }
  .table-card tbody td {
    padding: .9rem 1.25rem;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    font-size: .875rem;
  }
  .table-card tbody tr {
    transition: background .15s;
  }
  .table-card tbody tr:hover td {
    background: #f0f7ff !important;
  }
  .table-card tbody td {
    padding: .9rem 1.25rem;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9 !important;
    font-size: .875rem;
  }
  .table-card tbody tr:last-child td {
    border-bottom: none !important;
  }

  .campaign-thumb {
    width: 42px; height: 42px;
    border-radius: 8px;
    object-fit: cover;
    flex-shrink: 0;
  }
  .campaign-thumb-placeholder {
    width: 42px; height: 42px;
    border-radius: 8px;
    background: #f1f5f9;
    display: flex; align-items: center; justify-content: center;
    color: #94a3b8; font-size: 1rem;
    flex-shrink: 0;
  }

  .stat-pill {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 10px; border-radius: 999px;
    font-size: .72rem; font-weight: 600;
  }
  .stat-pill.total    { background:#f1f5f9; color:#475569; }
  .stat-pill.menunggu { background:#fffbeb; color:#d97706; }
  .stat-pill.diterima { background:#ecfdf5; color:#059669; }

  .btn-detail {
    background: #eff6ff; color: #2563eb;
    border: 1.5px solid #bfdbfe;
    border-radius: 8px;
    padding: 5px 14px;
    font-size: .8rem; font-weight: 500;
    text-decoration: none;
    display: inline-flex; align-items: center; gap: 5px;
    transition: all .2s;
    white-space: nowrap;
  }
  .btn-detail:hover { background: #dbeafe; color: #1d4ed8; border-color: #93c5fd; }

  .row-number { color: #94a3b8; font-size: .78rem; font-weight: 600; }
  .table-card tbody tr {
    transition: background .15s;
    border-bottom: 1px solid #f1f5f9;
  }
  .table-card tbody tr:hover {
    background: #f0f7ff;
  }
  .table-card tbody td {
    border-bottom: 1px solid #f1f5f9;
  }
  .table-card tbody tr:last-child td {
    border-bottom: none;
  }

  .stat-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    padding: 1.1rem 1.25rem;
    transition: box-shadow .2s, transform .2s;
    cursor: default;
  }
  .stat-card:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    transform: translateY(-2px);
  }
</style>
@endpush

@section('content')
<div class="mb-4">
  <h5 class="fw-bold mb-1"><i class="fa-solid fa-list-check text-success me-2"></i>Penugasan Relawan</h5>
  <p class="text-muted small mb-0">Kelola bagian tugas dan verifikasi pendaftaran relawan per kampanye bencana.</p>
</div>

  {{-- Stats Cards --}}
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="stat-card" style="border-left:4px solid #6366f1;">
        <div class="d-flex align-items-center gap-3">
          <div style="width:38px;height:38px;border-radius:10px;background:#ede9fe;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fa-solid fa-triangle-exclamation" style="color:#6366f1;font-size:.9rem;"></i>
          </div>
          <div>
            <div class="text-muted" style="font-size:.75rem;">Total Kampanye</div>
            <div class="fw-bold" style="font-size:1.2rem;">{{ $campaigns->total() }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card" style="border-left:4px solid #dc2626;">
        <div class="d-flex align-items-center gap-3">
          <div style="width:38px;height:38px;border-radius:10px;background:#fee2e2;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fa-solid fa-circle-exclamation" style="color:#dc2626;font-size:.9rem;"></i>
          </div>
          <div>
            <div class="text-muted" style="font-size:.75rem;">Total Menunggu</div>
            <div class="fw-bold" style="font-size:1.2rem;">{{ $totalMenunggu }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card" style="border-left:4px solid #d97706;">
        <div class="d-flex align-items-center gap-3">
          <div style="width:38px;height:38px;border-radius:10px;background:#fef3c7;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fa-solid fa-triangle-exclamation" style="color:#d97706;font-size:.9rem;"></i>
          </div>
          <div>
            <div class="text-muted" style="font-size:.75rem;">Total Diterima</div>
            <div class="fw-bold" style="font-size:1.2rem;">{{ $totalDiterima }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card" style="border-left:4px solid #059669;">
        <div class="d-flex align-items-center gap-3">
          <div style="width:38px;height:38px;border-radius:10px;background:#d1fae5;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fa-solid fa-circle-check" style="color:#059669;font-size:.9rem;"></i>
          </div>
          <div>
            <div class="text-muted" style="font-size:.75rem;">Total Ditolak</div>
            <div class="fw-bold" style="font-size:1.2rem;">{{ $totalDitolak }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
@if(session('success'))
<div class="alert alert-success rounded-3 mb-4">{{ session('success') }}</div>
@endif

{{-- Filter bar --}}
<div class="filter-bar">
  <form method="GET" action="{{ route('admin.assignments.index') }}" class="d-flex gap-2 align-items-center flex-wrap w-100">
    <div class="position-relative flex-grow-1" style="min-width:200px; max-width:340px;">
      <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="left:10px;top:50%;transform:translateY(-50%);font-size:.8rem;"></i>
      <input type="text" name="search" class="form-control ps-4" style="height:36px;"
             placeholder="Cari nama kampanye..." value="{{ request('search') }}">
    </div>

    <select name="per_page" class="form-select" style="width:130px; height:36px;">
      @foreach([10, 25, 50] as $size)
        <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
          {{ $size }} halaman
        </option>
      @endforeach
    </select>

    <button type="submit" class="btn btn-sm btn-primary rounded-3 px-3" style="height:36px; font-size:.85rem;">
      Cari
    </button>
    <a href="{{ route('admin.assignments.index') }}" class="btn-reset" title="Reset">
      <i class="fa-solid fa-rotate-left" style="font-size:.8rem;"></i>
    </a>
  </form>
</div>

{{-- Tabel --}}
<div class="table-card">
  <table class="table">
    <thead>
      <tr>
        <th style="width:40px;">#</th>
        <th>KAMPANYE</th>
        <th>LOKASI</th>
        <th>PENDAFTAR</th>
        <th style="width:120px;">AKSI</th>
      </tr>
    </thead>
    <tbody>
      @forelse($campaigns as $campaign)
      @php
        $imgPath = $campaign->getRawOriginal('image');
        $imgUrl  = $imgPath ? (str_starts_with($imgPath, 'storage/') ? asset($imgPath) : asset('storage/' . $imgPath)) : null;
      @endphp
      <tr>
        <td class="row-number">{{ $campaigns->firstItem() + $loop->index }}</td>
        <td>
          <div class="d-flex align-items-center gap-3">
            @if($imgUrl)
              <img src="{{ $imgUrl }}" class="campaign-thumb" alt="{{ $campaign->title }}">
            @else
              <div class="campaign-thumb-placeholder"><i class="fa-solid fa-image"></i></div>
            @endif
            <span class="fw-semibold text-dark">{{ $campaign->title }}</span>
          </div>
        </td>
        <td>
          <span class="text-muted"><i class="fa-solid fa-location-dot me-1 text-danger" style="font-size:.8rem;"></i>{{ $campaign->location }}</span>
        </td>
        <td>
          <div class="d-flex gap-1 flex-wrap">
            <span class="stat-pill total"><i class="fa-solid fa-users" style="font-size:.65rem;"></i>{{ $campaign->volunteers_count }}</span>
            <span class="stat-pill menunggu"><i class="fa-solid fa-clock" style="font-size:.65rem;"></i>{{ $campaign->menunggu_count }}</span>
            <span class="stat-pill diterima"><i class="fa-solid fa-check" style="font-size:.65rem;"></i>{{ $campaign->diterima_count }}</span>
          </div>
        </td>
        <td>
          <a href="{{ route('admin.assignments.show', $campaign) }}" class="btn-detail">
            <i class="fa-solid fa-arrow-right"></i> Lihat Detail
          </a>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="5" class="text-center py-5 text-muted">
          <i class="fa-solid fa-folder-open fa-2x mb-2 d-block opacity-50"></i>
          Belum ada kampanye.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-3">{{ $campaigns->links() }}</div>
@endsection