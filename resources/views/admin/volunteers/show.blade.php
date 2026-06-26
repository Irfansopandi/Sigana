@extends('admin.layouts.app')

@section('title', 'Detail Relawan')
@section('page_title', 'Detail Relawan')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-user-shield text-primary me-2"></i>Detail Relawan</h5>
    <p class="text-muted small mb-0">Tinjau informasi lengkap relawan dan status verifikasi.</p>
  </div>
  <a href="{{ route('admin.volunteers.index') }}" class="btn btn-outline-secondary btn-sm">Kembali ke Daftar</a>
</div>

<div class="row g-4">
  <div class="col-lg-6">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h6 class="fw-semibold mb-3">Informasi Akun</h6>
        <div class="mb-3">
          <label class="form-label">Nama</label>
          <div class="form-control-plaintext">{{ $user->name }}</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <div class="form-control-plaintext">{{ $user->email }}</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Nomor Telepon</label>
          <div class="form-control-plaintext">{{ $user->phone ?? '-' }}</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Role</label>
          <div class="form-control-plaintext">{{ ucfirst($user->role) }}</div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h6 class="fw-semibold mb-3">Status Relawan</h6>
        <div class="mb-3">
          <label class="form-label">Verifikasi Email</label>
          <div class="form-control-plaintext">
            @if($user->is_verified)
              <span class="badge bg-success">Terverifikasi</span>
            @else
              <span class="badge bg-warning text-dark">Belum Diverifikasi</span>
            @endif
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Profil Lengkap</label>
          <div class="form-control-plaintext">
            @if($user->profile_complete)
              <span class="badge bg-success">Lengkap</span>
            @else
              <span class="badge bg-danger">Belum Lengkap</span>
            @endif
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Tanggal Terdaftar</label>
          <div class="form-control-plaintext">{{ $user->created_at->format('d M Y H:i') }}</div>
        </div>
        @if(!$user->is_verified)
        <div class="mt-3">
          @if($user->profile_complete)
            <form action="{{ route('admin.volunteers.verify', $user) }}" method="POST">
              @csrf
              <button class="btn btn-primary">Verifikasi Sekarang</button>
            </form>
          @else
            <button type="button" class="btn btn-warning" disabled>Data Belum Lengkap</button>
          @endif
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
