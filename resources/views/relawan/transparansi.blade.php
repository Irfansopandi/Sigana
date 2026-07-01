@extends('relawan.layouts.app')

@section('title', 'Laporan Transparansi')
@section('page_title', 'Laporan Transparansi')

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

  .progress-mini {
    height: 6px;
    border-radius: 3px;
    background: #e2e8f0;
    width: 90px;
  }
  .progress-mini .bar {
    height: 100%;
    border-radius: 3px;
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
    <i class="fa-solid fa-chart-line text-primary me-2"></i>Laporan Transparansi
  </h5>
  <p class="text-muted small mb-0">Pantau laporan keuangan dan penyaluran bantuan tiap kampanye bencana.</p>
</div>

{{-- Summary Cards --}}
@php
  $totalLaporan     = $campaigns->count();
  $totalAktif       = $campaigns->filter(fn($c) => $c->transparencyReport->status === 'Aktif')->count();
  $totalPenyaluran  = $campaigns->filter(fn($c) => $c->transparencyReport->status === 'Dalam Penyaluran')->count();
  $totalHampir      = $campaigns->filter(fn($c) => $c->transparencyReport->status === 'Hampir Selesai')->count();
  $totalSelesai     = $campaigns->filter(fn($c) => $c->transparencyReport->status === 'Selesai')->count();
@endphp

<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="card card-hover border-0 shadow-sm h-100" style="border-left: 4px solid #6366f1 !important; border-radius:16px;">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 p-3" style="background:#eef2ff;">
          <i class="fa-solid fa-file-lines fa-lg" style="color:#6366f1;"></i>
        </div>
        <div>
          <div class="text-muted small">Total Laporan</div>
          <div class="fw-bold fs-5">{{ $totalLaporan }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card card-hover border-0 shadow-sm h-100" style="border-left: 4px solid #2563eb !important; border-radius:16px;">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 p-3" style="background:#eff6ff;">
          <i class="fa-solid fa-circle-dot fa-lg" style="color:#2563eb;"></i>
        </div>
        <div>
          <div class="text-muted small">Aktif</div>
          <div class="fw-bold fs-5">{{ $totalAktif }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card card-hover border-0 shadow-sm h-100" style="border-left: 4px solid #d97706 !important; border-radius:16px;">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 p-3" style="background:#fffbeb;">
          <i class="fa-solid fa-truck fa-lg" style="color:#d97706;"></i>
        </div>
        <div>
          <div class="text-muted small">Dalam Penyaluran</div>
          <div class="fw-bold fs-5">{{ $totalPenyaluran }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card card-hover border-0 shadow-sm h-100" style="border-left: 4px solid #16a34a !important; border-radius:16px;">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 p-3" style="background:#f0fdf4;">
          <i class="fa-solid fa-flag-checkered fa-lg" style="color:#16a34a;"></i>
        </div>
        <div>
          <div class="text-muted small">Hampir Selesai / Selesai</div>
          <div class="fw-bold fs-5">{{ $totalHampir + $totalSelesai }}</div>
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
          <option value="Aktif">Aktif</option>
          <option value="Dalam Penyaluran">Dalam Penyaluran</option>
          <option value="Hampir Selesai">Hampir Selesai</option>
          <option value="Selesai">Selesai</option>
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
      <table id="tabel-transparansi" class="table table-hover mb-0 align-middle">
        <thead class="table-light">
          <tr>
            <th class="ps-4" style="width:50px">#</th>
            <th>Kampanye</th>
            <th>Lokasi</th>
            <th style="width:130px">Status</th>
            <th style="width:130px">Dana Terkumpul</th>
            <th style="width:130px">Dana Digunakan</th>
            <th style="width:120px">Progress</th>
            <th style="width:150px" class="pe-4">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($campaigns as $i => $c)
          @php $report = $c->transparencyReport; @endphp
          <tr data-nama="{{ strtolower($c->title) }}"
              data-status="{{ $report->status }}"
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
              <span class="badge {{ $report->status_class }} rounded-pill px-3">
                <i class="{{ $report->status_icon }} me-1"></i>{{ $report->status }}
              </span>
            </td>
            <td class="small fw-medium text-primary">{{ $c->collected }}</td>
            <td class="small fw-medium text-danger">{{ $report->used }}</td>
            <td>
              <div class="d-flex align-items-center gap-2">
                <div class="progress-mini">
                  <div class="bar" style="width: {{ $report->progress }}; background-color: {{ $report->progress_color }};"></div>
                </div>
                <span class="small fw-semibold" style="color: {{ $report->progress_color }};">{{ $report->progress }}</span>
              </div>
            </td>
            <td class="pe-4">
              <a href="{{ route('relawan.transparansi.detail', $report) }}" class="btn-detail">
                <i class="fa-solid fa-file-lines"></i> Lihat Detail
              </a>
            </td>
          </tr>
          @empty
          <tr id="empty-transparansi" style="display:none;">
            <td colspan="8" class="text-center text-muted py-5">
              <i class="fa-solid fa-inbox fa-2x mb-2 d-block opacity-30"></i>
              Belum ada laporan transparansi tersedia.
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
    return Array.from(document.querySelectorAll('#tabel-transparansi tbody tr[data-nama]'));
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

    rows.forEach(r => r.style.display = 'none');
    currentPage = 1;
    renderPage(filtered);
  }

  function renderPage(filtered) {
    const rows = getRows();
    rows.forEach(r => r.style.display = 'none');

    const start = (currentPage - 1) * perPage;
    const end   = perPage === 999 ? filtered.length : start + perPage;
    filtered.slice(start, end).forEach(r => r.style.display = '');

    filtered.slice(start, end).forEach((r, i) => {
      r.querySelector('td:first-child').textContent = start + i + 1;
    });

    buildPagination(filtered);

    const empty = document.getElementById('empty-transparansi');
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

  document.addEventListener('DOMContentLoaded', () => applyFilter());
</script>
@endpush

@endsection