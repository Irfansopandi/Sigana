@extends('admin.layouts.app')

@section('title', 'Detail Relawan')
@section('page_title', 'Detail Relawan')

@push('styles')
<style>
  .detail-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: #94a3b8;
    margin-bottom: 4px;
  }
  .detail-value { font-size: 0.95rem; color: #1e293b; font-weight: 500; }
  .detail-row { padding: 14px 0; border-bottom: 1px solid #f1f5f9; }
  .detail-row:last-child { border-bottom: none; }
  .ktp-wrapper {
    border: 2px dashed #e2e8f0; border-radius: 12px; overflow: hidden;
    background: #f8fafc; min-height: 180px; display: flex;
    align-items: center; justify-content: center;
  }
  .ktp-wrapper img { width:100%; border-radius:10px; object-fit:cover; cursor:pointer; transition:opacity .2s; }
  .ktp-wrapper img:hover { opacity: 0.85; }
  .volunteer-avatar-lg {
    width: 64px; height: 64px; border-radius: 16px;
    background: linear-gradient(135deg, #2563eb, #60a5fa);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem; font-weight: 700; color: #fff; flex-shrink: 0;
  }
  .btn-action { border-radius: 8px; font-size: 0.85rem; padding: 6px 18px; transition: all .2s ease; }
  .btn-edit { background:#eff6ff; color:#2563eb; border:1.5px solid #bfdbfe; }
  .btn-edit:hover { background:#dbeafe; color:#1d4ed8; border-color:#93c5fd; transform:translateY(-1px); box-shadow:0 4px 12px rgba(37,99,235,0.15); }
  .btn-cancel { background:#fff7ed; color:#c2410c; border:1.5px solid #fed7aa; }
  .btn-cancel:hover { background:#ffedd5; color:#9a3412; border-color:#fdba74; transform:translateY(-1px); box-shadow:0 4px 12px rgba(234,88,12,0.12); }
  .btn-back { background:#fff; color:#64748b; border:1.5px solid #e2e8f0; }
  .btn-back:hover { background:#f8fafc; color:#334155; border-color:#cbd5e1; transform:translateY(-1px); box-shadow:0 4px 12px rgba(100,116,139,0.10); }

  .edit-input { display: none; }
  .edit-mode .view-value { display: none; }
  .edit-mode .edit-input { display: block; }

  input[type=number]::-webkit-outer-spin-button,
  input[type=number]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
  input[type=number] { -moz-appearance: textfield; }

  .btn-save {
    background: #eff6ff;
    color: #2563eb;
    border: 1.5px solid #bfdbfe;
    border-radius: 8px;
    transition: all .2s ease;
  }
  .btn-save:hover {
    background: #dbeafe;
    color: #1d4ed8;
    border-color: #93c5fd;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37,99,235,0.15);
  }
</style>
@endpush

@push('scripts')
@if(session('success'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      toast: true, position: 'top-end', icon: 'success',
      title: '{{ session("success") }}',
      showConfirmButton: false, timer: 3000, timerProgressBar: true,
      background: '#f0fdf4', color: '#166534',
    });
  });
</script>
@endif
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-user-shield text-primary me-2"></i>Detail Relawan</h5>
    <p class="text-muted small mb-0">Tinjau informasi lengkap relawan dan status verifikasi.</p>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.volunteers.index') }}" class="btn btn-sm btn-action btn-back">
      <i class="fa-solid fa-arrow-left me-2"></i>Kembali
    </a>
    <button type="button" id="btnEdit" onclick="enableEdit()"
      class="btn btn-sm btn-action btn-edit">
      <i class="fa-solid fa-pen me-2"></i>Edit
    </button>
    <button type="button" id="btnCancel" onclick="cancelEdit()"
      class="btn btn-sm btn-action btn-cancel d-none">
      <i class="fa-solid fa-xmark me-2"></i>Batal
    </button>
  </div>
</div>

<form action="{{ route('admin.volunteers.update', $user) }}" method="POST" id="editForm">
  @csrf
  @method('PUT')

  <div class="row g-4">
    {{-- Kolom Kiri --}}
    <div class="col-lg-8">
      {{-- Header Profil --}}
      <div class="card border-0 shadow-sm mb-4" style="border-radius:1rem;">
        <div class="card-body p-4">
          <div class="d-flex align-items-center gap-4">
            <div class="volunteer-avatar-lg">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            <div>
              <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
              <div class="text-muted small">{{ $user->email }}</div>
              <div class="mt-2 d-flex gap-2">
                @if($user->is_verified)
                  <span class="badge rounded-pill px-3 py-2" style="background:#dcfce7; color:#166534; font-size:0.78rem;">
                    <i class="fa-solid fa-circle-check me-1"></i>Aktif & Terverifikasi
                  </span>
                @else
                  <span class="badge rounded-pill px-3 py-2" style="background:#fef9c3; color:#854d0e; font-size:0.78rem;">
                    <i class="fa-solid fa-clock me-1"></i>Belum Diverifikasi
                  </span>
                @endif
                <span class="badge rounded-pill px-3 py-2" style="background:#eff6ff; color:#1d4ed8; font-size:0.78rem;">Relawan</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Informasi Pribadi --}}
      <div class="card border-0 shadow-sm mb-4" style="border-radius:1rem;" id="cardInfo">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
          <h6 class="fw-semibold"><i class="fa-solid fa-id-card me-2 text-primary"></i>Informasi Pribadi</h6>
        </div>
        <div class="card-body px-4 pb-4">
          <div class="row g-0">

            <div class="col-md-6">
              <div class="detail-row pe-4">
                <div class="detail-label">Nama Lengkap</div>
                <div class="view-value detail-value">{{ $user->name }}</div>
                <input type="text" name="name" class="edit-input form-control form-control-sm mt-1"
                  value="{{ $user->name }}" style="border-radius:8px;">
              </div>
            </div>

            <div class="col-md-6">
              <div class="detail-row ps-md-4">
                <div class="detail-label">NIK</div>
                <div class="view-value detail-value">{{ $user->nik ?? '-' }}</div>
                <input type="text" name="nik" class="edit-input form-control form-control-sm mt-1"
                  value="{{ $user->nik }}" style="border-radius:8px;">
              </div>
            </div>

            <div class="col-md-6">
              <div class="detail-row pe-4">
                <div class="detail-label">Email</div>
                <div class="view-value detail-value">{{ $user->email }}</div>
                <input type="email" name="email" class="edit-input form-control form-control-sm mt-1"
                  value="{{ $user->email }}" style="border-radius:8px;">
              </div>
            </div>

            <div class="col-md-6">
              <div class="detail-row ps-md-4">
                <div class="detail-label">Nomor Telepon</div>
                <div class="view-value detail-value">{{ $user->phone ?? '-' }}</div>
                <input type="number" name="phone" class="edit-input form-control form-control-sm mt-1"
                  value="{{ $user->phone }}" style="border-radius:8px;">
              </div>
            </div>

            <div class="col-md-6">
              <div class="detail-row pe-4">
                <div class="detail-label">Jenis Kelamin</div>
                <div class="view-value detail-value">
                  {{ $user->jenis_kelamin === 'L' ? 'Laki-laki' : ($user->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                </div>
                <select name="jenis_kelamin" class="edit-input form-select form-select-sm mt-1" style="border-radius:8px;">
                  <option value="">-- Pilih --</option>
                  <option value="L" {{ $user->jenis_kelamin === 'L' ? 'selected' : '' }}>Laki-laki</option>
                  <option value="P" {{ $user->jenis_kelamin === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="detail-row ps-md-4">
                <div class="detail-label">Tanggal Lahir</div>
                <div class="view-value detail-value">{{ $user->tanggal_lahir?->format('d M Y') ?? '-' }}</div>
                <input type="date" name="tanggal_lahir" class="edit-input form-control form-control-sm mt-1"
                  value="{{ $user->tanggal_lahir?->format('Y-m-d') }}" style="border-radius:8px;">
              </div>
            </div>

            <div class="col-12">
              <div class="detail-row">
                <div class="detail-label">Alamat</div>
                <div class="view-value detail-value">{{ $user->alamat ?? '-' }}</div>
                <textarea name="alamat" class="edit-input form-control form-control-sm mt-1"
                  rows="2" style="border-radius:8px;">{{ $user->alamat }}</textarea>
              </div>
            </div>

            <div class="col-12">
              <div class="detail-row">
                <div class="detail-label">Keahlian</div>
                <div class="view-value detail-value">
                  @if(!empty($user->keahlian))
                    <div class="d-flex flex-wrap gap-2 mt-1">
                      @foreach($user->keahlian as $k)
                        <span class="badge rounded-pill px-3 py-2" style="background:#eff6ff; color:#1d4ed8; font-size:0.78rem;">{{ $k }}</span>
                      @endforeach
                    </div>
                  @else
                    -
                  @endif
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="detail-row">
                <div class="detail-label">Pengalaman</div>
                <div class="view-value detail-value" style="white-space:pre-line;">{{ $user->pengalaman ?? '-' }}</div>
                <textarea name="pengalaman" class="edit-input form-control form-control-sm mt-1"
                  rows="3" style="border-radius:8px;">{{ $user->pengalaman }}</textarea>
              </div>
            </div>

          </div>

          <div id="btnSaveWrap" class="d-none mt-3">
            <button type="submit" class="btn px-4 btn-save">
              <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Perubahan
            </button>
          </div>

        </div>
      </div>
    </div>

    {{-- Kolom Kanan --}}
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm mb-4" style="border-radius:1rem;">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
          <h6 class="fw-semibold"><i class="fa-solid fa-shield-halved me-2 text-success"></i>Status Akun</h6>
        </div>
        <div class="card-body px-4 pb-4">
          <div class="detail-row">
            <div class="detail-label">Verifikasi</div>
            <div class="detail-value mt-1">
              @if($user->is_verified)
                <span class="badge rounded-pill px-3 py-2" style="background:#dcfce7; color:#166534;">
                  <i class="fa-solid fa-circle-check me-1"></i>Terverifikasi
                </span>
              @else
                <span class="badge rounded-pill px-3 py-2" style="background:#fef9c3; color:#854d0e;">
                  <i class="fa-solid fa-clock me-1"></i>Belum Diverifikasi
                </span>
              @endif
            </div>
          </div>
          <div class="detail-row">
            <div class="detail-label">Kelengkapan Profil</div>
            <div class="detail-value mt-1">
              @if($user->profile_complete)
                <span class="badge rounded-pill px-3 py-2" style="background:#dcfce7; color:#166534;">Lengkap</span>
              @else
                <span class="badge rounded-pill px-3 py-2" style="background:#fee2e2; color:#991b1b;">Belum Lengkap</span>
              @endif
            </div>
          </div>
          <div class="detail-row">
            <div class="detail-label">Tanggal Daftar</div>
            <div class="detail-value">{{ $user->created_at->format('d M Y, H:i') }}</div>
          </div>

          @if(!$user->is_verified)
          <div class="mt-4">
            @if($user->profile_complete)
              <form action="{{ route('admin.volunteers.verify', $user) }}" method="POST">
                @csrf
                <button class="btn w-100 py-2 fw-semibold"
                  style="border-radius:10px; background:linear-gradient(135deg,#059669,#34d399); color:#fff; border:none;">
                  <i class="fa-solid fa-user-check me-2"></i>Verifikasi Sekarang
                </button>
              </form>
            @else
              <button class="btn w-100 py-2 fw-semibold" disabled
                style="border-radius:10px; background:#fef9c3; color:#854d0e; border:none;">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>Data Belum Lengkap
              </button>
            @endif
          </div>
          @endif
        </div>
      </div>

      {{-- Foto KTP --}}
      <div class="card border-0 shadow-sm" style="border-radius:1rem;">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
          <h6 class="fw-semibold"><i class="fa-solid fa-id-card me-2 text-warning"></i>Foto KTP</h6>
        </div>
        <div class="card-body px-4 pb-4">
          <div class="ktp-wrapper">
            @if($user->foto_ktp)
              <a href="{{ asset('storage/' . $user->foto_ktp) }}" target="_blank">
                <img src="{{ asset('storage/' . $user->foto_ktp) }}" alt="Foto KTP {{ $user->name }}">
              </a>
            @else
              <div class="text-center text-muted py-4">
                <i class="fa-solid fa-image fa-2x mb-2 d-block opacity-30"></i>
                <span class="small">Foto KTP belum diunggah</span>
              </div>
            @endif
          </div>
          @if($user->foto_ktp)
          <a href="{{ asset('storage/' . $user->foto_ktp) }}" target="_blank"
            class="btn w-100 mt-3 btn-sm"
            style="border-radius:8px; border:1.5px solid #e2e8f0; color:#64748b; background:#fff;">
            <i class="fa-solid fa-arrow-up-right-from-square me-2"></i>Lihat Ukuran Penuh
          </a>
          @endif
        </div>
      </div>
    </div>
  </div>
</form>

@push('scripts')
<script>
  function enableEdit() {
    document.getElementById('cardInfo').classList.add('edit-mode');
    document.getElementById('btnEdit').classList.add('d-none');
    document.getElementById('btnCancel').classList.remove('d-none');
    document.getElementById('btnSaveWrap').classList.remove('d-none');
  }
  function cancelEdit() {
    document.getElementById('cardInfo').classList.remove('edit-mode');
    document.getElementById('btnEdit').classList.remove('d-none');
    document.getElementById('btnCancel').classList.add('d-none');
    document.getElementById('btnSaveWrap').classList.add('d-none');
    document.getElementById('editForm').reset();
  }
</script>
@endpush

@endsection