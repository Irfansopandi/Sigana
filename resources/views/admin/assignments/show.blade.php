@extends('admin.layouts.app')

@section('title', 'Detail Penugasan — ' . $campaign->title)
@section('page_title', 'Detail Penugasan')

@push('styles')
<style>
  .detail-card {
    background: #fff; border-radius: 16px;
    border: 1px solid #e5e7eb; padding: 1.5rem; margin-bottom: 1.5rem;
  }
  .detail-card h5 { font-size: 1.05rem; font-weight: 700; margin-bottom: 1rem; }

  .btn-back {
    background: #fff; color: #475569; border: 1.5px solid #e2e8f0;
    border-radius: 999px; padding: 6px 16px; font-size: 0.85rem; font-weight: 500;
    display: inline-flex; align-items: center; transition: all .2s; text-decoration: none;
  }
  .btn-back:hover { background: #f8fafc; color: #1e293b; border-color: #cbd5e1; }

  .btn-save { background: #eff6ff; color: #2563eb; border: 1.5px solid #bfdbfe;
    border-radius: 8px; padding: 8px 18px; font-size: 0.85rem; font-weight: 500;
    transition: all .2s; display: inline-flex; align-items: center; }
  .btn-save:hover { background: #dbeafe; color: #1d4ed8; border-color: #93c5fd; }

  .btn-add-dashed { width: 100%; border: 1.5px dashed #cbd5e1; border-radius: 12px;
    background: #fff; color: #64748b; padding: .65rem; font-size: .85rem;
    font-weight: 500; transition: all .2s; }
  .btn-add-dashed:hover { border-color: #94a3b8; background: #f8fafc; color: #334155; }

  .role-item {
    display: flex; justify-content: space-between; align-items: center;
    padding: .75rem 1rem; border: 1px solid #e5e7eb; border-radius: 12px;
    margin-bottom: .5rem; background: #f8fafc;
  }

  .volunteer-item {
    background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
    padding: 1rem; margin-bottom: .75rem;
  }

  .volunteer-avatar {
    width: 38px; height: 38px; border-radius: 50%;
    background: #eff6ff; color: #2563eb;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: .9rem; flex-shrink: 0; overflow: hidden;
  }

  .badge-menunggu { background:#fffbeb; color:#d97706; border: 1px solid #fde68a; }
  .badge-diterima { background:#ecfdf5; color:#059669; border: 1px solid #a7f3d0; }
  .badge-ditolak  { background:#fef2f2; color:#dc2626; border: 1px solid #fecaca; }

  .badge-koordinator { background:#fef9c3; color:#854d0e; border: 1px solid #fde047; }

  .btn-koordinator { background:#fefce8; color:#854d0e; border: 1.5px solid #fde047;
    border-radius: 8px; padding: 5px 12px; font-size: .78rem; font-weight: 500;
    transition: all .2s; display: inline-flex; align-items: center; }
  .btn-koordinator:hover { background:#fef9c3; border-color:#facc15; }

  .btn-lepas-koordinator { background:#fff; color:#64748b; border: 1.5px solid #e2e8f0;
    border-radius: 8px; padding: 5px 12px; font-size: .78rem; font-weight: 500;
    transition: all .2s; display: inline-flex; align-items: center; }
  .btn-lepas-koordinator:hover { background:#f8fafc; color:#475569; border-color:#cbd5e1; }

  .btn-icon-sm {
    width: 30px; height: 30px; border-radius: 7px; display: flex;
    align-items: center; justify-content: center; border: 1.5px solid;
    transition: all .2s; font-size: 0.75rem; cursor: pointer;
  }
  .btn-icon-delete { background:#fef2f2; color:#dc2626; border-color:#fecaca; }
  .btn-icon-delete:hover { background:#fee2e2; border-color:#fca5a5; }

  .doc-btn {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: .75rem; font-weight: 500;
    padding: 6px 12px; border-radius: 8px;
    background: #fff; border: 1.5px solid #cbd5e1; color: #475569;
    text-decoration: none; transition: all .2s;
  }
  .doc-btn:hover {
    background: #eff6ff; border-color: #93c5fd; color: #1d4ed8;
    box-shadow: 0 2px 8px rgba(37,99,235,.12);
  }
  .doc-btn i { transition: transform .2s; }
  .doc-btn:hover i { transform: translateY(1px); }
</style>
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-list-check text-success me-2"></i>{{ $campaign->title }}</h5>
    <p class="text-muted small mb-0"><i class="fa-solid fa-location-dot me-1"></i>{{ $campaign->location }}</p>
  </div>
  <a href="{{ route('admin.assignments.index') }}" class="btn-back">
    <i class="fa-solid fa-arrow-left me-2"></i>Kembali
  </a>
</div>

@if(session('success'))
<div class="alert alert-success rounded-3 mb-4">{{ session('success') }}</div>
@endif

<div class="row g-4">

  {{-- KIRI: Bagian Tugas --}}
  <div class="col-lg-4">
    <div class="detail-card">
      <h5><i class="fa-solid fa-sitemap text-primary me-2"></i>Bagian Tugas</h5>

      @forelse($campaign->roles as $role)
      <div class="role-item">
        <div>
          <div class="fw-semibold" style="font-size:.88rem;">{{ $role->nama }}</div>
          @if($role->deskripsi)
            <div class="text-muted" style="font-size:.75rem;">{{ $role->deskripsi }}</div>
          @endif
          <div class="text-muted" style="font-size:.72rem;">
            Kuota: {{ $role->kuota == 0 ? 'Tidak terbatas' : $role->kuota . ' orang' }}
          </div>
        </div>
        <form action="{{ route('admin.assignments.roles.destroy', $role) }}" method="POST" class="delete-form">
          @csrf
          <button type="submit" class="btn-icon-sm btn-icon-delete">
            <i class="fa-solid fa-trash"></i>
          </button>
        </form>
      </div>
      @empty
      <p class="text-muted small text-center py-2">Belum ada bagian tugas.</p>
      @endforelse

      <button type="button" class="btn-add-dashed mt-2" data-bs-toggle="modal" data-bs-target="#addRoleModal">
        <i class="fa-solid fa-plus me-2"></i>Tambah Bagian Tugas
      </button>
    </div>
  </div>

  {{-- KANAN: Pendaftar Relawan --}}
  <div class="col-lg-8">
    <div class="detail-card">
      <h5><i class="fa-solid fa-users text-success me-2"></i>Pendaftar Relawan
        <span class="badge bg-light text-muted border ms-2" style="font-size:.75rem;">{{ $campaign->volunteers()->count() }}</span>
      </h5>

      @php
      $filterTab = request('tab', 'semua');
      $tabs = [
          'semua' => 'Semua',
          'menunggu' => 'Menunggu',
          'diterima' => 'Diterima',
          'ditolak' => 'Ditolak',
          'koordinator' => 'Calon Koordinator'
      ];
      @endphp

      <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="small text-muted">
          @if($filterTab === 'koordinator')
            {{ $campaign->volunteers()->where('minat_koordinator', true)->count() }} calon koordinator ditemukan
          @elseif($filterTab === 'semua')
            {{ $campaign->volunteers()->count() }} relawan ditemukan
          @else
            {{ $campaign->volunteers()->where('verifikasi', $filterTab)->count() }} relawan ditemukan
          @endif
        </span>
        <div class="d-flex align-items-center gap-2">
          <span class="small text-muted">Tampil</span>
          <select class="form-select form-select-sm" style="width:80px;"
                  onchange="window.location.href='{{ route('admin.assignments.show', $campaign) }}?tab={{ $filterTab }}&per_page='+this.value">
          @foreach([5, 10, 25, 50] as $size)
            <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
            {{ $size }}
            </option>
          @endforeach
          </select>
          <span class="small text-muted">baris</span>
        </div>
      </div>

      <div class="d-flex gap-2 mb-4 flex-wrap">
        @foreach($tabs as $val => $label)
          <a href="{{ route('admin.assignments.show', [$campaign, 'tab' => $val]) }}"
             class="btn btn-sm"
             style="border-radius:8px; font-size:0.8rem; padding:5px 14px;
               {{ $filterTab === $val
                 ? 'background:#eff6ff; color:#2563eb; border:1.5px solid #bfdbfe; font-weight:600;'
                 : 'background:#fff; color:#64748b; border:1.5px solid #e2e8f0;' }}">
            {{ $label }}
            <span class="ms-1 badge rounded-pill"
              style="font-size:.65rem; {{ $filterTab === $val ? 'background:#2563eb; color:#fff;' : 'background:#f1f5f9; color:#64748b;' }}">
              @if($val === 'semua')
                {{ $campaign->volunteers()->count() }}
              @elseif($val === 'koordinator')
                {{ $campaign->volunteers()->where('minat_koordinator', true)->count() }}
              @else
                {{ $campaign->volunteers()->where('verifikasi', $val)->count() }}
              @endif
            </span>
          </a>
        @endforeach
      </div>

      @forelse($volunteers as $vol)
      <div class="volunteer-item">
        <div class="d-flex align-items-start gap-3">
          <div class="volunteer-avatar">
            @if($vol->user->photo)
              <img src="{{ Storage::url($vol->user->photo) }}" style="width:100%;height:100%;object-fit:cover;">
            @else
              {{ strtoupper(substr($vol->user->name, 0, 1)) }}
            @endif
          </div>
          <div class="flex-grow-1">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <div class="fw-semibold text-dark" style="font-size:.9rem;">
                  {{ $vol->user->name }}
                  @if($vol->is_coordinator)
                    <span class="badge rounded-pill badge-koordinator ms-1" style="font-size:.65rem;">
                      <i class="fa-solid fa-star me-1"></i>Koordinator
                    </span>
                  @endif
                </div>
                <div class="text-muted" style="font-size:.75rem;">{{ $vol->user->email }}</div>
                @if($vol->role)
                  <span class="badge bg-light text-primary border border-primary-subtle mt-1" style="font-size:.7rem;">
                    <i class="fa-solid fa-tag me-1"></i>{{ $vol->role->nama }}
                  </span>
                @endif
              </div>
              <span class="badge rounded-pill px-2 py-1 badge-{{ $vol->verifikasi }}" style="font-size:.7rem;">
                {{ ucfirst($vol->verifikasi) }}
              </span>
            </div>

            @if($vol->alasan)
              <div class="mt-2 p-2 bg-light rounded-2" style="font-size:.78rem; color:#475569;">
                <strong>Alasan:</strong> {{ $vol->alasan }}
              </div>
            @endif
            @if($vol->pengalaman)
              <div class="mt-1 p-2 bg-light rounded-2" style="font-size:.78rem; color:#475569;">
                <strong>Pengalaman:</strong> {{ $vol->pengalaman }}
              </div>
            @endif
            @if($vol->catatan_admin)
              <div class="mt-1 p-2 rounded-2" style="font-size:.78rem; background:#fff7ed; color:#92400e;">
                <strong>Catatan Admin:</strong> {{ $vol->catatan_admin }}
              </div>
            @endif

            {{-- Informasi Data Diri Lengkap & Dokumen Pendukung --}}
            <div class="row g-2 mt-2 pt-2 border-top border-light" style="font-size: .8rem;">
              <div class="col-sm-6">
                <span class="text-muted d-block small" style="font-size: 0.72rem;">No. Telepon</span>
                <span class="text-dark fw-semibold"><i class="fa-solid fa-phone text-muted me-1"></i>{{ $vol->user->phone ?? '-' }}</span>
              </div>
              <div class="col-sm-6">
                <span class="text-muted d-block small" style="font-size: 0.72rem;">Jenis Kelamin</span>
                <span class="text-dark fw-semibold">
                  <i class="fa-solid fa-venus-mars text-muted me-1"></i>
                  @if($vol->user->jenis_kelamin === 'L' || $vol->user->jenis_kelamin === 'laki-laki' || $vol->user->jenis_kelamin === 'Laki-laki')
                    Laki-laki
                  @elseif($vol->user->jenis_kelamin === 'P' || $vol->user->jenis_kelamin === 'perempuan' || $vol->user->jenis_kelamin === 'Perempuan')
                    Perempuan
                  @else
                    -
                  @endif
                </span>
              </div>
              <div class="col-sm-6">
                <span class="text-muted d-block small" style="font-size: 0.72rem;">Tanggal Lahir / Usia</span>
                <span class="text-dark fw-semibold">
                  <i class="fa-solid fa-cake-candles text-muted me-1"></i>
                  @if($vol->user->tanggal_lahir)
                    {{ \Carbon\Carbon::parse($vol->user->tanggal_lahir)->translatedFormat('d M Y') }} ({{ \Carbon\Carbon::parse($vol->user->tanggal_lahir)->age }} tahun)
                  @else
                    -
                  @endif
                </span>
              </div>
              @if($vol->minat_koordinator)
              <div class="col-sm-6">
                <span class="text-muted d-block small" style="font-size: 0.72rem;">Minat Koordinator</span>
                <span class="text-dark fw-semibold">
                  <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-2 py-1" style="font-size:.7rem;">
                    <i class="fa-solid fa-user-shield me-1"></i>Minat Koordinator
                  </span>
                </span>
              </div>
              @endif
            </div>

            {{-- Dokumen Pendukung Koordinator --}}
            @if($vol->minat_koordinator && ($vol->dokumen_1 || $vol->dokumen_2 || $vol->dokumen_3))
              <div class="mt-3 p-2 rounded-3 border bg-light bg-opacity-50" style="font-size: .8rem;">
                <div class="fw-semibold text-dark mb-1" style="font-size: 0.78rem;">
                  <i class="fa-solid fa-file-pdf text-danger me-1"></i>Dokumen Pendukung Koordinator:
                </div>
                <div class="d-flex gap-2 flex-wrap">
                  @if($vol->dokumen_1)
                    <a href="{{ Storage::url($vol->dokumen_1) }}" target="_blank" class="doc-btn">
                      <i class="fa-solid fa-download text-primary"></i>Dokumen 1
                    </a>
                  @endif
                  @if($vol->dokumen_2)
                    <a href="{{ Storage::url($vol->dokumen_2) }}" target="_blank" class="doc-btn">
                      <i class="fa-solid fa-download text-primary"></i>Dokumen 2
                    </a>
                  @endif
                  @if($vol->dokumen_3)
                    <a href="{{ Storage::url($vol->dokumen_3) }}" target="_blank" class="doc-btn">
                      <i class="fa-solid fa-download text-primary"></i>Dokumen 3
                    </a>
                  @endif
                </div>
              </div>
            @endif

            <div class="mt-3 d-flex gap-2 flex-wrap">
              @if($vol->verifikasi === 'menunggu')
              {{-- Tombol Terima --}}
              <form action="{{ route('admin.assignments.verifikasi', $vol) }}" method="POST" class="d-inline terima-relawan-form">
                @csrf
                <input type="hidden" name="verifikasi" value="diterima">
                <button type="submit" class="btn btn-sm btn-success rounded-3 btn-terima-relawan" style="font-size:.78rem; padding: 6px 14px;">
                  <i class="fa-solid fa-check me-1"></i>Terima
                </button>
              </form>

              {{-- Tombol Tolak --}}
              <button type="button" class="btn btn-sm btn-danger rounded-3" style="font-size:.78rem; padding: 6px 14px;"
                data-bs-toggle="modal" data-bs-target="#tolakModal{{ $vol->id }}">
                <i class="fa-solid fa-xmark me-1"></i>Tolak
              </button>
              @endif

              @if($vol->verifikasi === 'diterima' && !$vol->is_coordinator && $vol->minat_koordinator)
              <form action="{{ route('admin.assignments.set-coordinator', $vol) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-koordinator">
                  <i class="fa-solid fa-star me-1"></i>Jadikan Koordinator
                </button>
              </form>
              @endif

              @if($vol->is_coordinator)
              <form action="{{ route('admin.assignments.unset-coordinator', $vol) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-lepas-koordinator">
                  <i class="fa-solid fa-star-half-stroke me-1"></i>Lepas Koordinator
                </button>
              </form>
              @endif
            </div>
          </div>
        </div>
      </div>

      {{-- Modal Tolak --}}
      <div class="modal fade" id="tolakModal{{ $vol->id }}" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content border-0 rounded-4 shadow">
            <form action="{{ route('admin.assignments.verifikasi', $vol) }}" method="POST">
              @csrf
              <input type="hidden" name="verifikasi" value="ditolak">
              <div class="modal-header border-0">
                <h6 class="modal-title fw-bold text-danger"><i class="fa-solid fa-circle-xmark me-2"></i>Tolak Pendaftaran: {{ $vol->user->name }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="mb-0">
                  <label class="form-label small fw-medium">Alasan Penolakan / Catatan Admin <span class="text-danger">*</span></label>
                  <textarea name="catatan_admin" rows="3" class="form-control" required
                    placeholder="Tulis alasan mengapa pendaftaran ini ditolak..."></textarea>
                </div>
              </div>
              <div class="modal-footer border-0">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger btn-sm rounded-3">Ya, Tolak Pendaftaran</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      @empty
      <div class="text-center py-4 text-muted">
        <i class="fa-solid fa-users fa-2x mb-2 d-block opacity-25"></i>
        Belum ada relawan yang mendaftar.
      </div>
      @endforelse

      <div class="mt-3">
        {{ $volunteers->links() }}
      </div>
    </div>
  </div>

</div>

{{-- Modal Tambah Bagian Tugas --}}
<div class="modal fade" id="addRoleModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border-0 rounded-4 shadow">
      <form action="{{ route('admin.assignments.roles.store', $campaign) }}" method="POST">
        @csrf
        <div class="modal-header border-0">
          <h6 class="modal-title fw-bold"><i class="fa-solid fa-sitemap text-primary me-2"></i>Tambah Bagian Tugas</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label small fw-medium">Nama Bagian Tugas</label>
            <input type="text" name="nama" class="form-control"
                   placeholder="Contoh: Tim Logistik, Tim Medis" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-medium">Deskripsi (opsional)</label>
            <textarea name="deskripsi" rows="2" class="form-control"
                      placeholder="Deskripsi tugas..."></textarea>
          </div>
          <div class="mb-0">
            <label class="form-label small fw-medium">Kuota (0 = tidak terbatas)</label>
            <input type="number" name="kuota" class="form-control" value="0" min="0">
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn-save">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.delete-form').forEach(function(form) {
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Hapus bagian tugas ini?',
      text: 'Data yang dihapus tidak dapat dikembalikan.',
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

document.querySelectorAll('.terima-relawan-form').forEach(function(form) {
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Terima Relawan ini?',
      text: 'Relawan akan terdaftar aktif dalam kampanye bencana ini.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#22c55e',
      cancelButtonColor: '#64748b',
      confirmButtonText: 'Ya, Terima',
      cancelButtonText: 'Batal'
    }).then(function(result) {
      if (result.isConfirmed) form.submit();
    });
  });
});
</script>
@endpush