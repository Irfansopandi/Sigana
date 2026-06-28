@extends('user.layouts.app')

@section('title', 'Riwayat Donasi')
@section('page_title', 'Riwayat Donasi Saya')

@push('styles')
<style>
  .tab-nav {
    display: flex; gap: 4px;
    background: #f1f5f9; border-radius: 10px;
    padding: 4px; width: fit-content;
  }
  .tab-btn {
    border: none; background: transparent;
    font-size: .85rem; font-weight: 600; color: #64748b;
    padding: 8px 18px; border-radius: 7px; cursor: pointer;
    transition: all .18s; display: flex; align-items: center; gap: 6px;
  }
  .tab-btn.active {
    background: #fff; color: #0f172a;
    box-shadow: 0 1px 4px rgba(15,23,42,.1);
  }
  .tab-btn .tab-count {
    font-size: .72rem; font-weight: 700;
    padding: 2px 7px; border-radius: 999px; line-height: 1.4;
  }
  .tab-btn.active .tab-count-semua    { background: #e0e7ff; color: #3730a3; }
  .tab-btn.active .tab-count-berhasil { background: #dcfce7; color: #15803d; }
  .tab-btn.active .tab-count-pending  { background: #fef3c7; color: #b45309; }
  .tab-btn.active .tab-count-gagal    { background: #fee2e2; color: #b91c1c; }
  .tab-btn:not(.active) .tab-count    { background: #e2e8f0; color: #64748b; }

  .tab-panel { display: none; }
  .tab-panel.active { display: block; }

  .table thead th {
    font-size: .78rem; font-weight: 600; color: #64748b;
    text-transform: uppercase; letter-spacing: .04em;
    border-bottom: 1px solid #e2e8f0; padding: 12px 16px;
  }
  .table tbody td { padding: 12px 16px; border-color: #f1f5f9; vertical-align: middle; }
  .table-hover tbody tr:hover { background: #f8fafc; }

  .page-item-custom {
    width: 34px; height: 34px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: .82rem; font-weight: 600; cursor: pointer;
    border: 1px solid #e2e8f0; background: #fff; color: #475569;
    transition: all .15s; user-select: none;
  }
  .page-item-custom:hover    { border-color: #38bdf8; color: #0284c7; background: #e0f2fe; }
  .page-item-custom.active   { background: #38bdf8; color: #fff; border-color: #38bdf8; }
  .page-item-custom.disabled { opacity: .4; pointer-events: none; }

  .empty-state-icon {
    width: 72px; height: 72px; border-radius: 50%; background: #f1f5f9;
    display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;
  }
  .card {
    border-radius: 16px !important;
  }
  .empty-state-icon i { font-size: 1.6rem; color: #94a3b8; }
</style>
@endpush

@section('content')

{{-- Header --}}
<div class="mb-4">
  <h5 class="fw-bold mb-1">
    <i class="fa-solid fa-clock-rotate-left text-primary me-2"></i>Riwayat Donasi Saya
  </h5>
  <p class="text-muted small mb-0">Pantau semua transaksi donasi yang pernah kamu lakukan.</p>
</div>

{{-- Summary Cards --}}
@php
  $semua    = $donations;
  $berhasil = $donations->where('payment_status', 'success');
  $pending  = $donations->where('payment_status', 'pending');
  $gagal    = $donations->whereNotIn('payment_status', ['success', 'pending']);
  $totalNominal = $berhasil->sum(fn($d) => (int) $d->amount);
@endphp

<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm card-hover h-100" style="border-left: 4px solid #6366f1 !important; border-left-width: 4px !important;">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 p-3" style="background:#eef2ff;">
          <i class="fa-solid fa-list fa-lg" style="color:#6366f1;"></i>
        </div>
        <div>
          <div class="text-muted small">Total Transaksi</div>
          <div class="fw-bold fs-5">{{ $semua->count() }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm card-hover h-100" style="border-left: 4px solid #16a34a !important;">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 p-3" style="background:#f0fdf4;">
          <i class="fa-solid fa-circle-check fa-lg" style="color:#16a34a;"></i>
        </div>
        <div>
          <div class="text-muted small">Berhasil</div>
          <div class="fw-bold fs-5">{{ $berhasil->count() }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm card-hover h-100" style="border-left: 4px solid #d97706 !important;">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 p-3" style="background:#fffbeb;">
          <i class="fa-solid fa-clock fa-lg" style="color:#d97706;"></i>
        </div>
        <div>
          <div class="text-muted small">Pending</div>
          <div class="fw-bold fs-5">{{ $pending->count() }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm card-hover h-100" style="border-left: 4px solid #dc2626 !important;">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 p-3" style="background:#fef2f2;">
          <i class="fa-solid fa-circle-xmark fa-lg" style="color:#dc2626;"></i>
        </div>
        <div>
          <div class="text-muted small">Gagal</div>
          <div class="fw-bold fs-5">{{ $gagal->count() }}</div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Tab Nav --}}
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
  <div class="tab-nav">
    <button class="tab-btn active" onclick="switchTab(event, 'semua')">
      <i class="fa-solid fa-list"></i> Semua
      <span class="tab-count tab-count-semua">{{ $semua->count() }}</span>
    </button>
    <button class="tab-btn" onclick="switchTab(event, 'berhasil')">
      <i class="fa-solid fa-circle-check"></i> Berhasil
      <span class="tab-count tab-count-berhasil">{{ $berhasil->count() }}</span>
    </button>
    <button class="tab-btn" onclick="switchTab(event, 'pending')">
      <i class="fa-solid fa-clock"></i> Pending
      <span class="tab-count tab-count-pending">{{ $pending->count() }}</span>
    </button>
    <button class="tab-btn" onclick="switchTab(event, 'gagal')">
      <i class="fa-solid fa-circle-xmark"></i> Gagal
      <span class="tab-count tab-count-gagal">{{ $gagal->count() }}</span>
    </button>
  </div>

  {{-- Sortir Per Halaman --}}
  <div class="d-flex align-items-center gap-2">
    <label class="text-muted small mb-0">Tampilkan:</label>
    <select id="globalPerPage" class="form-select form-select-sm" style="width:auto;">
      <option value="5" selected>5 per halaman</option>
      <option value="10">10 per halaman</option>
      <option value="25">25 per halaman</option>
      <option value="999">Semua</option>
    </select>
  </div>
</div>

{{-- Helper Blade untuk render tabel --}}
@php
  function renderDonationRows($items) {
    return $items;
  }
@endphp

{{-- TAB: SEMUA --}}
<div class="tab-panel active" id="tab-semua">
  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
          <thead class="table-light">
            <tr>
              <th class="ps-4" style="width:50px">#</th>
              <th>Kampanye</th>
              <th>Jumlah Donasi</th>
              <th style="width:130px">Status</th>
              <th style="width:140px">Tanggal</th>
            </tr>
          </thead>
          <tbody id="list-semua">
            @forelse($semua as $i => $d)
            <tr>
              <td class="ps-4 text-muted small">{{ $i + 1 }}</td>
              <td class="fw-medium">{{ $d->campaign->title ?? '-' }}</td>
              <td class="fw-semibold text-success small">Rp {{ number_format($d->getRawOriginal('amount'), 0, ',', '.') }}</td>
              <td>
                @if($d->payment_status === 'success')
                  <span class="badge bg-success rounded-pill px-3"><i class="fa-solid fa-circle-check me-1"></i>Berhasil</span>
                @elseif($d->payment_status === 'pending')
                  <span class="badge bg-warning text-dark rounded-pill px-3"><i class="fa-solid fa-clock me-1"></i>Pending</span>
                @else
                  <span class="badge bg-danger rounded-pill px-3"><i class="fa-solid fa-circle-xmark me-1"></i>Gagal</span>
                @endif
              </td>
              <td class="text-muted small"><i class="fa-regular fa-calendar me-1"></i>{{ $d->created_at->translatedFormat('d M Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center py-5 text-muted">
              <div class="empty-state-icon"><i class="fa-solid fa-inbox"></i></div>
              Belum ada riwayat donasi.
            </td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="d-flex justify-content-center gap-1 mt-3" id="pag-semua"></div>
</div>

{{-- TAB: BERHASIL --}}
<div class="tab-panel" id="tab-berhasil">
  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
          <thead class="table-light">
            <tr>
              <th class="ps-4" style="width:50px">#</th>
              <th>Kampanye</th>
              <th>Jumlah Donasi</th>
              <th style="width:140px">Tanggal</th>
            </tr>
          </thead>
          <tbody id="list-berhasil">
            @forelse($berhasil as $i => $d)
            <tr>
              <td class="ps-4 text-muted small">{{ $i + 1 }}</td>
              <td class="fw-medium">{{ $d->campaign->title ?? '-' }}</td>
              <td class="fw-semibold text-success small">Rp {{ number_format($d->getRawOriginal('amount'), 0, ',', '.') }}</td>
              <td class="text-muted small"><i class="fa-regular fa-calendar me-1"></i>{{ $d->created_at->translatedFormat('d M Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center py-5 text-muted">
              <div class="empty-state-icon"><i class="fa-solid fa-inbox"></i></div>
              Belum ada donasi berhasil.
            </td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="d-flex justify-content-center gap-1 mt-3" id="pag-berhasil"></div>
</div>

{{-- TAB: PENDING --}}
<div class="tab-panel" id="tab-pending">
  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
          <thead class="table-light">
            <tr>
              <th class="ps-4" style="width:50px">#</th>
              <th>Kampanye</th>
              <th>Jumlah Donasi</th>
              <th style="width:140px">Tanggal</th>
            </tr>
          </thead>
          <tbody id="list-pending">
            @forelse($pending as $i => $d)
            <tr>
              <td class="ps-4 text-muted small">{{ $i + 1 }}</td>
              <td class="fw-medium">{{ $d->campaign->title ?? '-' }}</td>
              <td class="fw-semibold small" style="color:#d97706;">Rp {{ number_format($d->getRawOriginal('amount'), 0, ',', '.') }}</td>
              <td class="text-muted small"><i class="fa-regular fa-calendar me-1"></i>{{ $d->created_at->translatedFormat('d M Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center py-5 text-muted">
              <div class="empty-state-icon"><i class="fa-solid fa-inbox"></i></div>
              Tidak ada donasi pending.
            </td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="d-flex justify-content-center gap-1 mt-3" id="pag-pending"></div>
</div>

{{-- TAB: GAGAL --}}
<div class="tab-panel" id="tab-gagal">
  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
          <thead class="table-light">
            <tr>
              <th class="ps-4" style="width:50px">#</th>
              <th>Kampanye</th>
              <th>Jumlah Donasi</th>
              <th style="width:140px">Tanggal</th>
            </tr>
          </thead>
          <tbody id="list-gagal">
            @forelse($gagal as $i => $d)
            <tr>
              <td class="ps-4 text-muted small">{{ $i + 1 }}</td>
              <td class="fw-medium">{{ $d->campaign->title ?? '-' }}</td>
              <td class="fw-semibold text-danger small">Rp {{ number_format($d->getRawOriginal('amount'), 0, ',', '.') }}</td>
              <td class="text-muted small"><i class="fa-regular fa-calendar me-1"></i>{{ $d->created_at->translatedFormat('d M Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center py-5 text-muted">
              <div class="empty-state-icon"><i class="fa-solid fa-inbox"></i></div>
              Tidak ada donasi gagal.
            </td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="d-flex justify-content-center gap-1 mt-3" id="pag-gagal"></div>
</div>

@endsection

@push('scripts')
<script>
function switchTab(e, name) {
  document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  document.getElementById('tab-' + name).classList.add('active');
  e.currentTarget.classList.add('active');
}

function getPerPage() {
  return parseInt(document.getElementById('globalPerPage').value);
}

function makeBtn(label, disabled = false, active = false) {
  const el = document.createElement('div');
  el.className = 'page-item-custom' + (disabled ? ' disabled' : '') + (active ? ' active' : '');
  el.textContent = label;
  return el;
}

function initPagination(listId, pagId) {
  const list = document.getElementById(listId);
  if (!list) return;
  let current = 1;

  function render() {
    const perPage = getPerPage();
    const items = Array.from(list.querySelectorAll('tr[class], tr:not([id])'));
    if (items.length === 0) return;

    const totalPages = perPage === 999 ? 1 : Math.ceil(items.length / perPage);
    if (current > totalPages) current = 1;

    items.forEach((el, i) => {
      const start = (current - 1) * perPage;
      const end = perPage === 999 ? items.length : start + perPage;
      el.style.display = (i >= start && i < end) ? '' : 'none';
    });

    const pag = document.getElementById(pagId);
    pag.innerHTML = '';
    if (totalPages <= 1) return;

    const prev = makeBtn('‹', current === 1);
    prev.addEventListener('click', () => { if (current > 1) { current--; render(); } });
    pag.appendChild(prev);

    for (let p = 1; p <= totalPages; p++) {
      const btn = makeBtn(p, false, p === current);
      btn.addEventListener('click', () => { current = p; render(); });
      pag.appendChild(btn);
    }

    const next = makeBtn('›', current === totalPages);
    next.addEventListener('click', () => { if (current < totalPages) { current++; render(); } });
    pag.appendChild(next);
  }

  list._render = render;
  render();
}

document.addEventListener('DOMContentLoaded', () => {
  initPagination('list-semua',    'pag-semua');
  initPagination('list-berhasil', 'pag-berhasil');
  initPagination('list-pending',  'pag-pending');
  initPagination('list-gagal',    'pag-gagal');

  document.getElementById('globalPerPage').addEventListener('change', () => {
    ['list-semua', 'list-berhasil', 'list-pending', 'list-gagal'].forEach(id => {
      const el = document.getElementById(id);
      if (el && el._render) el._render();
    });
  });
});
</script>
@endpush