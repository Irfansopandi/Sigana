@extends('user.layouts.app')

@section('title', 'Profil Saya')
@section('page_title', 'Profil Saya')

@section('content')
<div class="row">
  <div class="col-md-6">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-0">
        <h6 class="fw-semibold mb-0">Informasi Akun</h6>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <label class="text-muted small">Nama</label>
          <div class="fw-medium">{{ $user->name }}</div>
        </div>
        <div class="mb-3">
          <label class="text-muted small">Email</label>
          <div class="fw-medium">{{ $user->email }}</div>
        </div>
        <div class="mb-3">
          <label class="text-muted small">Nomor Telepon</label>
          <div class="fw-medium">{{ $user->phone ?? '-' }}</div>
        </div>
        <div class="mb-3">
          <label class="text-muted small">Bergabung Sejak</label>
          <div class="fw-medium">{{ $user->created_at->translatedFormat('d M Y') }}</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection