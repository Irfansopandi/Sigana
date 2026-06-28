@extends('user.layouts.app')

@section('title', 'Transparansi Dana')
@section('page_title', 'Transparansi Dana')

<style>
.stat-card {
  display: flex;
  align-items: center;
  gap: 14px;
  background: #fff;
  border-radius: 16px;
  padding: 18px 20px;
  box-shadow: 0 1px 4px rgba(0,0,0,0.06);
  border-left: 4px solid var(--card-color);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  cursor: default;
}
.stat-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}
</style>

@section('content')

{{-- Header --}}
<div class="d-flex align-items-center gap-3 mb-1">
  <div class="rounded-3 p-2" style="background: rgba(99,102,241,0.1);">
    <i class="fa-solid fa-magnifying-glass-chart fs-5" style="color:#6366f1;"></i>
  </div>
  <div>
    <h5 class="fw-bold mb-0">Transparansi Dana</h5>
    <p class="text-muted small mb-0">Laporan transparansi dana dari kampanye bencana yang Anda laporkan.</p>
  </div>
</div>

<hr class="mb-4">

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="stat-card" style="--card-color: #6366f1;">
      <div class="rounded-3 p-2" style="background: rgba(99,102,241,0.1);">
        <i class="fa-solid fa-file-lines fs-5" style="color:#6366f1;"></i>
      </div>
      <div>
        <div class="text-muted small">Total Laporan</div>
        <div class="fw-bold fs-5">{{ $reports->count() }}</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card" style="--card-color: #22c55e;">
      <div class="rounded-3 p-2" style="background: rgba(34,197,94,0.1);">
        <i class="fa-solid fa-circle-check fs-5" style="color:#22c55e;"></i>
      </div>
      <div>
        <div class="text-muted small">Selesai</div>
        <div class="fw-bold fs-5">{{ $reports->filter(fn($r) => $r->status === 'Hampir Selesai')->count() }}</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card" style="--card-color: #3b82f6;">
      <div class="rounded-3 p-2" style="background: rgba(59,130,246,0.1);">
        <i class="fa-solid fa-truck fs-5" style="color:#3b82f6;"></i>
      </div>
      <div>
        <div class="text-muted small">Dalam Penyaluran</div>
        <div class="fw-bold fs-5">{{ $reports->filter(fn($r) => $r->status === 'Dalam Penyaluran')->count() }}</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card" style="--card-color: #f59e0b;">
      <div class="rounded-3 p-2" style="background: rgba(245,158,11,0.1);">
        <i class="fa-solid fa-spinner fs-5" style="color:#f59e0b;"></i>
      </div>
      <div>
        <div class="text-muted small">Aktif</div>
        <div class="fw-bold fs-5">{{ $reports->filter(fn($r) => $r->status === 'Aktif')->count() }}</div>
      </div>
    </div>
  </div>
</div>

{{-- Filter & Sort --}}
<div class="card border-0 shadow-sm mb-3">
  <div class="card-body py-3 px-4 d-flex flex-wrap gap-2 align-items-center justify-content-between">
    <div class="input-group" style="max-width: 260px;">
      <span class="input-group-text bg-white border-end-0">
        <i class="fa-solid fa-magnifying-glass text-muted small"></i>
      </span>
      <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Cari kampanye..." style="font-size:0.875rem;">
    </div>
    <div class="d-flex gap-2 align-items-center">
      <select id="filterStatus" class="form-select" style="max-width:180px; font-size:0.875rem;">
        <option value="">Semua Status</option>
        <option value="Aktif">Aktif</option>
        <option value="Dalam Penyaluran">Dalam Penyaluran</option>
        <option value="Hampir Selesai">Hampir Selesai</option>
      </select>
      <select id="sortBy" class="form-select" style="max-width:160px; font-size:0.875rem;">
        <option value="terbaru">Terbaru</option>
        <option value="terlama">Terlama</option>
        <option value="az">A–Z</option>
        <option value="za">Z–A</option>
      </select>
      <button onclick="resetFilter()" class="btn btn-outline-secondary btn-sm px-3" title="Reset">
        <i class="fa-solid fa-rotate-left"></i>
      </button>
    </div>
  </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0 align-middle" id="transparansiTable">
        <thead class="table-light">
          <tr>
            <th class="ps-4 text-uppercase small text-muted fw-semibold" style="width:50px;">#</th>
            <th class="text-uppercase small text-muted fw-semibold">Kampanye</th>
            <th class="text-uppercase small text-muted fw-semibold">Lokasi</th>
            <th class="text-uppercase small text-muted fw-semibold">Status</th>
            <th class="text-uppercase small text-muted fw-semibold">Dana Digunakan</th>
            <th class="text-uppercase small text-muted fw-semibold">Aksi</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          @forelse($reports as $i => $r)
          <tr data-title="{{ strtolower($r->campaign->title ?? '') }}"
              data-status="{{ $r->status }}"
              data-date="{{ $r->created_at->timestamp }}">
            <td class="ps-4 text-muted small">{{ $i + 1 }}</td>
            <td>
              <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('storage/' . $r->campaign->image) }}"
                  class="rounded-2 object-fit-cover" style="width:48px;height:48px;">
                <div>
                  <div class="fw-semibold" style="font-size:0.9rem;">{{ $r->campaign->title ?? '-' }}</div>
                  <div class="text-muted small">{{ $r->date }}</div>
                </div>
              </div>
            </td>
            <td>
              <span class="text-muted small">
                <i class="fa-solid fa-location-dot text-danger me-1"></i>
                {{ $r->campaign->location ?? '-' }}
              </span>
            </td>
            <td>
              @php
                $badgeColor = match($r->status) {
                  'Dalam Penyaluran' => 'primary',
                  'Hampir Selesai'   => 'success',
                  'Aktif'            => 'warning',
                  default            => 'secondary',
                };
              @endphp
              <span class="badge bg-{{ $badgeColor }} bg-opacity-10 text-{{ $badgeColor }} border border-{{ $badgeColor }} rounded-pill px-3 py-1" style="font-size:0.75rem;">
                {{ $r->status }}
              </span>
            </td>
            <td class="fw-semibold text-danger small">{{ $r->used }}</td>
            <td>
              <a href="{{ route('transparansi.detail', $r->campaign->slug) }}"
                class="btn btn-sm btn-outline-primary rounded-pill px-3">
                → Lihat Detail
              </a>
            </td>
          </tr>
          @empty
          <tr id="emptyRow">
            <td colspan="6" class="text-center py-5 text-muted">
              <i class="fa-solid fa-folder-open fs-3 d-block mb-2 opacity-50"></i>
              Belum ada laporan transparansi dari kampanye Anda yang telah disetujui.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
function applyFilter() {
  const search = document.getElementById('searchInput').value.toLowerCase();
  const status = document.getElementById('filterStatus').value;
  const sort   = document.getElementById('sortBy').value;

  let rows = Array.from(document.querySelectorAll('#tableBody tr[data-title]'));

  // Filter
  rows.forEach(row => {
    const matchSearch = row.dataset.title.includes(search);
    const matchStatus = status === '' || row.dataset.status === status;
    row.style.display = matchSearch && matchStatus ? '' : 'none';
  });

  // Sort
  const visible = rows.filter(r => r.style.display !== 'none');
  visible.sort((a, b) => {
    if (sort === 'terbaru') return b.dataset.date - a.dataset.date;
    if (sort === 'terlama') return a.dataset.date - b.dataset.date;
    if (sort === 'az') return a.dataset.title.localeCompare(b.dataset.title);
    if (sort === 'za') return b.dataset.title.localeCompare(a.dataset.title);
  });

  const tbody = document.getElementById('tableBody');
  visible.forEach(r => tbody.appendChild(r));

  // Renumber
  let n = 1;
  rows.forEach(row => {
    if (row.style.display !== 'none') {
      row.querySelector('td:first-child').textContent = n++;
    }
  });
}

function resetFilter() {
  document.getElementById('searchInput').value = '';
  document.getElementById('filterStatus').value = '';
  document.getElementById('sortBy').value = 'terbaru';
  applyFilter();
}

document.getElementById('searchInput').addEventListener('input', applyFilter);
document.getElementById('filterStatus').addEventListener('change', applyFilter);
document.getElementById('sortBy').addEventListener('change', applyFilter);
</script>

@endsection