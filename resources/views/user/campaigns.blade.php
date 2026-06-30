@extends('user.layouts.app')

@section('title', 'Kampanye Bencana')
@section('page_title', 'Kampanye Bencana')

@push('styles')
<style>
  .table thead th {
    font-size: .78rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: .04em;
    border-bottom: 1px solid #e2e8f0;
    padding: 12px 16px;
  }
  .table tbody td { padding: 12px 16px; border-color: #f1f5f9; vertical-align: middle; }
  .table-hover tbody tr:hover { background: #f8fafc; }

  .campaign-thumb {
    width: 48px; height: 48px;
    object-fit: cover; border-radius: 10px; flex-shrink: 0;
  }
  .campaign-thumb-placeholder {
    width: 48px; height: 48px; border-radius: 10px;
    background: #f1f5f9;
    display: flex; align-items: center; justify-content: center;
    color: #94a3b8; flex-shrink: 0; font-size: 1.1rem;
  }

  .btn-detail {
    border: 1px solid #e2e8f0;
    color: #2563eb;
    font-size: .8rem;
    font-weight: 600;
    background: #eff6ff;
    border-radius: 8px;
    padding: 5px 14px;
    transition: all .18s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
  }
  .btn-detail:hover {
    background: #2563eb;
    color: #fff;
    border-color: #2563eb;
  }

  .page-item-custom {
    width: 34px; height: 34px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: .82rem; font-weight: 600; cursor: pointer;
    border: 1px solid #e2e8f0; background: #fff; color: #475569;
    transition: all .15s; user-select: none;
}
.page-item-custom:hover    { border-color: #2563eb; color: #2563eb; background: #eff6ff; }
.page-item-custom.active   { background: #2563eb; color: #fff; border-color: #2563eb; }
.page-item-custom.disabled { opacity: .4; pointer-events: none; }
</style>
@endpush

@section('content')

{{-- Header --}}
<div class="mb-4">
  <h5 class="fw-bold mb-1">
    <i class="fa-solid fa-hand-holding-heart text-success me-2"></i>Kampanye Bencana
  </h5>
  <p class="text-muted small mb-0">Daftar kampanye bencana yang sedang membutuhkan bantuan donasi.</p>
</div>

{{-- Summary Cards --}}
@php
  $totalBencana   = $campaigns->count();
  $totalDarurat   = $campaigns->where('status', 'Darurat')->count();
  $totalWaspada   = $campaigns->where('status', 'Waspada')->count();
  $totalAktif     = $campaigns->where('status', 'Aktif')->count();
@endphp

<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="card card-hover border-0 shadow-sm h-100" style="border-left: 4px solid #6366f1 !important; border-radius:16px;">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 p-3" style="background:#eef2ff;">
          <i class="fa-solid fa-triangle-exclamation fa-lg" style="color:#6366f1;"></i>
        </div>
        <div>
          <div class="text-muted small">Total Bencana</div>
          <div class="fw-bold fs-5">{{ $totalBencana }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card card-hover border-0 shadow-sm h-100" style="border-left: 4px solid #dc2626 !important; border-radius:16px;">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 p-3" style="background:#fef2f2;">
          <i class="fa-solid fa-circle-exclamation fa-lg" style="color:#dc2626;"></i>
        </div>
        <div>
          <div class="text-muted small">Darurat</div>
          <div class="fw-bold fs-5">{{ $totalDarurat }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card card-hover border-0 shadow-sm h-100" style="border-left: 4px solid #d97706 !important; border-radius:16px;">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 p-3" style="background:#fffbeb;">
          <i class="fa-solid fa-triangle-exclamation fa-lg" style="color:#d97706;"></i>
        </div>
        <div>
          <div class="text-muted small">Waspada</div>
          <div class="fw-bold fs-5">{{ $totalWaspada }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card card-hover border-0 shadow-sm h-100" style="border-left: 4px solid #16a34a !important; border-radius:16px;">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 p-3" style="background:#f0fdf4;">
          <i class="fa-solid fa-circle-check fa-lg" style="color:#16a34a;"></i>
        </div>
        <div>
          <div class="text-muted small">Aktif</div>
          <div class="fw-bold fs-5">{{ $totalAktif }}</div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Filter Bar --}}
<div class="card border-0 shadow-sm mb-3">
  <div class="card-body py-3">
    <div class="row g-2 align-items-center">

      {{-- Search Nama --}}
      <div class="col-md-4">
        <div class="input-group input-group-sm">
          <span class="input-group-text bg-white border-end-0">
            <i class="fa-solid fa-magnifying-glass text-muted"></i>
          </span>
          <input type="text" id="filterNama" class="form-control border-start-0"
            placeholder="Cari nama kampanye...">
        </div>
      </div>

      {{-- Filter Status --}}
      <div class="col-md-2">
        <select id="filterStatus" class="form-select form-select-sm">
          <option value="">Semua Status</option>
          <option value="Darurat">Darurat</option>
          <option value="Waspada">Waspada</option>
          <option value="Aktif">Aktif</option>
        </select>
      </div>

      {{-- Filter Lokasi --}}
      <div class="col-md-3">
        <select id="filterLokasi" class="form-select form-select-sm">
          <option value="">Semua Lokasi</option>
          @foreach($campaigns->pluck('location')->unique()->sort() as $lokasi)
            <option value="{{ $lokasi }}">{{ $lokasi }}</option>
          @endforeach
        </select>
      </div>

      {{-- Per Halaman --}}
      <div class="col-md-2">
        <select id="filterPerPage" class="form-select form-select-sm">
          <option value="5">5 halaman</option>
          <option value="10" selected>10 halaman</option>
          <option value="25">25 halaman</option>
          <option value="999">Semua</option>
        </select>
      </div>

      {{-- Reset --}}
      <div class="col-md-1">
        <button onclick="resetFilter()" class="btn btn-sm btn-outline-secondary w-100" title="Reset Filter">
          <i class="fa-solid fa-rotate-left"></i>
        </button>
      </div>

    </div>
  </div>
</div>

{{-- Tabel --}}
<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table id="tabel-kampanye" class="table table-hover mb-0 align-middle">
        <thead class="table-light">
          <tr>
            <th class="ps-4" style="width:50px">#</th>
            <th>Kampanye</th>
            <th>Lokasi</th>
            <th style="width:120px">Status</th>
            <th style="width:160px">Target</th>
            <th style="width:120px" class="pe-4">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($campaigns as $i => $c)
          <tr data-nama="{{ strtolower($c->title) }}"
              data-status="{{ $c->status }}"
              data-lokasi="{{ $c->location }}">
            <td class="ps-4 text-muted small">{{ $i + 1 }}</td>
            <td>
              <div class="d-flex align-items-center gap-3">
                @if($c->image_url)
                  <img src="{{ $c->image_url }}" class="campaign-thumb" alt="{{ $c->title }}">
                @else
                  <div class="campaign-thumb-placeholder">
                    <i class="fa-solid fa-image"></i>
                  </div>
                @endif
                <span class="fw-semibold text-dark" style="font-size:.9rem;">{{ $c->title }}</span>
              </div>
            </td>
            <td class="text-muted small">
              <i class="fa-solid fa-location-dot me-1 text-danger"></i>{{ $c->location }}
            </td>
            <td>
              @if($c->status === 'Darurat')
                <span class="badge bg-danger rounded-pill px-3">Darurat</span>
              @elseif($c->status === 'Waspada')
                <span class="badge bg-warning text-dark rounded-pill px-3">Waspada</span>
              @else
                <span class="badge bg-success rounded-pill px-3">Aktif</span>
              @endif
            </td>
            <td class="small fw-medium">Rp {{ number_format($c->target_raw, 0, ',', '.') }}</td>
            <td class="pe-4">
              <a href="{{ route('bencana.detail', $c->slug) }}" class="btn-detail">
                <i class="fa-solid fa-arrow-right"></i> Lihat Detail
              </a>
            </td>
          </tr>
          @empty
          <tr id="empty-kampanye" style="display:none;">
            <td colspan="6" class="text-center text-muted py-5">
              <i class="fa-solid fa-inbox fa-2x mb-2 d-block opacity-30"></i>
              Belum ada kampanye tersedia.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
        <div class="d-flex align-items-center justify-content-center gap-1 mt-4 mb-2" id="paginasi"></div>    
    </div>
  </div>
</div>

@push('scripts')
<script>
  let perPage = 10;
  let currentPage = 1;

  function getRows() {
    return Array.from(document.querySelectorAll('#tabel-kampanye tbody tr[data-nama]'));
  }

  function applyFilter() {
    const nama   = document.getElementById('filterNama').value.toLowerCase();
    const status = document.getElementById('filterStatus').value;
    const lokasi = document.getElementById('filterLokasi').value;

    const rows = getRows();
    const filtered = rows.filter(row => {
      const matchNama   = row.dataset.nama.includes(nama);
      const matchStatus = !status || row.dataset.status === status;
      const matchLokasi = !lokasi || row.dataset.lokasi === lokasi;
      return matchNama && matchStatus && matchLokasi;
    });

    // Sembunyikan semua dulu
    rows.forEach(r => r.style.display = 'none');

    // Pagination
    currentPage = 1;
    renderPage(filtered);
  }

  function renderPage(filtered) {
    const rows = getRows();
    rows.forEach(r => r.style.display = 'none');

    const start = (currentPage - 1) * perPage;
    const end   = perPage === 999 ? filtered.length : start + perPage;
    filtered.slice(start, end).forEach(r => r.style.display = '');

    // Update nomor urut
    filtered.slice(start, end).forEach((r, i) => {
      r.querySelector('td:first-child').textContent = start + i + 1;
    });

    buildPagination(filtered);

    // Empty state
    const empty = document.getElementById('empty-kampanye');
    if (filtered.length === 0) {
      empty.style.display = '';
    } else {
      empty.style.display = 'none';
    }
  }

  function buildPagination(filtered) {
    const pag = document.getElementById('paginasi');
    pag.innerHTML = '';
    if (perPage === 999 || filtered.length <= perPage) return;

    const totalPages = Math.ceil(filtered.length / perPage);

    const prev = makeBtn('‹', currentPage === 1);
    prev.addEventListener('click', () => { if (currentPage > 1) { currentPage--; renderPage(filtered); } });
    pag.appendChild(prev);

    for (let p = 1; p <= totalPages; p++) {
      const btn = makeBtn(p, false, p === currentPage);
      btn.addEventListener('click', () => { currentPage = p; renderPage(filtered); });
      pag.appendChild(btn);
    }

    const next = makeBtn('›', currentPage === totalPages);
    next.addEventListener('click', () => { if (currentPage < totalPages) { currentPage++; renderPage(filtered); } });
    pag.appendChild(next);
  }

  function makeBtn(label, disabled = false, active = false) {
    const el = document.createElement('div');
    el.className = 'page-item-custom' + (disabled ? ' disabled' : '') + (active ? ' active' : '');
    el.textContent = label;
    return el;
  }

  function resetFilter() {
    document.getElementById('filterNama').value   = '';
    document.getElementById('filterStatus').value = '';
    document.getElementById('filterLokasi').value = '';
    document.getElementById('filterPerPage').value = '10';
    perPage = 10;
    applyFilter();
  }

  document.getElementById('filterNama').addEventListener('input', applyFilter);
  document.getElementById('filterStatus').addEventListener('change', applyFilter);
  document.getElementById('filterLokasi').addEventListener('change', applyFilter);
  document.getElementById('filterPerPage').addEventListener('change', function() {
    perPage = parseInt(this.value);
    applyFilter();
  });

  // Init
  document.addEventListener('DOMContentLoaded', () => applyFilter());
</script>
@endpush

@endsection