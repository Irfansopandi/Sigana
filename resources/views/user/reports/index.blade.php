@extends('user.layouts.app')

@section('title', 'Laporan Bencana Saya')
@section('page_title', 'Lapor Bencana')

@push('styles')
<style>
  /* ════════════════════════════════
     TOMBOL UTAMA (Buat Laporan Baru)
     ════════════════════════════════ */
  .btn-kirim {
    background: #38bdf8;
    border: none;
    color: #fff;
    font-weight: 600;
    transition: all .2s;
    border-radius: 8px;
  }
  .btn-kirim:hover { background: #0ea5e9; color: #fff; }

  /* ════════════════════════════════
     SUMMARY CARDS (Menunggu / Disetujui / Ditolak)
     ════════════════════════════════ */
  .stat-card {
    border-radius: 16px;
    border: 1px solid transparent;
    border-left: 4px solid transparent;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    transition: transform .2s, box-shadow .2s;
  }
  .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(15,23,42,.1); }
  .stat-icon {
    width: 48px; height: 48px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; flex-shrink: 0;
  }
  .stat-label { font-size: .75rem; color: #64748b; font-weight: 500; margin-bottom: 2px; }
  .stat-value { font-size: 1.6rem; font-weight: 700; line-height: 1; color: #0f172a; }

  /* ════════════════════════════════
     TAB NAVIGASI
     ════════════════════════════════ */
  .tab-nav {
    display: flex;
    gap: 4px;
    background: #f1f5f9;
    border-radius: 10px;
    padding: 4px;
    width: fit-content;
  }
  .tab-btn {
    border: none;
    background: transparent;
    font-size: .85rem;
    font-weight: 600;
    color: #64748b;
    padding: 8px 18px;
    border-radius: 7px;
    cursor: pointer;
    transition: all .18s;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .tab-btn.active {
    background: #fff;
    color: #0f172a;
    box-shadow: 0 1px 4px rgba(15,23,42,.1);
  }

  /* Badge counter di dalam tab */
  .tab-btn .tab-count {
    font-size: .72rem;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 999px;
    line-height: 1.4;
  }
  .tab-btn.active .tab-count-menunggu  { 
    background: #fef3c7; 
    color: #b45309; 
}
  .tab-btn.active .tab-count-disetujui { background: #dcfce7; color: #15803d; }
  .tab-btn.active .tab-count-ditolak   { background: #fee2e2; color: #b91c1c; }
  .tab-btn:not(.active) .tab-count     { background: #e2e8f0; color: #64748b; }

  /* Tampilkan / sembunyikan panel sesuai tab aktif */
  .tab-panel        { display: none; }
  .tab-panel.active { display: block; }

  /* ════════════════════════════════
     CARD LAPORAN
     ════════════════════════════════ */
  .report-card {
    border-radius: 10px;
    border: 1px solid #e2e8f0 !important;
    transition: all .2s;
    background: #fff;
}
.report-card:hover {
  box-shadow: 0 4px 16px rgba(15,23,42,.08);
  transform: translateY(-1px);
}

/* Warna border kiri sesuai status tab */
#tab-menunggu  tbody tr { border-left: 4px solid #f59e0b; }
#tab-disetujui tbody tr { border-left: 4px solid #16a34a; }
#tab-ditolak   tbody tr { border-left: 4px solid #dc2626; }

  /* Thumbnail gambar laporan */
  .report-thumb {
    width: 68px; height: 68px;
    object-fit: cover; border-radius: 10px; flex-shrink: 0;
  }
  /* Placeholder jika tidak ada gambar */
  .report-thumb-placeholder {
    width: 68px; height: 68px; border-radius: 10px;
    background: #f1f5f9;
    display: flex; align-items: center; justify-content: center;
    color: #94a3b8; flex-shrink: 0; font-size: 1.3rem;
  }

  /* ════════════════════════════════
     BADGE STATUS
     ════════════════════════════════ */
  .badge-status {
    font-size: .72rem; font-weight: 600;
    padding: 5px 12px; border-radius: 999px;
    white-space: nowrap;
  }

   /* ════════════════════════════════
     THUMBNAIL KECIL (di dalam tabel)
     ════════════════════════════════ */
  .report-thumb-sm {
    width: 40px; height: 40px;
    object-fit: cover; border-radius: 8px; flex-shrink: 0;
  }
  .report-thumb-sm-placeholder {
    width: 40px; height: 40px; border-radius: 8px;
    background: #f1f5f9;
    display: flex; align-items: center; justify-content: center;
    color: #94a3b8; flex-shrink: 0; font-size: 1rem;
  }
 
  /* Baris tabel hover lebih halus */
  .table-hover tbody tr:hover { background: #f8fafc; }
  .table thead th {
    font-size: .78rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: .04em;
    border-bottom: 1px solid #e2e8f0;
    padding: 12px 8px;
  }
  .table tbody td { padding: 12px 8px; border-color: #f1f5f9; }

  /* ════════════════════════════════
     TOMBOL EDIT
     Default abu-abu, hover → biru muda
     ════════════════════════════════ */
  .btn-edit-report {
    border: 1px solid #e2e8f0;
    color: #64748b;
    font-size: .8rem;
    font-weight: 500;
    background: #fff;
    border-radius: 8px;
    padding: 5px 14px;
    transition: all .18s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }
  .btn-edit-report:hover {
    background: #e0f2fe;
    color: #0284c7;
    border-color: #38bdf8;
  }

  /* ════════════════════════════════
     EMPTY STATE (tidak ada laporan di tab)
     ════════════════════════════════ */
  .empty-state-icon {
    width: 72px; height: 72px; border-radius: 50%; background: #f1f5f9;
    display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;
  }
  .empty-state-icon i { font-size: 1.6rem; color: #94a3b8; }

  /* ════════════════════════════════
     PAGINATION (client-side per tab)
     ════════════════════════════════ */
  .pagination-custom {
    display: flex; align-items: center; justify-content: center;
    gap: 4px; margin-top: 20px;
  }
  .pagination-custom .page-item-custom {
    width: 34px; height: 34px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: .82rem; font-weight: 600; cursor: pointer;
    border: 1px solid #e2e8f0; background: #fff; color: #475569;
    transition: all .15s; user-select: none;
  }
  .pagination-custom .page-item-custom:hover    { border-color: #38bdf8; color: #0284c7; background: #e0f2fe; }
  .pagination-custom .page-item-custom.active   { background: #38bdf8; color: #fff; border-color: #38bdf8; }
  .pagination-custom .page-item-custom.disabled { opacity: .4; pointer-events: none; }
</style>
@endpush

@section('content')

{{-- ════════════════════════════════
     HEADER HALAMAN
     ════════════════════════════════ --}}
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <div>
    <h5 class="fw-bold mb-1">
      <i class="fa-solid fa-triangle-exclamation text-danger me-1"></i> Laporan Bencana Saya
    </h5>
    <p class="text-muted small mb-0">Pantau status laporan kejadian bencana yang sudah kamu kirim.</p>
  </div>
  <a href="{{ route('user.lapor-bencana.create') }}" class="btn btn-kirim px-3">
    <i class="fa-solid fa-plus me-1"></i> Buat Laporan Baru
  </a>
</div>

{{-- ════════════════════════════════
     SUMMARY CARDS
     Menampilkan jumlah laporan per status
     ════════════════════════════════ --}}
<div class="row g-3 mb-4">
  <div class="col-6 col-md-4">
    <div class="stat-card shadow-sm" style="background: #fffbeb; border-left-color: #f59e0b;">
      <div class="stat-icon" style="background: #fef3c7;">
        <i class="fa-solid fa-clock" style="color: #d97706;"></i>
      </div>
      <div>
        <div class="stat-label">Menunggu</div>
        <div class="stat-value">{{ $menunggu->count() }}</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-4">
    <div class="stat-card shadow-sm" style="background: #f0fdf4; border-left-color: #16a34a;">
      <div class="stat-icon" style="background: #dcfce7;">
        <i class="fa-solid fa-circle-check" style="color: #16a34a;"></i>
      </div>
      <div>
        <div class="stat-label">Disetujui</div>
        <div class="stat-value">{{ $disetujui->count() }}</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-4">
    <div class="stat-card shadow-sm" style="background: #fef2f2; border-left-color: #dc2626;">
      <div class="stat-icon" style="background: #fee2e2;">
        <i class="fa-solid fa-circle-xmark" style="color: #dc2626;"></i>
      </div>
      <div>
        <div class="stat-label">Ditolak</div>
        <div class="stat-value">{{ $ditolak->count() }}</div>
      </div>
    </div>
  </div>
</div>

{{-- ════════════════════════════════
     TAB NAVIGASI
     Klik untuk ganti panel yang ditampilkan
     ════════════════════════════════ --}}
<div class="tab-nav mb-4">
  <button class="tab-btn active" onclick="switchTab(event, 'menunggu')">
    <i class="fa-solid fa-clock"></i> Menunggu
    <span class="tab-count tab-count-menunggu">{{ $menunggu->count() }}</span>
  </button>
  <button class="tab-btn" onclick="switchTab(event, 'disetujui')">
    <i class="fa-solid fa-circle-check"></i> Disetujui
    <span class="tab-count tab-count-disetujui">{{ $disetujui->count() }}</span>
  </button>
  <button class="tab-btn" onclick="switchTab(event, 'ditolak')">
    <i class="fa-solid fa-circle-xmark"></i> Ditolak
    <span class="tab-count tab-count-ditolak">{{ $ditolak->count() }}</span>
  </button>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div class="text-muted small">Menampilkan laporan berdasarkan tab aktif</div>
  <div class="d-flex align-items-center gap-2">
    <label class="text-muted small mb-0">Tampilkan:</label>
    <select id="globalPerPage" class="form-select form-select-sm" style="width:auto;">
      <option value="5" selected>5 halaman</option>
      <option value="10">10 halaman</option>
      <option value="25">25 halaman</option>
      <option value="999">Semua</option>
    </select>
  </div>
</div>
{{-- ════════════════════════════════
     TAB PANEL: MENUNGGU VERIFIKASI
     ════════════════════════════════ --}}
<div class="tab-panel active" id="tab-menunggu">
    
  @if($menunggu->isEmpty())
    <div class="card border-0 shadow-sm">
      <div class="card-body text-center py-5">
        <div class="empty-state-icon"><i class="fa-solid fa-folder-open"></i></div>
        <p class="fw-semibold mb-1">Tidak ada laporan</p>
        <p class="text-muted small mb-4">Tidak ada laporan yang menunggu verifikasi.</p>
        <a href="{{ route('user.lapor-bencana.create') }}" class="btn btn-kirim px-4">
          <i class="fa-solid fa-plus me-1"></i> Buat Laporan Sekarang
        </a>
      </div>
    </div>
  @else
    <div class="card border-0 shadow-sm">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th class="ps-3" style="width: 40px;">#</th>
              <th>Judul Laporan</th>
              <th>Lokasi</th>
              <th>Kategori</th>
              <th class="text-center">Korban</th>
              <th>Tanggal</th>
              <th class="text-center">Status</th>
              <th class="text-center pe-3">Aksi</th>
            </tr>
          </thead>
          <tbody id="list-menunggu">
            @foreach($menunggu as $i => $report)
              <tr>
                {{-- No --}}
                <td class="ps-3 text-muted small">{{ $i + 1 }}</td>
                {{-- Judul + thumbnail --}}
                <td>
                  <div class="d-flex align-items-center gap-2">
                    @if($report->image)
                      <img src="{{ asset('storage/'.$report->image) }}" class="report-thumb-sm" alt="{{ $report->title }}">
                    @else
                      <div class="report-thumb-sm-placeholder"><i class="fa-solid fa-image"></i></div>
                    @endif
                    <span class="fw-semibold text-dark" style="font-size: .88rem;">{{ $report->title }}</span>
                  </div>
                </td>
                {{-- Lokasi --}}
                <td class="text-muted small"><i class="fa-solid fa-location-dot me-1 text-danger"></i>{{ $report->location }}</td>
                {{-- Kategori --}}
                <td class="text-muted small"><i class="fa-solid fa-layer-group me-1"></i>{{ $report->category }}</td>
                {{-- Korban --}}
                <td class="text-center text-muted small"><i class="fa-solid fa-people-group me-1"></i>{{ $report->victims }}</td>
                {{-- Tanggal --}}
                <td class="text-muted small"><i class="fa-regular fa-calendar me-1"></i>{{ $report->date_published }}</td>
                {{-- Status --}}
                <td class="text-center">
                  <span class="badge badge-status bg-warning text-dark">
                    <i class="fa-solid fa-clock me-1"></i>Menunggu
                  </span>
                </td>
                {{-- Aksi --}}
                <td class="text-center pe-3">
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        <a href="{{ route('user.lapor-bencana.edit', $report->id) }}" class="btn-edit-report">
                            <i class="fa-solid fa-pen"></i> Edit
                        </a>
                        <form id="form-hapus-{{ $report->id }}" action="{{ route('user.lapor-bencana.destroy', $report->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn-edit-report" style="border-color:#fca5a5; color:#dc2626;"
                                onclick="konfirmasiHapus({{ $report->id }})">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="pagination-custom" id="pag-menunggu"></div>
  @endif
</div>
 
{{-- ════════════════════════════════
     TAB PANEL: DISETUJUI
     ════════════════════════════════ --}}
<div class="tab-panel" id="tab-disetujui">
  @if($disetujui->isEmpty())
    <div class="card border-0 shadow-sm">
      <div class="card-body text-center py-5">
        <div class="empty-state-icon"><i class="fa-solid fa-folder-open"></i></div>
        <p class="fw-semibold mb-1">Tidak ada laporan</p>
        <p class="text-muted small mb-4">Belum ada laporan yang disetujui.</p>
        <a href="{{ route('user.lapor-bencana.create') }}" class="btn btn-kirim px-4">
          <i class="fa-solid fa-plus me-1"></i> Buat Laporan Sekarang
        </a>
      </div>
    </div>
  @else
    <div class="card border-0 shadow-sm">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th class="ps-3" style="width: 40px;">#</th>
              <th>Judul Laporan</th>
              <th>Lokasi</th>
              <th>Kategori</th>
              <th class="text-center">Korban</th>
              <th>Tanggal</th>
              <th class="text-center pe-3">Status</th>
            </tr>
          </thead>
          <tbody id="list-disetujui">
            @foreach($disetujui as $i => $report)
              <tr>
                <td class="ps-3 text-muted small">{{ $i + 1 }}</td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    @if($report->image)
                      <img src="{{ asset('storage/'.$report->image) }}" class="report-thumb-sm" alt="{{ $report->title }}">
                    @else
                      <div class="report-thumb-sm-placeholder"><i class="fa-solid fa-image"></i></div>
                    @endif
                    <span class="fw-semibold text-dark" style="font-size: .88rem;">{{ $report->title }}</span>
                  </div>
                </td>
                <td class="text-muted small"><i class="fa-solid fa-location-dot me-1 text-danger"></i>{{ $report->location }}</td>
                <td class="text-muted small"><i class="fa-solid fa-layer-group me-1"></i>{{ $report->category }}</td>
                <td class="text-center text-muted small"><i class="fa-solid fa-people-group me-1"></i>{{ $report->victims }}</td>
                <td class="text-muted small"><i class="fa-regular fa-calendar me-1"></i>{{ $report->date_published }}</td>
                {{-- Laporan disetujui tidak ada tombol Edit --}}
                <td class="text-center pe-3">
                  <span class="badge badge-status bg-success">
                    <i class="fa-solid fa-circle-check me-1"></i>Disetujui
                  </span>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="pagination-custom" id="pag-disetujui"></div>
  @endif
</div>

{{-- ════════════════════════════════
     TAB PANEL: DITOLAK
     ════════════════════════════════ --}}
<div class="tab-panel" id="tab-ditolak">
  @if($ditolak->isEmpty())
    {{-- Tampilan kosong --}}
    <div class="card border-0 shadow-sm">
      <div class="card-body text-center py-5">
        <div class="empty-state-icon"><i class="fa-solid fa-folder-open"></i></div>
        <p class="fw-semibold mb-1">Tidak ada laporan</p>
        <p class="text-muted small mb-4">Tidak ada laporan yang ditolak.</p>
        <a href="{{ route('user.lapor-bencana.create') }}" class="btn btn-kirim px-4">
          <i class="fa-solid fa-plus me-1"></i> Buat Laporan Sekarang
        </a>
      </div>
    </div>
  @else
    {{-- Daftar card laporan ditolak --}}
    <div class="d-flex flex-column gap-3" id="list-ditolak">
      @foreach($ditolak as $report)
        <div class="card report-card shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3 py-3">
            <div class="d-flex gap-3 align-items-center">
              {{-- Thumbnail --}}
              @if($report->image)
                <img src="{{ asset('storage/'.$report->image) }}" alt="{{ $report->title }}" class="report-thumb">
              @else
                <div class="report-thumb-placeholder"><i class="fa-solid fa-image"></i></div>
              @endif
              {{-- Info laporan --}}
              <div>
                <div class="fw-semibold text-dark mb-1">{{ $report->title }}</div>
                <div class="text-muted small d-flex flex-wrap gap-2">
                  <span><i class="fa-solid fa-location-dot me-1"></i>{{ $report->location }}</span>
                  <span>•</span>
                  <span><i class="fa-solid fa-layer-group me-1"></i>{{ $report->category }}</span>
                  <span>•</span>
                  <span><i class="fa-solid fa-people-group me-1"></i>{{ $report->victims }} orang</span>
                  <span>•</span>
                  <span><i class="fa-regular fa-calendar me-1"></i>{{ $report->date_published }}</span>
                </div>
              </div>
            </div>
            {{-- Badge status + tombol edit (laporan ditolak masih bisa diedit) --}}
            <div class="d-flex align-items-center gap-2 flex-shrink-0">
              <span class="badge badge-status bg-danger">
                <i class="fa-solid fa-circle-xmark me-1"></i>Ditolak
              </span>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('user.lapor-bencana.edit', $report->id) }}" class="btn-edit-report">
                        <i class="fa-solid fa-pen"></i> Edit
                    </a>
                    <form id="form-hapus-{{ $report->id }}" action="{{ route('user.lapor-bencana.destroy', $report->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn-edit-report" style="border-color:#fca5a5; color:#dc2626;"
                            onclick="konfirmasiHapus({{ $report->id }})">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    {{-- Pagination ditolak --}}
    <div class="pagination-custom" id="pag-ditolak"></div>
  @endif
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
  el.className = 'page-item-custom'
    + (disabled ? ' disabled' : '')
    + (active   ? ' active'   : '');
  el.textContent = label;
  return el;
}

function initPagination(listId, pagId) {
  const list = document.getElementById(listId);
  if (!list) return;

  let current = 1;

  function render() {
    const perPage = getPerPage();
    const items = Array.from(list.children);
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
  initPagination('list-menunggu',  'pag-menunggu');
  initPagination('list-disetujui', 'pag-disetujui');
  initPagination('list-ditolak',   'pag-ditolak');

  document.getElementById('globalPerPage').addEventListener('change', () => {
    ['list-menunggu', 'list-disetujui', 'list-ditolak'].forEach(id => {
      const el = document.getElementById(id);
      if (el && el._render) el._render();
    });
  });
});

function konfirmasiHapus(id) {
  Swal.fire({
    title: 'Hapus Laporan?',
    text: 'Laporan yang dihapus tidak dapat dikembalikan.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#dc2626',
    cancelButtonColor: '#64748b',
    confirmButtonText: '<i class="fa-solid fa-trash me-1"></i> Ya, Hapus',
    cancelButtonText: 'Batal',
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('form-hapus-' + id).submit();
    }
  });
}

@if(session('success'))
  Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: '{{ session('success') }}',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    background: '#16a34a',
    color: '#fff',
    iconColor: '#fff',
  });
@endif

</script>
@endpush