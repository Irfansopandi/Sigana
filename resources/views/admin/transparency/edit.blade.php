@extends('admin.layouts.app')

@section('title', 'Edit Laporan Transparansi')
@section('page_title', 'Edit Laporan Transparansi')

@push('styles')
<style>
  .detail-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
  }
  .detail-card h5 { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; }

  .btn-back {
    background: #fff; color: #475569; border: 1.5px solid #e2e8f0;
    border-radius: 999px; padding: 6px 16px; font-size: 0.85rem; font-weight: 500;
    display: inline-flex; align-items: center; transition: all .2s;text-decoration: none;
  }
  .btn-back:hover { background: #f8fafc; color: #1e293b; border-color: #cbd5e1; transform: translateY(-1px); }

  .btn-save-status {
    background: #eff6ff; color: #2563eb; border: 1.5px solid #bfdbfe;
    border-radius: 8px; padding: 8px 18px; font-size: 0.85rem; font-weight: 500;
    transition: all .2s; display: inline-flex; align-items: center;
  }
  .btn-save-status:hover { background: #dbeafe; color: #1d4ed8; border-color: #93c5fd; transform: translateY(-1px); }

  .manage-item {
    display: flex; justify-content: space-between; align-items: flex-start; gap: .75rem;
    padding: .85rem; border: 1px solid #e5e7eb; border-radius: 12px;
    margin-bottom: .75rem; background: #f8fafc;
  }
  .manage-item:last-of-type { margin-bottom: 0; }
  .manage-item-actions { display: flex; gap: .4rem; flex-shrink: 0; }

  .btn-icon-sm {
    width: 32px; height: 32px; border-radius: 8px; display: flex;
    align-items: center; justify-content: center; border: 1.5px solid; transition: all .2s; font-size: 0.8rem;
  }
  .btn-icon-edit { background: #eff6ff; color: #2563eb; border-color: #bfdbfe; }
  .btn-icon-edit:hover { background: #dbeafe; border-color: #93c5fd; }
  .btn-icon-delete { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
  .btn-icon-delete:hover { background: #fee2e2; border-color: #fca5a5; }

  .btn-add-dashed {
    width: 100%; border: 1.5px dashed #cbd5e1; border-radius: 12px; background: #fff;
    color: #64748b; padding: .65rem; font-size: .85rem; font-weight: 500; transition: all .2s;
  }
  .btn-add-dashed:hover { border-color: #94a3b8; background: #f8fafc; color: #334155; }
</style>
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-pen-to-square text-info me-2"></i>Edit Laporan Transparansi</h5>
    <p class="text-muted small mb-0">Kelola informasi, alokasi belanja, timeline, dan dokumen laporan.</p>
  </div>
  <a href="{{ route('admin.transparency.index', $report) }}" class="btn-back">
    <i class="fa-solid fa-arrow-left me-2"></i>Kembali
  </a>
</div>

@if(session('success'))
<div class="alert alert-success rounded-3 mb-4">{{ session('success') }}</div>
@endif

    @php
    $campaign = $report->campaign;
    $badgeClass = match($report->status) {
        'Dalam Penyaluran' => 'badge-penyaluran',
        'Hampir Selesai'   => 'badge-selesai',
        'Selesai'          => 'badge-done',
        default            => 'badge-aktif',
    };
    $badgeIcon = match($report->status) {
        'Dalam Penyaluran' => 'fa-truck',
        'Hampir Selesai'   => 'fa-circle-check',
        'Selesai'          => 'fa-flag-checkered', 
        default            => 'fa-circle-dot',
    };
    $imgPath = $campaign?->getRawOriginal('image');
    $imgUrl = $imgPath
        ? (str_starts_with($imgPath, 'storage/') ? asset($imgPath) : asset('storage/' . $imgPath))
        : null;
    @endphp

    <div class="detail-card p-0 overflow-hidden mb-4">
    @if($imgUrl)
        <img src="{{ $imgUrl }}" alt="{{ $campaign->title }}"
            style="width:100%; height:280px; object-fit:cover; object-position:center;">
    @endif
    <div class="p-4">
        <div class="d-flex justify-content-between align-items-start mb-2">
        <div>
            <h5 class="fw-bold mb-1">{{ $campaign->title ?? '-' }}</h5>
            <div class="small text-muted">
            <i class="fa-solid fa-calendar me-1"></i>Tanggal laporan: {{ $report->date }}
            </div>
        </div>
        <span class="badge rounded-pill px-3 py-2 {{ $badgeClass }}">
            <i class="fa-solid {{ $badgeIcon }} me-1"></i>{{ $report->status }}
        </span>
        </div>
    </div>
    </div>

<div class="row g-4">

  {{-- KONTEN KIRI --}}
  <div class="col-lg-8">

    {{-- Informasi Utama --}}
    <div class="detail-card">
      <h5><i class="fa-solid fa-circle-info text-primary me-2"></i>Informasi Utama</h5>
      <form action="{{ route('admin.transparency.updateInfo', $report) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label small fw-medium">Status Laporan</label>
            <select name="status" class="form-select">
              @foreach($statusOptions as $value => $label)
                <option value="{{ $value }}" {{ old('status', $report->status) == $value ? 'selected' : '' }}>{{ $label }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label small fw-medium">Korban Terbantu (jiwa)</label>
            <input type="number" name="beneficiaries" min="0" class="form-control"
                   value="{{ old('beneficiaries', $report->beneficiaries) }}">
          </div>
          <div class="col-12">
            <label class="form-label small fw-medium">Deskripsi Penyaluran Bantuan</label>
            <textarea name="description" rows="4" class="form-control">{{ old('description', $report->description) }}</textarea>
          </div>
        </div>
        <button type="submit" class="btn-save-status mt-3">
          <i class="fa-solid fa-check me-2"></i>Simpan Informasi
        </button>
      </form>
    </div>

    {{-- Alokasi Belanja --}}
    <div class="detail-card">
      <h5><i class="fa-solid fa-chart-pie text-warning me-2"></i>Rincian Alokasi Belanja</h5>

      @foreach($report->allocations as $alloc)
      <div class="manage-item">
        <div>
          <div class="fw-semibold" style="font-size:.88rem;">{{ $alloc->kategori }}</div>
          <div class="text-muted" style="font-size:.78rem;">{{ $alloc->desc }}</div>
          <div class="fw-semibold text-danger mt-1" style="font-size:.85rem;">{{ $alloc->nominal }}</div>
        </div>
        <div class="manage-item-actions">
          <button type="button" class="btn-icon-sm btn-icon-edit" data-bs-toggle="modal" data-bs-target="#editAllocation{{ $alloc->id }}">
            <i class="fa-solid fa-pen"></i>
          </button>
          <form action="{{ route('admin.transparency.allocations.destroy', $alloc) }}" method="POST" class="delete-form">
            @csrf @method('DELETE')
            <button type="submit" class="btn-icon-sm btn-icon-delete"><i class="fa-solid fa-trash"></i></button>
          </form>
        </div>
      </div>

      <div class="modal fade" id="editAllocation{{ $alloc->id }}" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <form action="{{ route('admin.transparency.allocations.update', $alloc) }}" method="POST">
              @csrf @method('PUT')
              <div class="modal-header">
                <h6 class="modal-title fw-bold">Edit Alokasi Belanja</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label class="form-label small fw-medium">Nama Kategori</label>
                  <input type="text" name="kategori" class="form-control" value="{{ $alloc->kategori }}" required>
                </div>
                <div class="mb-3">
                  <label class="form-label small fw-medium">Nominal Terpakai (Rp)</label>
                  <input type="number" name="nominal" class="form-control" value="{{ $alloc->getRawOriginal('nominal') }}" required>
                </div>
                <div class="mb-3">
                  <label class="form-label small fw-medium">Progress (%)</label>
                    <input type="number" name="progress" min="0" max="100" class="form-control" value="{{ $alloc->getRawOriginal('progress') }}">
                </div>
                <div class="mb-3">
                  <label class="form-label small fw-medium">Icon (FontAwesome class)</label>
                  <input type="text" name="icon" class="form-control" value="{{ $alloc->icon }}" placeholder="fa-box">
                </div>
                <div class="mb-0">
                  <label class="form-label small fw-medium">Deskripsi</label>
                  <textarea name="desc" rows="3" class="form-control">{{ $alloc->desc }}</textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn-save-status">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      @endforeach

      <button type="button" class="btn-add-dashed" data-bs-toggle="modal" data-bs-target="#addAllocationModal">
        <i class="fa-solid fa-plus me-2"></i>Tambah Alokasi Belanja
      </button>
    </div>

    {{-- Timeline Penyaluran --}}
    <div class="detail-card">
      <h5><i class="fa-solid fa-clock-rotate-left text-info me-2"></i>Timeline Penyaluran</h5>

      @foreach($report->timeline as $tl)
      <div class="manage-item">
        <div>
          <div class="text-muted small mb-1"><i class="fa-solid fa-calendar-days me-1"></i>{{ $tl->tanggal }}</div>
          <div class="fw-semibold" style="font-size:.88rem;">{{ $tl->judul }}</div>
          <div class="text-muted" style="font-size:.78rem;">{{ $tl->deskripsi }}</div>
        </div>
        <div class="manage-item-actions">
          <button type="button" class="btn-icon-sm btn-icon-edit" data-bs-toggle="modal" data-bs-target="#editTimeline{{ $tl->id }}">
            <i class="fa-solid fa-pen"></i>
          </button>
          <form action="{{ route('admin.transparency.timeline.destroy', $tl) }}" method="POST" class="delete-form">
            @csrf @method('DELETE')
            <button type="submit" class="btn-icon-sm btn-icon-delete"><i class="fa-solid fa-trash"></i></button>
          </form>
        </div>
      </div>

      <div class="modal fade" id="editTimeline{{ $tl->id }}" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <form action="{{ route('admin.transparency.timeline.update', $tl) }}" method="POST">
              @csrf @method('PUT')
              <div class="modal-header">
                <h6 class="modal-title fw-bold">Edit Timeline Penyaluran</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label class="form-label small fw-medium">Tanggal</label>
                  <input type="date" name="tanggal" class="form-control"
                         value="{{ \Carbon\Carbon::parse($tl->getRawOriginal('tanggal'))->format('Y-m-d') }}" required>
                </div>
                <div class="mb-3">
                  <label class="form-label small fw-medium">Judul</label>
                  <input type="text" name="judul" class="form-control" value="{{ $tl->judul }}" required>
                </div>
                <div class="mb-3">
                  <label class="form-label small fw-medium">Icon (FontAwesome class)</label>
                  <input type="text" name="icon" class="form-control" value="{{ $tl->icon }}" placeholder="fa-truck">
                </div>
                <div class="mb-0">
                  <label class="form-label small fw-medium">Deskripsi</label>
                  <textarea name="deskripsi" rows="3" class="form-control">{{ $tl->deskripsi }}</textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn-save-status">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      @endforeach

      <button type="button" class="btn-add-dashed" data-bs-toggle="modal" data-bs-target="#addTimelineModal">
        <i class="fa-solid fa-plus me-2"></i>Tambah Timeline Penyaluran
      </button>
    </div>

  </div>

  {{-- SIDEBAR KANAN: Dokumen --}}
  <div class="col-lg-4">
    <div class="detail-card">
      <h5><i class="fa-solid fa-file-invoice text-success me-2"></i>Kuitansi & Dokumen Pendukung</h5>

      @foreach($report->docs as $doc)
      <div class="manage-item">
        <div>
          <div class="fw-semibold" style="font-size:.85rem;">{{ $doc->nama }}</div>
          @if($doc->getRawOriginal('nominal') > 0)
            <div class="text-danger fw-semibold" style="font-size:.8rem;">{{ $doc->nominal }}</div>
          @endif
          <div class="text-muted" style="font-size:.72rem;">{{ $doc->doc_id }}</div>
        </div>
        <div class="manage-item-actions">
          <a href="{{ Storage::url($doc->file) }}" target="_blank" class="btn-icon-sm btn-icon-edit">
            <i class="fa-solid fa-download"></i>
          </a>
          <form action="{{ route('admin.transparency.docs.destroy', $doc) }}" method="POST" class="delete-form">
            @csrf @method('DELETE')
            <button type="submit" class="btn-icon-sm btn-icon-delete"><i class="fa-solid fa-trash"></i></button>
          </form>
        </div>
      </div>
      @endforeach

      <button type="button" class="btn-add-dashed" data-bs-toggle="modal" data-bs-target="#addDocModal">
        <i class="fa-solid fa-plus me-2"></i>Tambah Dokumen
      </button>
    </div>
    {{-- Galeri Bukti Foto Penyaluran --}}
    <div class="detail-card">
      <h5><i class="fa-solid fa-images text-primary me-2"></i>Galeri Bukti Foto Penyaluran</h5>

      @foreach($report->evidence as $ev)
      <div class="manage-item">
        <div class="d-flex gap-2 align-items-start">
          <img src="{{ $ev->photo_url }}" style="width:50px;height:50px;object-fit:cover;border-radius:8px;flex-shrink:0;" alt="Foto">
          <div>
            <div class="text-muted" style="font-size:.78rem;">{{ $ev->desc ?: 'Tanpa keterangan' }}</div>
          </div>
        </div>
        <div class="manage-item-actions">
          <a href="{{ $ev->photo_url }}" target="_blank" class="btn-icon-sm btn-icon-edit text-decoration-none">
            <i class="fa-solid fa-eye"></i>
          </a>
          <form action="{{ route('admin.transparency.evidence.destroy', $ev) }}" method="POST" class="delete-form">
            @csrf @method('DELETE')
            <button type="submit" class="btn-icon-sm btn-icon-delete"><i class="fa-solid fa-trash"></i></button>
          </form>
        </div>
      </div>
      @endforeach

      <button type="button" class="btn-add-dashed" data-bs-toggle="modal" data-bs-target="#addEvidenceModal">
        <i class="fa-solid fa-plus me-2"></i>Tambah Foto Bukti
      </button>
    </div>
  </div>
</div>

{{-- ===== MODAL TAMBAH ALOKASI ===== --}}
<div class="modal fade" id="addAllocationModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.transparency.allocations.store', $report) }}" method="POST">
        @csrf
        <div class="modal-header">
          <h6 class="modal-title fw-bold">Tambah Alokasi Belanja</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-medium">Nama Kategori</label>
            <input type="text" name="kategori" class="form-control" placeholder="Contoh: Bahan Pangan" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-medium">Nominal Terpakai (Rp)</label>
            <input type="number" name="nominal" class="form-control" placeholder="0" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-medium">Progress (%)</label>
            <input type="number" name="progress" min="0" max="100" class="form-control" value="100">
          </div>
          <div class="mb-3">
            <label class="form-label small fw-medium">Icon (FontAwesome class)</label>
            <input type="text" name="icon" class="form-control" placeholder="fa-box">
          </div>
          <div class="mb-0">
            <label class="form-label small fw-medium">Deskripsi</label>
            <textarea name="desc" rows="3" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn-save-status">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ===== MODAL TAMBAH FOTO BUKTI ===== --}}
<div class="modal fade" id="addEvidenceModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.transparency.evidence.store', $report) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h6 class="modal-title fw-bold">Tambah Foto Bukti Penyaluran</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-medium">Foto (JPG/PNG, max 2MB)</label>
            <input type="file" name="photo" class="form-control" accept="image/*" required>
          </div>
          <div class="mb-0">
            <label class="form-label small fw-medium">Keterangan — opsional</label>
            <textarea name="desc" rows="2" class="form-control" placeholder="Contoh: Distribusi bantuan susu formula dan popok bayi di tenda pengungsian."></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn-save-status">Unggah</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ===== MODAL TAMBAH TIMELINE ===== --}}
<div class="modal fade" id="addTimelineModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.transparency.timeline.store', $report) }}" method="POST">
        @csrf
        <div class="modal-header">
          <h6 class="modal-title fw-bold">Tambah Timeline Penyaluran</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-medium">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-medium">Judul</label>
            <input type="text" name="judul" class="form-control" placeholder="Contoh: Distribusi Bahan Pangan" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-medium">Icon (FontAwesome class)</label>
            <input type="text" name="icon" class="form-control" placeholder="fa-truck">
          </div>
          <div class="mb-0">
            <label class="form-label small fw-medium">Deskripsi</label>
            <textarea name="deskripsi" rows="3" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn-save-status">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ===== MODAL TAMBAH DOKUMEN ===== --}}
<div class="modal fade" id="addDocModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.transparency.docs.store', $report) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h6 class="modal-title fw-bold">Tambah Dokumen</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-medium">Nama Dokumen</label>
            <input type="text" name="nama" class="form-control" placeholder="Contoh: Kuitansi Pembelian Sembako" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-medium">Nominal (Rp) — opsional</label>
            <input type="number" name="nominal" class="form-control" placeholder="0">
          </div>
          <div class="mb-3">
            <label class="form-label small fw-medium">Kode Dokumen — opsional</label>
            <input type="text" name="doc_id" class="form-control" placeholder="Contoh: DOC-001">
          </div>
          <div class="mb-0">
            <label class="form-label small fw-medium">File Dokumen (PDF/Gambar, max 5MB)</label>
            <input type="file" name="file" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn-save-status">Unggah</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.delete-form').forEach(function (form) {
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    Swal.fire({
      title: 'Hapus data ini?',
      text: 'Data yang dihapus tidak dapat dikembalikan.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#dc2626',
      cancelButtonColor: '#64748b',
      confirmButtonText: 'Ya, hapus',
      cancelButtonText: 'Batal'
    }).then(function (result) {
      if (result.isConfirmed) form.submit();
    });
  });
});
</script>
@endpush
@endsection