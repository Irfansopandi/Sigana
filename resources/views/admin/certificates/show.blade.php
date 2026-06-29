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
    <a href="{{ route('admin.certificates.show', $campaign) }}" class="btn-reset" style="text-decoration:none;">
      <i class="fa-solid fa-rotate-left" style="font-size:.8rem;"></i>
    </a>
  </form>
</div>

<div class="table-card">
  <table class="table">
    <thead>
      <tr>
        <th style="width:40px;">#</th>
        <th>RELAWAN</th>
        <th>BAGIAN TUGAS</th>
        <th>STATUS SERTIFIKAT</th>
        <th>AKSI</th>
      </tr>
    </thead>
    <tbody>
      @forelse($volunteers as $vol)
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
          @if($vol->role)
            <span class="badge" style="background:#eff6ff; color:#2563eb; font-size:.72rem;">{{ $vol->role->nama }}</span>
          @else
            <span class="text-muted small">—</span>
          @endif
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
          <div class="d-flex gap-2 align-items-center">
            @if(isset($certMap[$vol->user_id]))
              @php $cert = \App\Models\VolunteerCertificate::find($certMap[$vol->user_id]); @endphp
              <a href="{{ Storage::url($cert->getRawOriginal('file')) }}" target="_blank" class="btn-action btn-view">
                <i class="fa-solid fa-download"></i>
              </a>
              <form action="{{ route('admin.certificates.destroy', $cert->id) }}" method="POST" class="delete-form">
                @csrf @method('DELETE')
                <button type="submit" class="btn-action btn-delete">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </form>
            @else
              <button type="button" class="btn-cert"
                data-bs-toggle="modal"
                data-bs-target="#certModal{{ $vol->user_id }}">
                <i class="fa-solid fa-certificate"></i> Beri Sertifikat
              </button>
            @endif
          </div>
        </td>
      </tr>

      {{-- Modal Upload per Relawan --}}
      @if(!isset($certMap[$vol->user_id]))
      <div class="modal fade" id="certModal{{ $vol->user_id }}" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content border-0 rounded-4 shadow">
            <form action="{{ route('admin.certificates.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="user_id" value="{{ $vol->user_id }}">
              <input type="hidden" name="assignment_id" value="{{ $campaign->id }}">
              <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">
                  <i class="fa-solid fa-certificate text-warning me-2"></i>Beri Sertifikat — {{ $vol->user->name }}
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label class="form-label small fw-medium">Judul Sertifikat</label>
                  <input type="text" name="title" class="form-control"
                         value="Sertifikat Relawan {{ $campaign->title }}" required>
                </div>
                <div class="mb-3">
                  <label class="form-label small fw-medium">Tanggal Terbit</label>
                  <input type="date" name="issued_at" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="mb-3">
                  <label class="form-label small fw-medium">File Sertifikat (PDF/Gambar, max 5MB)</label>
                  <input type="file" name="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                </div>
                <div class="mb-0">
                  <label class="form-label small fw-medium">Catatan (opsional)</label>
                  <textarea name="notes" rows="2" class="form-control" placeholder="Catatan tambahan..."></textarea>
                </div>
              </div>
              <div class="modal-footer border-0">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn-cert">
                  <i class="fa-solid fa-upload"></i> Simpan
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      @endif

      @empty
      <tr>
        <td colspan="5" class="text-center py-5 text-muted">
          <i class="fa-solid fa-users fa-2x mb-2 d-block opacity-30"></i>
          Belum ada relawan yang diterima di kampanye ini.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-3">{{ $volunteers->links() }}</div>
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