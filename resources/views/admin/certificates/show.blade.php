@extends('admin.layouts.app')
@section('title', 'Sertifikat — ' . $campaign->title)
@section('page_title', 'Kelola Sertifikat')

@push('styles')
<style>
  .table-card { background:#fff; border:1px solid #e5e7eb; border-radius:14px; overflow:hidden; }
  .table-card table { margin:0; }
  .table-card thead th { background:#f8fafc; border-bottom:1px solid #e5e7eb; font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; color:#64748b; padding:.85rem 1.25rem; }
  .table-card tbody td { padding:.9rem 1.25rem; vertical-align:middle; border-bottom:1px solid #f1f5f9 !important; font-size:.875rem; }
  .table-card tbody tr:last-child td { border-bottom:none !important; }
  .table-card tbody tr { transition:background .15s; }
  .table-card tbody tr:hover td { background:#f0f7ff !important; }

  .volunteer-avatar { width:36px; height:36px; border-radius:50%; background:#eff6ff; color:#2563eb; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:.85rem; flex-shrink:0; overflow:hidden; }

  .btn-back { background:#fff; color:#475569; border:1.5px solid #e2e8f0; border-radius:999px; padding:6px 16px; font-size:.85rem; font-weight:500; display:inline-flex; align-items:center; text-decoration:none; transition:all .2s; }
  .btn-back:hover { background:#f8fafc; color:#1e293b; }

  .btn-cert { background:#2563eb; color:#fff; border:none; border-radius:8px; padding:5px 14px; font-size:.8rem; font-weight:500; display:inline-flex; align-items:center; gap:5px; transition:all .2s; cursor:pointer; }
  .btn-cert:hover { background:#1d4ed8; color:#fff; }

  .btn-action { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; border:1.5px solid; transition:all .2s; font-size:.8rem; text-decoration:none; }
  .btn-view { background:#eff6ff; color:#2563eb; border-color:#bfdbfe; }
  .btn-view:hover { background:#dbeafe; border-color:#93c5fd; color:#1d4ed8; }
  .btn-delete { background:#fef2f2; color:#dc2626; border-color:#fecaca; }
  .btn-delete:hover { background:#fee2e2; border-color:#fca5a5; }

  /* Section grup tugas */
  .group-section { margin-bottom: 1.75rem; }
  .group-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:.6rem; padding:0 .25rem; }
  .group-title { font-size:.95rem; font-weight:700; color:#1e293b; display:flex; align-items:center; gap:8px; }
  .group-count { background:#eef2ff; color:#4f46e5; font-size:.72rem; font-weight:700; padding:2px 9px; border-radius:999px; }

  /* Section koordinator */
  .coordinator-card { background:linear-gradient(135deg,#fffbeb,#fff); border:1.5px solid #fde68a; border-radius:14px; padding:1rem 1.25rem; margin-bottom:1.75rem; display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; }
  .coordinator-badge { background:#f59e0b; color:#fff; font-size:.68rem; font-weight:700; padding:3px 10px; border-radius:999px; text-transform:uppercase; letter-spacing:.04em; }
  .coordinator-avatar { width:44px; height:44px; border-radius:50%; background:#fde68a; color:#92400e; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1rem; flex-shrink:0; overflow:hidden; }
</style>
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-certificate text-warning me-2"></i>{{ $campaign->title }}</h5>
    <p class="text-muted small mb-0"><i class="fa-solid fa-location-dot me-1"></i>{{ $campaign->location }}</p>
  </div>
  <a href="{{ route('admin.certificates.index') }}" class="btn-back">
    <i class="fa-solid fa-arrow-left me-2"></i>Kembali
  </a>
</div>

@if(session('success'))
<div class="alert alert-success rounded-3 mb-4">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger rounded-3 mb-4">{{ session('error') }}</div>
@endif

<div class="filter-bar mb-4">
  <form method="GET" class="d-flex gap-2 align-items-center flex-wrap w-100">
    <div class="position-relative flex-grow-1" style="max-width:340px;">
      <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="left:10px;top:50%;transform:translateY(-50%);font-size:.8rem;"></i>
      <input type="text" name="search" class="form-control ps-4"
             style="height:36px;border-radius:8px;border:1.5px solid #e2e8f0;font-size:.85rem;"
             placeholder="Cari nama relawan..." value="{{ request('search') }}">
    </div>
    <button type="submit" class="btn btn-sm btn-primary rounded-3 px-3" style="height:36px;font-size:.85rem;">Cari</button>
    <a href="{{ route('admin.certificates.show', $campaign) }}" class="btn-reset" style="text-decoration:none;">
      <i class="fa-solid fa-rotate-left" style="font-size:.8rem;"></i>
    </a>
  </form>
</div>

{{-- ═══════════════ KOORDINATOR ═══════════════ --}}
@if($coordinator)
<div class="coordinator-card">
  <div class="d-flex align-items-center gap-3">
    <div class="coordinator-avatar">
      @if($coordinator->user->photo)
        <img src="{{ Storage::url($coordinator->user->photo) }}" style="width:100%;height:100%;object-fit:cover;">
      @else
        {{ strtoupper(substr($coordinator->user->name, 0, 1)) }}
      @endif
    </div>
    <div>
      <span class="coordinator-badge mb-1 d-inline-block"><i class="fa-solid fa-star me-1"></i>Koordinator</span>
      <div class="fw-semibold text-dark">{{ $coordinator->user->name }}</div>
      <div class="text-muted small">{{ $coordinator->user->email }}</div>
    </div>
  </div>

  <div class="d-flex gap-2 align-items-center">
    @if(isset($certMap[$coordinator->user_id]))
      @php $cert = \App\Models\VolunteerCertificate::find($certMap[$coordinator->user_id]); @endphp
      <span class="badge rounded-pill px-3 py-1" style="background:#dcfce7; color:#16a34a; font-size:.72rem;">
        <i class="fa-solid fa-circle-check me-1"></i>Sudah Diberikan
      </span>
      <a href="{{ Storage::url($cert->getRawOriginal('file')) }}" target="_blank" class="btn-action btn-view">
        <i class="fa-solid fa-download"></i>
      </a>
      <form action="{{ route('admin.certificates.destroy', $cert->id) }}" method="POST" class="delete-form">
        @csrf @method('DELETE')
        <button type="submit" class="btn-action btn-delete"><i class="fa-solid fa-trash"></i></button>
      </form>
    @else
      <button type="button" class="btn-cert" data-bs-toggle="modal" data-bs-target="#certModal-coordinator">
        <i class="fa-solid fa-certificate"></i> Beri Sertifikat
      </button>
    @endif
  </div>
</div>

@if(!isset($certMap[$coordinator->user_id]))
<div class="modal fade" id="certModal-coordinator" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border-0 rounded-4 shadow">
      <form action="{{ route('admin.certificates.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="assignment_id" value="{{ $campaign->id }}">
        <div class="modal-header border-0">
          <h6 class="modal-title fw-bold"><i class="fa-solid fa-certificate text-warning me-2"></i>Beri Sertifikat — Koordinator</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-medium">Judul Sertifikat</label>
            <input type="text" name="title" class="form-control" value="Sertifikat Koordinator {{ $campaign->title }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-medium">Tanggal Terbit</label>
            <input type="date" name="issued_at" class="form-control" value="{{ date('Y-m-d') }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-medium">File Sertifikat (PDF/Gambar, max 5MB)</label>
            <input type="file" name="files[{{ $coordinator->user_id }}]" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
          </div>
          <div class="mb-0">
            <label class="form-label small fw-medium">Catatan (opsional)</label>
            <textarea name="notes" rows="2" class="form-control" placeholder="Catatan tambahan..."></textarea>
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn-cert"><i class="fa-solid fa-upload"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endif
@endif

{{-- ═══════════════ GRUP TUGAS ═══════════════ --}}
@forelse($grouped as $groupName => $members)
@php
  $groupSlug = \Illuminate\Support\Str::slug($groupName);
  $belumAda = $members->filter(fn($cv) => !isset($certMap[$cv->user_id]))->count();
@endphp
<div class="group-section">
  <div class="group-header">
    <div class="group-title">
      <i class="fa-solid fa-layer-group text-primary"></i>
      {{ $groupName }}
      <span class="group-count">{{ $members->count() }} relawan</span>
    </div>

    @if($belumAda > 0)
      <button type="button" class="btn-cert" data-bs-toggle="modal" data-bs-target="#groupCertModal{{ $groupSlug }}">
        <i class="fa-solid fa-certificate"></i> Beri Sertifikat ke Grup Ini
      </button>
    @else
      <span class="badge rounded-pill px-3 py-1" style="background:#dcfce7; color:#16a34a; font-size:.72rem;">
        <i class="fa-solid fa-circle-check me-1"></i>Semua Sudah Diberikan
      </span>
    @endif
  </div>

  <div class="table-card">
    <table class="table">
      <thead>
        <tr>
          <th style="width:40px;">#</th>
          <th>RELAWAN</th>
          <th>STATUS SERTIFIKAT</th>
          <th>AKSI</th>
        </tr>
      </thead>
      <tbody>
        @foreach($members as $vol)
        <tr>
          <td class="text-muted" style="font-size:.78rem; font-weight:600;">{{ $loop->iteration }}</td>
          <td>
            <div class="d-flex align-items-center gap-2">
              <div class="volunteer-avatar">
                @if($vol->user->photo)
                  <img src="{{ Storage::url($vol->user->photo) }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                  {{ strtoupper(substr($vol->user->name, 0, 1)) }}
                @endif
              </div>
              <div>
                <div class="fw-semibold text-dark" style="font-size:.88rem;">{{ $vol->user->name }}</div>
                <div class="text-muted" style="font-size:.73rem;">{{ $vol->user->email }}</div>
              </div>
            </div>
          </td>
          <td>
            @if(isset($certMap[$vol->user_id]))
              <span class="badge rounded-pill px-3 py-1" style="background:#dcfce7; color:#16a34a; font-size:.72rem;">
                <i class="fa-solid fa-circle-check me-1"></i>Sudah Diberikan
              </span>
            @else
              <span class="badge rounded-pill px-3 py-1" style="background:#f1f5f9; color:#64748b; font-size:.72rem;">
                <i class="fa-solid fa-clock me-1"></i>Belum Ada
              </span>
            @endif
          </td>
          <td>
            @if(isset($certMap[$vol->user_id]))
              @php $cert = \App\Models\VolunteerCertificate::find($certMap[$vol->user_id]); @endphp
              <div class="d-flex gap-2">
                <a href="{{ Storage::url($cert->getRawOriginal('file')) }}" target="_blank" class="btn-action btn-view">
                  <i class="fa-solid fa-download"></i>
                </a>
                <form action="{{ route('admin.certificates.destroy', $cert->id) }}" method="POST" class="delete-form">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-action btn-delete"><i class="fa-solid fa-trash"></i></button>
                </form>
              </div>
            @else
              <span class="text-muted small">Menunggu grup di-proses</span>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

{{-- Modal upload bulk per grup — file terpisah per relawan --}}
@if($belumAda > 0)
<div class="modal fade" id="groupCertModal{{ $groupSlug }}" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 rounded-4 shadow">
      <form action="{{ route('admin.certificates.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="assignment_id" value="{{ $campaign->id }}">
        <div class="modal-header border-0">
          <h6 class="modal-title fw-bold">
            <i class="fa-solid fa-certificate text-warning me-2"></i>Beri Sertifikat — {{ $groupName }}
          </h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-info py-2 px-3 small mb-3">
            Setiap relawan punya PDF sertifikatnya sendiri-sendiri. Isi file untuk relawan yang sudah siap, biarkan kosong untuk yang belum — bisa di-upload susulan nanti.
          </div>

          <div class="mb-3">
            <label class="form-label small fw-medium">Judul Sertifikat</label>
            <input type="text" name="title" class="form-control" value="Sertifikat Relawan {{ $groupName }} — {{ $campaign->title }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-medium">Tanggal Terbit</label>
            <input type="date" name="issued_at" class="form-control" value="{{ date('Y-m-d') }}" required>
          </div>

          <hr class="my-3">

          <div class="d-flex flex-column gap-2">
            @foreach($members as $cv)
              @if(!isset($certMap[$cv->user_id]))
              <div class="d-flex align-items-center gap-2">
                <div class="volunteer-avatar" style="width:32px;height:32px;font-size:.75rem;">
                  {{ strtoupper(substr($cv->user->name, 0, 1)) }}
                </div>
                <div style="min-width:140px;" class="small fw-semibold text-dark">{{ $cv->user->name }}</div>
                <input type="file" name="files[{{ $cv->user_id }}]" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png">
              </div>
              @endif
            @endforeach
          </div>

          <div class="mt-3 mb-0">
            <label class="form-label small fw-medium">Catatan (opsional)</label>
            <textarea name="notes" rows="2" class="form-control" placeholder="Catatan tambahan..."></textarea>
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn-cert"><i class="fa-solid fa-upload"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endif

@empty
@if(!$coordinator)
<div class="table-card">
  <div class="text-center py-5 text-muted">
    <i class="fa-solid fa-users fa-2x mb-2 d-block opacity-30"></i>
    Belum ada relawan yang diterima di kampanye ini.
  </div>
</div>
@endif
@endforelse
@endsection

@push('scripts')
<script>
document.querySelectorAll('.delete-form').forEach(function(form) {
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Hapus sertifikat ini?',
      text: 'File sertifikat akan dihapus permanen.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#dc2626',
      cancelButtonColor: '#64748b',
      confirmButtonText: 'Ya, hapus',
      cancelButtonText: 'Batal'
    }).then(function(result) {
      if (result.isConfirmed) form.submit();
    });
  });
});
</script>
@endpush