@extends('user.layouts.app')

@section('title', 'Profil Saya')
@section('page_title', 'Profil Saya')

@push('styles')
<style>
.avatar-wrapper {
  position: relative;
  width: 90px;
  height: 90px;
  cursor: pointer;
}
.avatar-wrapper img,
.avatar-placeholder {
  width: 90px;
  height: 90px;
  border-radius: 16px;
  object-fit: cover;
}
.avatar-placeholder {
  background: linear-gradient(135deg, #6366f1, #3b82f6);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  font-weight: 700;
  color: #fff;
  border-radius: 16px;
}
.avatar-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.45);
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.2s;
}
.avatar-wrapper:hover .avatar-overlay {
  opacity: 1;
}
.btn-save-info {
  background-color: #38bdf8;
  color: #fff;
  border: none;
  transition: background-color 0.2s, transform 0.15s;
}
.btn-save-info:hover {
  background-color: #0ea5e9;
  color: #fff;
  transform: translateY(-1px);
}
.btn-save-info:active {
  background-color: #0284c7;
  transform: translateY(0);
}
</style>
@endpush

@section('content')

{{-- Header --}}
<div class="d-flex align-items-center gap-3 mb-1">
  <div class="rounded-3 p-2" style="background: rgba(99,102,241,0.1);">
    <i class="fa-solid fa-user fs-5" style="color:#6366f1;"></i>
  </div>
  <div>
    <h5 class="fw-bold mb-0">Profil Saya</h5>
    <p class="text-muted small mb-0">Kelola informasi akun dan keamanan Anda.</p>
  </div>
</div>
<hr class="mb-4">

{{-- @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
    <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif
@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
    <i class="fa-solid fa-circle-xmark me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif --}}

<div class="row g-4">

  {{-- Kiri: Info + Edit --}}
  <div class="col-lg-8">

    {{-- Card Info Utama --}}
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-body p-4">
        <div class="d-flex align-items-center gap-4 mb-4">
          <form id="photoForm" enctype="multipart/form-data">
            @csrf
            <div class="avatar-wrapper" onclick="document.getElementById('photoInput').click()">
              @if($user->photo)
                <img id="avatarImg" src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil"
                  style="width:90px;height:90px;border-radius:16px;object-fit:cover;">
              @else
                <div class="avatar-placeholder" id="avatarPlaceholder">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
              @endif
              <div class="avatar-overlay">
                <i class="fa-solid fa-camera text-white fs-5"></i>
              </div>
            </div>
            <input type="file" id="photoInput" name="photo" class="d-none" accept="image/*">
          </form>
          <div>
            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">{{ ucfirst($user->role) }}</span>
            <div class="text-muted small mt-1">{{ $user->email }}
            </div>
          </div>
        </div>

        {{-- Form Edit Info --}}
        <form action="{{ route('user.profile.update-info') }}" method="POST">
          @csrf @method('PUT')
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label text-uppercase small text-muted fw-semibold">Nama Lengkap</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $user->name) }}" required>
              @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label text-uppercase small text-muted fw-semibold">Email</label>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $user->email) }}" required>
              @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label text-uppercase small text-muted fw-semibold">Nomor Telepon</label>
              <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 08123456789"
                inputmode="numeric"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
              @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label text-uppercase small text-muted fw-semibold">Jenis Kelamin</label>
              <select name="jenis_kelamin" class="form-select">
                <option value="">-- Pilih --</option>
                <option value="L" {{ $user->jenis_kelamin === 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $user->jenis_kelamin === 'P' ? 'selected' : '' }}>Perempuan</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label text-uppercase small text-muted fw-semibold">Tanggal Lahir</label>
              <input type="date" name="tanggal_lahir" class="form-control"
                value="{{ old('tanggal_lahir', $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('Y-m-d') : '') }}">
            </div>
          </div>
          <div class="mt-4">
            <button type="submit" class="btn btn-save-info px-4 rounded-pill">
              <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Perubahan
            </button>
          </div>
        </form>
      </div>
    </div>

    {{-- Card Ganti Password --}}
    <div class="card border-0 shadow-sm">
      <div class="card-body p-4">
        <div class="d-flex align-items-center gap-2 mb-4">
          <div class="rounded-3 p-2" style="background: rgba(239,68,68,0.1);">
            <i class="fa-solid fa-lock fs-6" style="color:#ef4444;"></i>
          </div>
          <h6 class="fw-bold mb-0">Ganti Password</h6>
        </div>

        @php $isGoogleOnly = !is_null($user->google_id); @endphp

        @if($isGoogleOnly)
        <div class="d-flex align-items-start gap-3 p-3 rounded-3 mb-4" style="background: #fefce8; border: 1px solid #fde68a;">
          <i class="fa-brands fa-google mt-1" style="color:#d97706; font-size:1.1rem;"></i>
          <div>
            <div class="fw-semibold mb-1" style="color:#92400e;">Akun terhubung via Google</div>
            <div class="small" style="color:#a16207;">Kamu login menggunakan Google, sehingga tidak bisa mengubah kata sandi di sini. <br> Kelola keamanan akunmu melalui pengaturan Google.</div>
          </div>
        </div>
        @endif

        @if(!$isGoogleOnly)
        <form action="{{ route('user.profile.update-password') }}" method="POST">
          @csrf @method('PUT')
        @endif

          <div class="row g-3">
            <div class="col-md-12">
              <label class="form-label text-uppercase small text-muted fw-semibold">Password Lama</label>
              <input type="password" name="current_password"
                class="form-control @error('current_password') is-invalid @enderror"
                placeholder="Masukkan password saat ini"
                {{ $isGoogleOnly ? 'disabled' : '' }}>
              @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label text-uppercase small text-muted fw-semibold">Password Baru</label>
              <input type="password" name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Min. 8 karakter"
                {{ $isGoogleOnly ? 'disabled' : '' }}>
              @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label text-uppercase small text-muted fw-semibold">Konfirmasi Password</label>
              <input type="password" name="password_confirmation" class="form-control"
                placeholder="Ulangi password baru"
                {{ $isGoogleOnly ? 'disabled' : '' }}>
            </div>
          </div>
          <div class="mt-4">
            <button type="{{ $isGoogleOnly ? 'button' : 'submit' }}"
              class="btn {{ $isGoogleOnly ? 'btn-secondary' : 'btn-danger' }} px-4 rounded-pill"
              {{ $isGoogleOnly ? 'disabled' : '' }}>
              <i class="fa-solid fa-key me-2"></i>Ganti Password
            </button>
          </div>

        @if(!$isGoogleOnly)
        </form>
        @endif

      </div>
    </div>

  </div>

  {{-- Kanan: Status --}}
  <div class="col-lg-4">
    <div class="card border-0 shadow-sm">
      <div class="card-body p-4">
        <div class="d-flex align-items-center gap-2 mb-4">
          <div class="rounded-3 p-2" style="background: rgba(34,197,94,0.1);">
            <i class="fa-solid fa-shield-halved fs-6" style="color:#22c55e;"></i>
          </div>
          <h6 class="fw-bold mb-0">Status Akun</h6>
        </div>

        <div class="mb-3">
          <div class="text-uppercase small text-muted fw-semibold mb-1">Role</div>
          <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">{{ ucfirst($user->role) }}</span>
        </div>

        <div class="mb-3">
          <div class="text-uppercase small text-muted fw-semibold mb-1">Google Login</div>
          @if($user->google_id)
            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
              <i class="fa-brands fa-google me-1"></i>Terhubung
            </span>
          @else
            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2">Tidak Terhubung</span>
          @endif
        </div>

        <div class="mb-3">
          <div class="text-uppercase small text-muted fw-semibold mb-1">Terdaftar Sejak</div>
          <div class="fw-medium">{{ $user->created_at->translatedFormat('d M Y') }}</div>
        </div>

        <div>
          <div class="text-uppercase small text-muted fw-semibold mb-1">Login Terakhir</div>
          <div class="fw-medium">{{ $user->updated_at->translatedFormat('d M Y, H:i') }}</div>
        </div>
      </div>
    </div>
  </div>

</div>

@push('scripts')
<script>
document.getElementById('photoInput').addEventListener('change', function () {
  const file = this.files[0];
  if (!file) return;

  const formData = new FormData();
  formData.append('photo', file);
  formData.append('_method', 'PUT');
  formData.append('_token', '{{ csrf_token() }}');

  fetch('{{ route("user.profile.update-photo") }}', {
    method: 'POST',
    body: formData,
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      // Update avatar langsung
      const img = document.getElementById('avatarImg');
      if (img) {
        img.src = data.url;
      } else {
        const placeholder = document.getElementById('avatarPlaceholder');
        placeholder.outerHTML = `<img id="avatarImg" src="${data.url}" style="width:90px;height:90px;border-radius:16px;object-fit:cover;">`;
      }
      Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: data.message, showConfirmButton: false, timer: 3000, timerProgressBar: true });
    }
  })
  .catch(() => {
    Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: 'Gagal mengunggah foto.', showConfirmButton: false, timer: 3000 });
  });
});
</script>

@if(session('success'))
<script>
  Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: '{{ session("success") }}',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    background: '#16a34a',
    color: '#fff',
    iconColor: '#fff',
  });
</script>
@endif

@if(session('error'))
<script>
  Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'error',
    title: '{{ session("error") }}',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
  });
</script>
@endif
@endpush

@endsection