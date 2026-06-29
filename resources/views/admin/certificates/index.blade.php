@extends('admin.layouts.app')

@section('title', 'Sertifikat Relawan')
@section('page_title', 'Sertifikat Relawan')

@push('styles')
<style>
  .stat-card {
    border-radius: 16px; padding: 1.1rem 1.25rem;
    background: #fff; border: 1px solid #e5e7eb; border-left: 5px solid;
    display: flex; align-items: center; gap: 1rem;
    transition: box-shadow .2s, transform .2s;
  }
  .stat-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.08); transform: translateY(-2px); }
  .stat-icon { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }

  .table-card { background:#fff; border:1px solid #e5e7eb; border-radius:14px; overflow:hidden; }
  .table-card table { margin:0; }
  .table-card thead th { background:#f8fafc; border-bottom:1px solid #e5e7eb; font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; color:#64748b; padding:.85rem 1.25rem; }
  .table-card tbody td { padding:.9rem 1.25rem; vertical-align:middle; border-bottom:1px solid #f1f5f9 !important; font-size:.875rem; }
  .table-card tbody tr:last-child td { border-bottom:none !important; }
  .table-card tbody tr { transition:background .15s; }
  .table-card tbody tr:hover td { background:#f0f7ff !important; }

  .campaign-thumb { width:42px; height:42px; border-radius:8px; object-fit:cover; }
  .campaign-thumb-placeholder { width:42px; height:42px; border-radius:8px; background:#f1f5f9; display:flex; align-items:center; justify-content:center; color:#94a3b8; }

  .btn-detail { background:#eff6ff; color:#2563eb; border:1.5px solid #bfdbfe; border-radius:8px; padding:5px 14px; font-size:.8rem; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:5px; transition:all .2s; }
  .btn-detail:hover { background:#dbeafe; color:#1d4ed8; border-color:#93c5fd; }

  .filter-bar { background:#fff; border:1px solid #e5e7eb; border-radius:14px; padding:1rem 1.25rem; margin-bottom:1.25rem; }
  .btn-reset { width:36px; height:36px; border-radius:8px; border:1.5px solid #e2e8f0; background:#fff; color:#64748b; display:flex; align-items:center; justify-content:center; transition:all .2s; }
  .btn-reset:hover { background:#f8fafc; border-color:#cbd5e1; }
</style>
@endpush

@section('content')
<div class="mb-4">
  <h5 class="fw-bold mb-1"><i class="fa-solid fa-certificate text-warning me-2"></i>Sertifikat Relawan</h5>
  <p class="text-muted small mb-0">Kampanye yang telah mencapai 100% target donasi — siap diberikan sertifikat.</p>
</div>

@if(session('success'))
<div class="alert alert-success rounded-3 mb-4">{{ session('success') }}</div>
@endif

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="stat-card" style="border-left-color:#6366f1;">
      <div class="stat-icon" style="background:#ede9fe; color:#6366f1;"><i class="fa-solid fa-flag-checkered"></i></div>
      <div>
        <div class="small text-muted">Kampanye Selesai</div>
        <div class="fw-bold fs-4">{{ $totalKampanye }}</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card" style="border-left-color:#059669;">
      <div class="stat-icon" style="background:#d1fae5; color:#059669;"><i class="fa-solid fa-certificate"></i></div>
      <div>
        <div class="small text-muted">Sertifikat Diberikan</div>
        <div class="fw-bold fs-4">{{ $totalSertifikat }}</div>
      </div>
    </div>
  </div>
</div>

{{-- Filter --}}
<div class="filter-bar">
  <form method="GET" class="d-flex gap-2 align-items-center flex-wrap w-100">
    <div class="position-relative flex-grow-1" style="max-width:340px;">
      <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="left:10px;top:50%;transform:translateY(-50%);font-size:.8rem;"></i>
      <input type="text" name="search" class="form-control ps-4"
             style="height:36px;border-radius:8px;border:1.5px solid #e2e8f0;font-size:.85rem;"
             placeholder="Cari nama kampanye..." value="{{ request('search') }}">
    </div>

    <select name="per_page" class="form-select" style="width:130px; height:36px; border-radius:8px; border:1.5px solid #e2e8f0; font-size:.85rem;">
      @foreach([10, 25, 50] as $size)
        <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
          {{ $size }} halaman
        </option>
      @endforeach
    </select>

    <button type="submit" class="btn btn-sm btn-primary rounded-3 px-3" style="height:36px;font-size:.85rem;">Cari</button>
    <a href="{{ route('admin.certificates.index') }}" class="btn-reset" style="text-decoration:none;">
      <i class="fa-solid fa-rotate-left" style="font-size:.8rem;"></i>
    </a>
  </form>
</div>

{{-- Tabel Kampanye --}}
<div class="table-card">
  <table class="table">
    <thead>
      <tr>
        <th style="width:40px;">#</th>
        <th>KAMPANYE</th>
        <th>LOKASI</th>
        <th>RELAWAN DITERIMA</th>
        <th>AKSI</th>
      </tr>
    </thead>
    <tbody>
      @forelse($campaigns as $i => $campaign)
      @php
        $imgPath = $campaign->getRawOriginal('image');
        $imgUrl  = $imgPath ? (str_starts_with($imgPath, 'storage/') ? asset($imgPath) : asset('storage/' . $imgPath)) : null;
      @endphp
      <tr>
        <td class="text-muted" style="font-size:.78rem; font-weight:600;">{{ $i + 1 }}</td>
        <td>
          <div class="d-flex align-items-center gap-3">
            @if($imgUrl)
              <img src="{{ $imgUrl }}" class="campaign-thumb" alt="{{ $campaign->title }}">
            @else
              <div class="campaign-thumb-placeholder"><i class="fa-solid fa-image"></i></div>
            @endif
            <div>
              <div class="fw-semibold text-dark">{{ $campaign->title }}</div>
              <span class="badge" style="font-size:.65rem; background:#dcfce7; color:#16a34a; border-radius:999px;">
                <i class="fa-solid fa-circle-check me-1"></i>100% Tercapai
              </span>
            </div>
          </div>
        </td>
        <td>
          <span class="text-muted">
            <i class="fa-solid fa-location-dot me-1 text-danger" style="font-size:.8rem;"></i>{{ $campaign->location }}
          </span>
        </td>
        <td>
          <span class="badge rounded-pill px-3 py-1" style="background:#eff6ff; color:#2563eb; font-size:.78rem;">
            <i class="fa-solid fa-users me-1"></i>{{ $campaign->relawan_diterima }} relawan
          </span>
        </td>
        <td>
          <a href="{{ route('admin.certificates.show', $campaign) }}" class="btn-detail">
            <i class="fa-solid fa-arrow-right"></i> Kelola Sertifikat
          </a>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="5" class="text-center py-5 text-muted">
          <i class="fa-solid fa-flag-checkered fa-2x mb-2 d-block opacity-30"></i>
          Belum ada kampanye yang mencapai 100%.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection