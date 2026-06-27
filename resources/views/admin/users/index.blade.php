@extends('admin.layouts.app')

@section('title', 'Kelola Pengguna')
@section('page_title', 'Pengguna')

@push('styles')
<style>
  .stat-card {
    border-radius: 1rem;
    border: none;
    transition: transform .15s;
  }
  .stat-card:hover { transform: translateY(-2px); }
  .role-badge-user    { background:#eff6ff; color:#1d4ed8; }
  .role-badge-relawan { background:#f0fdf4; color:#166534; }
  .role-badge-admin   { background:#fef3c7; color:#92400e; }
  .filter-btn {
    border-radius: 8px;
    border: 1.5px solid #e2e8f0;
    background: #fff;
    color: #64748b;
    font-size: 0.85rem;
    padding: 6px 16px;
    transition: all .15s;
  }
  .filter-btn.active {
    background: #2563eb;
    color: #fff;
    border-color: #2563eb;
  }
  .btn-detail {
    border-radius: 8px;
    border: 1.5px solid #e2e8f0;
    color: #64748b;
    background: #fff;
    transition: all .2s;
  }
  .btn-detail:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
    border-color: #2563eb !important;
    color: #2563eb !important;
    background: #fff !important;
  }
</style>
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-users text-primary me-2"></i>Kelola Pengguna</h5>
    <p class="text-muted small mb-0">Lihat, cari, dan atur semua pengguna terdaftar.</p>
  </div>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm p-3" style="border-radius:1rem; background:linear-gradient(135deg,#2563eb,#60a5fa);">
      <div class="d-flex align-items-center gap-3">
        <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;">
          <i class="fa-solid fa-users text-white fs-5"></i>
        </div>
        <div>
          <div class="text-white opacity-75 small">Total Pengguna</div>
          <div class="fw-bold fs-4 text-white">{{ $stats['total'] }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm p-3" style="border-radius:1rem; background:linear-gradient(135deg,#0ea5e9,#38bdf8);">
      <div class="d-flex align-items-center gap-3">
        <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;">
          <i class="fa-solid fa-user text-white fs-5"></i>
        </div>
        <div>
          <div class="text-white opacity-75 small">User</div>
          <div class="fw-bold fs-4 text-white">{{ $stats['user'] }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm p-3" style="border-radius:1rem; background:linear-gradient(135deg,#059669,#34d399);">
      <div class="d-flex align-items-center gap-3">
        <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;">
          <i class="fa-solid fa-user-shield text-white fs-5"></i>
        </div>
        <div>
          <div class="text-white opacity-75 small">Relawan</div>
          <div class="fw-bold fs-4 text-white">{{ $stats['relawan'] }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm p-3" style="border-radius:1rem; background:linear-gradient(135deg,#d97706,#fbbf24);">
      <div class="d-flex align-items-center gap-3">
        <div style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;">
          <i class="fa-solid fa-user-tie text-white fs-5"></i>
        </div>
        <div>
          <div class="text-white opacity-75 small">Admin</div>
          <div class="fw-bold fs-4 text-white">{{ $stats['admin'] }}</div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Filter & Search --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius:1rem;">
  <div class="card-body p-3">
    <div class="d-flex flex-wrap gap-2 align-items-center">

      {{-- Role Dropdown --}}
      <select onchange="window.location='{{ route('admin.users.index') }}?role='+this.value+'&search={{ $search }}&per_page={{ $perPage }}'"
        class="form-select form-select-sm" style="width:140px;border-radius:8px;">
        @foreach(['all' => 'Semua Role', 'user' => 'User', 'relawan' => 'Relawan', 'admin' => 'Admin'] as $val => $label)
          <option value="{{ $val }}" {{ $role === $val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
      </select>

      {{-- Per Page --}}
      <span class="text-muted small">Tampilkan</span>
      <select onchange="window.location='{{ route('admin.users.index') }}?role={{ $role }}&search={{ $search }}&per_page='+this.value"
        class="form-select form-select-sm" style="width:70px;border-radius:8px;">
        @foreach([10, 25, 50] as $n)
          <option value="{{ $n }}" {{ $perPage == $n ? 'selected' : '' }}>{{ $n }}</option>
        @endforeach
      </select>

      {{-- Search --}}
      <form method="GET" action="{{ route('admin.users.index') }}" class="ms-auto d-flex gap-2">
        <input type="hidden" name="role" value="{{ $role }}">
        <input type="hidden" name="per_page" value="{{ $perPage }}">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama / email..."
          class="form-control form-control-sm" style="border-radius:8px; min-width:200px;">
        <button type="submit" class="btn btn-sm btn-primary" style="border-radius:8px;">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
        @if($search)
          <a href="{{ route('admin.users.index', ['role' => $role, 'per_page' => $perPage]) }}"
            class="btn btn-sm" style="border-radius:8px; border:1.5px solid #e2e8f0; color:#64748b;">
            <i class="fa-solid fa-xmark"></i>
          </a>
        @endif
      </form>
    </div>
  </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm" style="border-radius:1rem;">
  <div class="card-body p-3">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No. HP</th>
            <th>Role</th>
            <th>Terdaftar</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $user)
            <tr>
              <td class="text-muted small">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div style="width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,#2563eb,#60a5fa);
                    display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.9rem;flex-shrink:0;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                  </div>
                  <span class="fw-semibold">{{ $user->name }}</span>
                </div>
              </td>
              <td class="text-muted small">{{ $user->email }}</td>
              <td class="text-muted small">{{ $user->phone ?? '-' }}</td>
              <td>
                @php
                  $roleClass = match($user->role) {
                    'relawan' => 'role-badge-relawan',
                    'admin'   => 'role-badge-admin',
                    default   => 'role-badge-user',
                  };
                @endphp
                <span class="badge rounded-pill px-3 py-2 {{ $roleClass }}" style="font-size:0.75rem;">
                  {{ ucfirst($user->role) }}
                </span>
              </td>
              <td class="text-muted small">{{ $user->created_at->format('d M Y') }}</td>
              <td>
                <a href="{{ route('admin.users.show', $user) }} "class="btn btn-sm btn-detail"
                  class="btn btn-sm" style="border-radius:8px;border:1.5px solid #e2e8f0;color:#64748b;">
                  <i class="fa-solid fa-eye me-1"></i>Detail
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center text-muted py-4">Belum ada pengguna tersedia.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
</div>
@endsection