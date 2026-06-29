@extends('admin.layouts.app')

@section('title', 'Pengaturan Admin')
@section('page_title', 'Pengaturan')

@section('content')
<div class="mb-4">
  <h5 class="fw-bold mb-1"><i class="fa-solid fa-gear text-secondary me-2"></i>Pengaturan</h5>
  <p class="text-muted small mb-0">Atur preferensi dan konfigurasi akun admin SIGANA.</p>
</div>

<div class="row">
  <div class="col-md-3">
    <div class="card border shadow-sm rounded-4 p-3">
      <div class="card-body p-2">
        <h6 class="fw-semibold mb-2">Profil Admin</h6>
        <p class="small text-muted mb-3">Kelola informasi akun, email, dan keamanan.</p>
        <a href="{{ route('admin.settings.profile') }}" class="btn btn-sm btn-outline-primary">Ubah Profil</a>
      </div>
    </div>
  </div>
</div>
@endsection