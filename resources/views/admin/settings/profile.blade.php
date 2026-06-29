@extends('admin.layouts.app')

@section('title', 'Edit Profil')
@section('page_title', 'Edit Profil')

@push('styles')
<style>
  .form-section {
    background: #fff;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid #e5e7eb;
  }

  .form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
  }

  .profile-avatar {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid #38bdf8;
    box-shadow: 0 0 20px rgba(56, 189, 248, 0.3);
    background: linear-gradient(135deg, #38bdf8 0%, #0d2f52 100%);
  }

  .profile-avatar span {
    color: white;
    font-weight: 700;
    font-size: 3.5rem;
  }

  .stat-card {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    border-radius: 1rem;
    padding: 1.25rem;
    border: 1px solid #bae6fd;
  }

  .stat-card .stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #0d2f52;
  }

  .stat-card .stat-label {
    color: #64748b;
    font-size: 0.875rem;
  }

  .password-section {
    background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
    border-color: #fed7aa;
  }
</style>
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-user-pen text-primary me-2"></i>Edit Profil</h5>
    <p class="text-muted small mb-0">Perbarui informasi profil admin Anda.</p>
  </div>
  <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary btn-sm">
    <i class="fa-solid fa-arrow-left me-2"></i>Kembali</a>
</div>

<div class="row g-4 mb-4">
  <div class="col-12">
    <div class="card border-0 shadow-sm">
      <div class="card-body p-4">
        <div class="d-flex flex-column flex-md-row align-items-center gap-4">
          <div class="profile-avatar d-flex align-items-center justify-content-center flex-shrink-0">
            <span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
          </div>
          <div class="flex-grow-1 text-center text-md-start">
            <h4 class="fw-bold mb-1">{{ auth()->user()->name }}</h4>
            <p class="text-muted mb-0"><i class="fa-solid fa-envelope me-2"></i>{{ auth()->user()->email }}</p>
            <p class="text-muted mb-0"><i class="fa-solid fa-phone me-2"></i>{{ auth()->user()->phone ?? '-' }}</p>
          </div>
          <div class="d-flex gap-3">
            <div class="stat-card text-center">
              <div class="stat-value">{{ auth()->user()->created_at->diffInDays() }}</div>
              <div class="stat-label">Hari Bergabung</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<form action="{{ route('admin.settings.profile.update') }}" method="POST">
  @csrf
  @method('PUT')

  <div class="form-section">
    <h6 class="fw-bold mb-4"><i class="fa-solid fa-user-circle text-primary me-2"></i>Informasi Profil</h6>
    <div class="row g-3">
      <div class="col-md-6">
        <label for="name" class="form-label fw-medium"><i class="fa-solid fa-signature text-muted me-2"></i>Nama Lengkap</label>
        <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name" 
               name="name" value="{{ old('name', auth()->user()->name) }}" required>
        @error('name')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-md-6">
        <label for="email" class="form-label fw-medium"><i class="fa-solid fa-at text-muted me-2"></i>Email</label>
        <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" 
               name="email" value="{{ old('email', auth()->user()->email) }}" required>
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-md-6">
        <label for="phone" class="form-label fw-medium"><i class="fa-solid fa-phone text-muted me-2"></i>Nomor Telepon</label>
        <input type="tel" class="form-control form-control-lg @error('phone') is-invalid @enderror" id="phone" 
               name="phone" value="{{ old('phone', auth()->user()->phone) }}" placeholder="+62">
        @error('phone')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-md-6">
        <label for="role" class="form-label fw-medium"><i class="fa-solid fa-badge-check text-muted me-2"></i>Peran</label>
        <input type="text" class="form-control form-control-lg" id="role" 
               value="{{ ucfirst(auth()->user()->role) }}" disabled>
      </div>
    </div>
  </div>

  <div class="form-section password-section">
    <h6 class="fw-bold mb-4"><i class="fa-solid fa-lock text-orange me-2"></i>Ubah Password (Opsional)</h6>
    <div class="alert alert-warning alert-sm" role="alert">
      <i class="fa-solid fa-circle-info me-2"></i>Kosongkan semua kolom password jika tidak ingin mengubah password Anda
    </div>
    <div class="row g-3">
      <div class="col-md-4">
        <label for="current_password" class="form-label fw-medium">Password Saat Ini</label>
        <div class="input-group input-group-lg">
          <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" 
                 name="current_password">
          <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
            <i class="fa-solid fa-eye"></i>
          </button>
        </div>
        @error('current_password')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-md-4">
        <label for="password" class="form-label fw-medium">Password Baru</label>
        <div class="input-group input-group-lg">
          <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" 
                 name="password">
          <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
            <i class="fa-solid fa-eye"></i>
          </button>
        </div>
        @error('password')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-md-4">
        <label for="password_confirmation" class="form-label fw-medium">Konfirmasi Password Baru</label>
        <div class="input-group input-group-lg">
          <input type="password" class="form-control" id="password_confirmation" 
                 name="password_confirmation">
          <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
            <i class="fa-solid fa-eye"></i>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="d-flex gap-2 justify-content-end pt-2">
    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary btn-lg px-4">
      <i class="fa-solid fa-xmark me-2"></i>Batal
    </a>
    <button type="submit" class="btn btn-primary btn-lg px-4">
      <i class="fa-solid fa-check me-2"></i>Simpan Perubahan
    </button>
  </div>
</form>

@push('scripts')
<script>
function togglePassword(inputId) {
  const input = document.getElementById(inputId);
  const icon = input.nextElementSibling.querySelector('i');
  
  if (input.type === 'password') {
    input.type = 'text';
    icon.classList.remove('fa-eye');
    icon.classList.add('fa-eye-slash');
  } else {
    input.type = 'password';
    icon.classList.remove('fa-eye-slash');
    icon.classList.add('fa-eye');
  }
}
</script>
@endpush
@endsection
