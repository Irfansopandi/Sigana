@extends('admin.layouts.app')

@section('title', 'Data Relawan')
@section('page_title', 'Data Relawan')

@push('styles')
<style>
.stat-card-item {
  transition: transform .2s ease, box-shadow .2s ease;
}
.stat-card-item:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 28px rgba(15, 23, 42, 0.10) !important;
}

.volunteer-avatar {
  width: 34px; height: 34px;
  border-radius: 10px; /* tumpul */
  background: linear-gradient(135deg, #2563eb, #60a5fa);
  display: flex; align-items: center; justify-content: center;
  font-weight: 700; color: #fff; font-size: 0.85rem; flex-shrink: 0;
}

.table > tbody > tr:hover {
  background: #f8fafc !important;
}

.btn-detail-vol {
  border-radius: 8px;
  border: 1.5px solid#8f8f8f;
  color: #8f8f8f;
  background: #fff;
  transition: all .2s;
}
.btn-detail-vol:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
  border-color: #2563eb !important;
  color: #2563eb !important;
  background: #eff6ff !important;
}
.btn-verify {
  border-radius: 8px;
  background: #fff;
  color: #8f8f8f;
  border: 1.5px solid #8f8f8f;
  transition: all .2s;
}
.btn-verify:hover {
  transform: translateY(-2px);
  background: linear-gradient(135deg, #059669, #34d399);
  box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
  color: #fff !important;
}
</style>
@endpush

@section('content')
<div class="mb-4">
  <h5 class="fw-bold mb-1"><i class="fa-solid fa-shield-halved text-success me-2"></i>Data Relawan</h5>
  <p class="text-muted small mb-0">Verifikasi relawan terdaftar dan pantau status akun.</p>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
  <div class="col-sm-4">
    <div class="card border-0 shadow-sm h-100 stat-card-item" style="border-radius:16px; border-left:4px solid #2563eb !important;">
      <div class="card-body d-flex align-items-center gap-3 p-4">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(37,99,235,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="fa-solid fa-users" style="color:#2563eb;font-size:1.2rem;"></i>
        </div>
        <div>
          <div class="small" style="color:#64748b;">Total Relawan</div>
          <div class="fw-bold" style="font-size:1.4rem;color:#0f172a;">{{ $stats['total'] }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card border-0 shadow-sm h-100 stat-card-item" style="border-radius:16px; border-left:4px solid #059669 !important;">
      <div class="card-body d-flex align-items-center gap-3 p-4">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(5,150,105,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="fa-solid fa-user-check" style="color:#059669;font-size:1.2rem;"></i>
        </div>
        <div>
          <div class="small" style="color:#64748b;">Terverifikasi</div>
          <div class="fw-bold" style="font-size:1.4rem;color:#0f172a;">{{ $stats['verified'] }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card border-0 shadow-sm h-100 stat-card-item" style="border-radius:16px; border-left:4px solid #dc2626 !important;">
      <div class="card-body d-flex align-items-center gap-3 p-4">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(220,38,38,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="fa-solid fa-user-clock" style="color:#dc2626;font-size:1.2rem;"></i>
        </div>
        <div>
          <div class="small" style="color:#64748b;">Belum Diverifikasi</div>
          <div class="fw-bold" style="font-size:1.4rem;color:#0f172a;">{{ $stats['unverified'] }}</div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Filter & Per Page --}}
<div class="card-header bg-white border-0 py-3 px-4">
  <div class="d-flex flex-wrap justify-content-between align-items-end gap-4">
    <div class="fw-semibold fs-6">Daftar Relawan</div>
    <form method="GET" action="{{ route('admin.volunteers.index') }}" class="d-flex gap-4 align-items-end">
      <div>
        <label class="text-uppercase fw-bold mb-1 d-block" style="font-size:0.68rem; letter-spacing:.08em; color:#94a3b8;">Status Verifikasi</label>
        <select name="status" class="form-select form-select-sm" style="min-width:150px; border-radius:8px; border:1.5px solid #e2e8f0;" onchange="this.form.submit()">
          <option value="all"        {{ $status === 'all'        ? 'selected' : '' }}>Semua</option>
          <option value="verified"   {{ $status === 'verified'   ? 'selected' : '' }}>Terverifikasi</option>
          <option value="unverified" {{ $status === 'unverified' ? 'selected' : '' }}>Belum Diverifikasi</option>
        </select>
      </div>
      <div>
        <label class="text-uppercase fw-bold mb-1 d-block" style="font-size:0.68rem; letter-spacing:.08em; color:#94a3b8;">Tampil</label>
        <select name="per_page" class="form-select form-select-sm" style="min-width:120px; border-radius:8px; border:1.5px solid #e2e8f0;" onchange="this.form.submit()">
          @foreach([10, 25, 50] as $n)
            <option value="{{ $n }}" {{ $perPage == $n ? 'selected' : '' }}>{{ $n }} baris</option>
          @endforeach
        </select>
      </div>
    </form>
  </div>
</div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead style="background:#f8fafc;">
          <tr>
            <th class="ps-4" style="width:50px;">#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Profil</th>
            <th>Status Verifikasi</th>
            <th class="text-center">Tindakan</th>
          </tr>
        </thead>
        <tbody>
          @forelse($volunteers as $volunteer)
          <tr>
            <td class="ps-4 text-muted small">{{ $loop->iteration + ($volunteers->currentPage() - 1) * $volunteers->perPage() }}</td>
            <td>
              <div class="d-flex align-items-center gap-2">
                <div class="volunteer-avatar">
                  {{ strtoupper(substr($volunteer->name, 0, 1)) }}
                </div>
                <span class="fw-semibold">{{ $volunteer->name }}</span>
              </div>
            </td>
            <td class="text-muted small">{{ $volunteer->email }}</td>
            <td>
              @if($volunteer->profile_complete)
                <span class="badge rounded-pill" style="background:#dcfce7;color:#166534;">Lengkap</span>
              @else
                <span class="badge rounded-pill" style="background:#fee2e2;color:#991b1b;">Belum Lengkap</span>
              @endif
            </td>
            <td>
              @if($volunteer->is_verified)
                <span class="badge rounded-pill px-3 py-2" style="background:#16a34a; color:#fff; font-size:0.78rem;">
                  <i class="fa-solid fa-circle-check me-1"></i>Aktif
                </span>
              @else
                <span class="badge rounded-pill px-3 py-2" style="background:#fef9c3; color:#854d0e; font-size:0.78rem;">
                  <i class="fa-solid fa-clock me-1"></i>Belum Diverifikasi
                </span>
              @endif
            </td>
            <td class="text-center">
              <div class="d-flex gap-2 justify-content-center">
                <a href="{{ route('admin.volunteers.show', $volunteer) }}" class="btn btn-sm px-3 btn-detail-vol">
                  <i class="fa-solid fa-eye me-1"></i>Detail
                </a>
                @if(!$volunteer->is_verified && $volunteer->profile_complete)
                  <form action="{{ route('admin.volunteers.verify', $volunteer) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm px-3 btn-verify">
                      <i class="fa-solid fa-user-check me-1"></i>Verifikasi
                    </button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center text-muted py-5">
              <i class="fa-solid fa-users-slash fa-2x mb-3 d-block text-muted opacity-50"></i>
              Tidak ada relawan ditemukan.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($volunteers->hasPages())
    <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
      <div class="small text-muted">
        Menampilkan {{ $volunteers->firstItem() }}–{{ $volunteers->lastItem() }} dari {{ $volunteers->total() }} relawan
      </div>
      {{ $volunteers->links() }}
    </div>
    @endif
  </div>
</div>

@push('scripts')
@if(session('success'))
<script>
  Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: '{{ session('success') }}', showConfirmButton: false, timer: 3000, timerProgressBar: true, background: '#22c55e', color: '#fff', iconColor: '#fff' });
</script>
@endif
@if(session('error'))
<script>
  Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: '{{ session('error') }}', showConfirmButton: false, timer: 3000, timerProgressBar: true, background: '#ef4444', color: '#fff', iconColor: '#fff' });
</script>
@endif
@endpush

@endsection