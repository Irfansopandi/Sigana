@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard Admin')

@section('content')

<div class="mb-4">
  <h5 class="fw-bold mb-1">
    <i class="bi bi-shield-lock-fill text-primary me-2"></i>Halo, {{ auth()->user()->name }}!
  </h5>
  <p class="text-muted small mb-0">Selamat datang di Panel Admin SIGANA. Pantau dan kelola semua aktivitas di sini.</p>
</div>

{{-- Stats Cards --}}
<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 p-3" style="background:#eff6ff;">
          <i class="fa-solid fa-users fa-lg" style="color:#3b82f6;"></i>
        </div>
        <div>
          <div class="text-muted small">Total Pengguna</div>
          <div class="fw-bold fs-5">{{ \App\Models\User::count() }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 p-3" style="background:#fef9c3;">
          <i class="fa-solid fa-hand-holding-heart fa-lg" style="color:#ca8a04;"></i>
        </div>
        <div>
          <div class="text-muted small">Kampanye Aktif</div>
          <div class="fw-bold fs-5">{{ \App\Models\Campaign::count() }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 p-3" style="background:#f0fdf4;">
          <i class="fa-solid fa-money-bill-wave fa-lg" style="color:#16a34a;"></i>
        </div>
        <div>
          <div class="text-muted small">Total Donasi</div>
          <div class="fw-bold fs-5">Rp {{ number_format(\App\Models\Donation::sum('amount'), 0, ',', '.') }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 p-3" style="background:#fdf2f8;">
          <i class="fa-solid fa-user-shield fa-lg" style="color:#9333ea;"></i>
        </div>
        <div>
          <div class="text-muted small">Total Relawan</div>
          <div class="fw-bold fs-5">{{ \App\Models\User::where('role', 'relawan')->count() }}</div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Tabel User Terbaru --}}
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
    <h6 class="fw-semibold mb-0">Pengguna Terbaru</h6>
    <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0 align-middle">
        <thead class="table-light">
          <tr>
            <th class="ps-3">#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Bergabung</th>
          </tr>
        </thead>
        <tbody>
          @foreach(\App\Models\User::latest()->take(5)->get() as $i => $u)
          <tr>
            <td class="ps-3 text-muted small">{{ $i + 1 }}</td>
            <td class="fw-medium">{{ $u->name }}</td>
            <td class="text-muted small">{{ $u->email }}</td>
            <td>
              @if($u->role === 'admin')
                <span class="badge bg-danger">Admin</span>
              @elseif($u->role === 'relawan')
                <span class="badge bg-warning text-dark">Relawan</span>
              @else
                <span class="badge bg-primary">User</span>
              @endif
            </td>
            <td class="text-muted small">{{ $u->created_at->format('d M Y') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection