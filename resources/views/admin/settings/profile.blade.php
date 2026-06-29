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
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #e5e7eb;
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

<form action="{{ route('admin.settings.profile.update') }}" method="POST">
  @csrf
  @method('PUT')

  <div class="form-section">
    <h6><i class="fa-solid fa-user-circle me-2"></i>Informasi Profil</h6>
    <div class="row g-3">
      <div class="col-md-12 text-center mb-4">
        <div class="profile-avatar mx-auto mb-3 d-flex align-items-center justify-content-center bg-secondary bg-opacity-10">
          <span class="fw-bold text-secondary display-4">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
        </div>
        <small class="text-muted">Avatar dihasilkan otomatis dari nama Anda</small>
      </div>
      <div class="col-md-6">
        <label for="name" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" 
               name="name" value="{{ old('name', auth()->user()->name) }}" required>
        @error('name')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" 
               name="email" value="{{ old('email', auth()->user()->email) }}" required>
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-md-6">
        <label for="phone" class="form-label">Nomor Telepon</label>
        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" 
               name="phone" value="{{ old('phone', auth()->user()->phone) }}">
        @error('phone')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>

  <div class="form-section">
    <h6><i class="fa-solid fa-lock me-2"></i>Ubah Password (Opsional)</h6>
    <p class="text-muted small mb-3">Kosongkan jika tidak ingin mengubah password</p>
    <div class="row g-3">
      <div class="col-md-6">
        <label for="current_password" class="form-label">Password Saat Ini</label>
        <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" 
               name="current_password">
        @error('current_password')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-md-6">
        <label for="password" class="form-label">Password Baru</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" 
               name="password">
        @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-md-6">
        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
        <input type="password" class="form-control" id="password_confirmation" 
               name="password_confirmation">
      </div>
    </div>
  </div>

  <div class="d-flex gap-2 justify-content-end">
    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">Batal</a>
    <button type="submit" class="btn btn-primary">
      <i class="fa-solid fa-check me-2"></i>Simpan Perubahan
    </button>
  </div>
</form>
@endsection
