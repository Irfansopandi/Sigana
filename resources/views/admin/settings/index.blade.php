@extends('admin.layouts.app')

@section('title', 'Pengaturan Admin')
@section('page_title', 'Pengaturan')

@section('content')
<div class="mb-4">
  <h5 class="fw-bold mb-1"><i class="fa-solid fa-gear text-secondary me-2"></i>Pengaturan</h5>
  <p class="text-muted small mb-0">Atur preferensi dan konfigurasi sistem SIGANA.</p>
</div>

<div class="card border-0 shadow-sm">
  <div class="card-body">
    <div class="row gy-4">
      <div class="col-md-6">
        <div class="border rounded-4 p-4 h-100">
          <h6 class="fw-semibold mb-3">Profil Admin</h6>
          <p class="small text-muted">Kelola informasi akun, email, dan keamanan.</p>
          <a href="{{ route('admin.settings.profile') }}" class="btn btn-sm btn-outline-primary">Ubah Profil</a>
        </div>
      </div>
      <div class="col-md-6">
        <div class="border rounded-4 p-4 h-100">
          <h6 class="fw-semibold mb-3">Pengaturan Sistem</h6>
          <p class="small text-muted">Kelola notifikasi, integrasi, dan opsi dashboard.</p>
          <a href="{{ route('admin.settings.system') }}" class="btn btn-sm btn-outline-primary">Atur Sistem</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
