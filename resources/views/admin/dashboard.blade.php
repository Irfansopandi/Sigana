@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard Admin')

@push('styles')
<style>
  .dashboard-shell {
    display: grid;
    gap: 1.25rem;
  }

  .hero-card {
    background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 45%, #38bdf8 100%);
    color: #fff5f5;
    border: 0;
    border-radius: 1.5rem;
    overflow: hidden;
    position: relative;
  }

  .hero-card::after {
    content: '';
    position: absolute;
    inset: auto -20px -40px auto;
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,0.13);
  }

  .stat-card {
    border: 0;
    border-radius: 1.1rem;
    transition: transform .2s ease, box-shadow .2s ease;
  }

  .stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.09);
  }

  .quick-action-card {
    border: 1px solid #e2e8f0;
    border-radius: 1rem;
    padding: 0.95rem;
    transition: all .2s ease;
    text-decoration: none;
    color: inherit;
  }

  .quick-action-card:hover {
    border-color: #60a5fa;
    background: #f8fbff;
    transform: translateY(-2px);
  }

  .activity-item {
    border-bottom: 1px solid #f1f5f9;
    padding: 0.9rem 0;
    transition: all .2s ease;
  }

  .activity-item:last-child {
    border-bottom: 0;
    padding-bottom: 0;
  }

  .activity-item.is-hidden {
    display: none;
  }

  .filter-chip {
    border-radius: 999px;
    border: 1px solid #dbeafe;
    background: #fff;
    color: #2563eb;
    transition: all .2s ease;
  }

  .filter-chip.active {
    background: #2563eb;
    color: #fff;
    border-color: #2563eb;
  }
</style>
@endpush

@section('content')
<div class="dashboard-shell">
  <div class="card hero-card shadow-sm">
    <div class="card-body position-relative">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <div class="d-flex align-items-center gap-2 mb-3">
            <span class="badge rounded-pill px-3 py-2" style="background: rgba(0, 0, 0, 0.3); color: #fff;">
              <i class="fa-solid fa-satellite-dish me-2"></i>Live Admin Center
            </span>
          </div>
          <h4 class="fw-bold mb-2">Halo, {{ auth()->user()->name }}!</h4>
          <p class="mb-3 text-white-50">Pantau donasi, kampanye, dan aktivitas pengguna dari satu layar yang lebih informatif.</p>
          <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.campaigns.create') }}" class="btn btn-light btn-sm rounded-pill">
              <i class="fa-solid fa-plus me-2"></i>Tambah Kampanye
            </a>
            <a href="{{ route('admin.campaigns.index') }}" class="btn btn-outline-light btn-sm rounded-pill">
              <i class="fa-solid fa-file-lines me-2"></i>Lihat Laporan
            </a>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="rounded-4 bg-white bg-opacity-10 p-3 backdrop-blur">
            <div class="small text-white-50 mb-2">Target minggu ini</div>
            <div class="display-6 fw-bold">{{ $stats['campaigns'] }}</div>
            <div class="small text-white-50">kampanye tersedia</div>
            <div class="progress mt-3" style="height: 8px;">
              <div class="progress-bar bg-white" style="width: 78%"></div>
            </div>
            <div class="d-flex justify-content-between small mt-2 text-white-50">
              <span>Progress</span>
              <span>78%</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-sm-6 col-xl-3">
      <div class="card stat-card shadow-sm h-100">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="rounded-3 p-3" style="background:#eff6ff;">
            <i class="fa-solid fa-users fa-lg" style="color:#2563eb;"></i>
          </div>
          <div>
            <div class="text-muted small">Total Pengguna</div>
            <div class="fw-bold fs-5">{{ $stats['users'] }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card stat-card shadow-sm h-100">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="rounded-3 p-3" style="background:#fef9c3;">
            <i class="fa-solid fa-hand-holding-heart fa-lg" style="color:#ca8a04;"></i>
          </div>
          <div>
            <div class="text-muted small">Kampanye Aktif</div>
            <div class="fw-bold fs-5">{{ $stats['active_campaigns'] }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card stat-card shadow-sm h-100">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="rounded-3 p-3" style="background:#f0fdf4;">
            <i class="fa-solid fa-coins fa-lg" style="color:#16a34a;"></i>
          </div>
          <div>
            <div class="text-muted small">Donasi Sukses</div>
            <div class="fw-bold fs-5">Rp {{ number_format($stats['donations'], 0, ',', '.') }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card stat-card shadow-sm h-100">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="rounded-3 p-3" style="background:#fdf2f8;">
            <i class="fa-solid fa-user-shield fa-lg" style="color:#9333ea;"></i>
          </div>
          <div>
            <div class="text-muted small">Total Relawan</div>
            <div class="fw-bold fs-5">{{ $stats['volunteers'] }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-xl-8">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
          <div>
            <h6 class="fw-semibold mb-1">Ringkasan Cepat</h6>
            <p class="small text-muted mb-0">Informasi utama yang paling sering dipantau admin</p>
          </div>
          <span class="badge rounded-pill bg-success-subtle text-success">Terbaru</span>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <div class="border rounded-4 p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="fw-semibold">Donasi Terkumpul</span>
                  <span class="small text-muted">{{ $stats['success_donations'] }} transaksi</span>
                </div>
                <div class="h4 fw-bold mb-1">Rp {{ number_format($stats['donations'], 0, ',', '.') }}</div>
                <div class="progress" style="height: 8px;">
                  <div class="progress-bar bg-success" style="width: 78%"></div>
                </div>
                <div class="small text-muted mt-2">Performa donasi masih berada pada tren positif.</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="border rounded-4 p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="fw-semibold">Kampanye Aktif</span>
                  <span class="small text-muted">{{ $stats['active_campaigns'] }} aktif</span>
                </div>
                <div class="h4 fw-bold mb-1">{{ $stats['campaigns'] }}</div>
                <div class="d-flex flex-wrap gap-2 mt-3">
                  <span class="badge bg-danger-subtle text-danger">Darurat</span>
                  <span class="badge bg-warning-subtle text-warning">Waspada</span>
                  <span class="badge bg-primary-subtle text-primary">Aktif</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-white border-0">
          <h6 class="fw-semibold mb-1">Aksi Cepat</h6>
          <p class="small text-muted mb-0">Fitur yang sering dipakai admin</p>
        </div>
        <div class="card-body">
          <div class="d-grid gap-2">
            <a href="#" class="quick-action-card">
              <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-2 bg-primary-subtle text-primary"><i class="fa-solid fa-users"></i></div>
                <div>
                  <div class="fw-semibold">Kelola Pengguna</div>
                  <div class="small text-muted">Lihat dan atur akun komunitas</div>
                </div>
              </div>
            </a>
            <a href="#" class="quick-action-card">
              <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-2 bg-success-subtle text-success"><i class="fa-solid fa-hand-holding-heart"></i></div>
                <div>
                  <div class="fw-semibold">Pantau Kampanye</div>
                  <div class="small text-muted">Cek status dan progress donasi</div>
                </div>
              </div>
            </a>
            <a href="#" class="quick-action-card">
              <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-2 bg-warning-subtle text-warning"><i class="fa-solid fa-file-lines"></i></div>
                <div>
                  <div class="fw-semibold">Laporan Transparansi</div>
                  <div class="small text-muted">Buka ringkasan laporan terbaru</div>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div>
        <h6 class="fw-semibold mb-1">Aktivitas Terbaru</h6>
        <p class="small text-muted mb-0">Filter aktivitas sesuai kebutuhan admin</p>
      </div>
      <div class="d-flex flex-wrap gap-2">
        <button type="button" class="btn btn-sm filter-chip active" data-filter="all">Semua</button>
        <button type="button" class="btn btn-sm filter-chip" data-filter="user">Pengguna</button>
        <button type="button" class="btn btn-sm filter-chip" data-filter="campaign">Kampanye</button>
        <button type="button" class="btn btn-sm filter-chip" data-filter="donation">Donasi</button>
      </div>
    </div>
    <div class="card-body">
      <div class="list-group list-group-flush">
        @foreach($recentActivities as $activity)
        <div class="activity-item" data-type="{{ $activity['type'] }}">
          <div class="d-flex align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
              <div class="rounded-circle p-2 bg-primary-subtle text-primary">
                <i class="{{ $activity['icon'] }}"></i>
              </div>
              <div>
                <div class="fw-semibold">{{ $activity['title'] }}</div>
                <div class="small text-muted">{{ $activity['description'] }}</div>
              </div>
            </div>
            <span class="text-muted small">{{ $activity['time'] }}</span>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.querySelectorAll('.filter-chip').forEach(button => {
    button.addEventListener('click', () => {
      document.querySelectorAll('.filter-chip').forEach(item => item.classList.remove('active'));
      button.classList.add('active');

      const filter = button.dataset.filter;
      document.querySelectorAll('.activity-item').forEach(item => {
        const type = item.dataset.type;
        item.classList.toggle('is-hidden', filter !== 'all' && type !== filter);
      });
    });
  });
</script>
@endpush