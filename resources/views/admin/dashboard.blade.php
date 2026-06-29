@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard Admin')

@push('styles')
<style>
  .dashboard-shell {
    display: grid;
    gap: 2rem;
  }

  .hero-card {
    background: linear-gradient(135deg, #0f172a 0%, #1e40af 50%, #0ea5e9 100%);
    color: #fff5f5;
    border: 0;
    border-radius: 1.75rem;
    overflow: hidden;
    position: relative;
    padding: 0.5rem;
  }

  .hero-card::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
  }

  .hero-card::after {
    content: '';
    position: absolute;
    bottom: -80px; left: 30%;
    width: 300px; height: 300px;
    height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
  }

  .hero-btn-primary {
    background: #fff;
    color: #1e40af;
    border: none;
    border-radius: 50px;
    padding: 9px 22px;
    font-size: 0.875rem;
    font-weight: 600;
    transition: all .25s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .hero-btn-primary:hover {
    background: #e0e7ff;
    color: #1e3a8a;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
  }

  .hero-btn-outline {
  background: rgba(255,255,255,0.12);
  color: #fff;
  border: 1.5px solid rgba(255,255,255,0.35);
  border-radius: 50px;
  padding: 9px 22px;
  font-size: 0.875rem;
  font-weight: 600;
  transition: all .25s ease;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  backdrop-filter: blur(4px);
}

.hero-btn-outline:hover {
  background: rgba(255,255,255,0.22);
  color: #fff;
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}
/* start card */
.stat-card {
  border: 0;
  border-radius: 16px !important;
  transition: transform .2s ease, box-shadow .2s ease;
  overflow: hidden;
  position: relative;
  background: #fff;
}

.stat-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 28px rgba(15, 23, 42, 0.10);
}

.stat-card .card-body {
  min-height: 90px;
}

.stat-card-blue   { border-left: 4px solid #2563eb !important; }
.stat-card-yellow { border-left: 4px solid #d97706 !important; }
.stat-card-green  { border-left: 4px solid #059669 !important; }
.stat-card-purple { border-left: 4px solid #7c3aed !important; }

.stat-card .stat-icon {
  width: 48px; height: 48px;
  border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.2rem;
  flex-shrink: 0;
}

.stat-card-blue   .stat-icon { background: rgba(37,99,235,0.1);  color: #2563eb; }
.stat-card-yellow .stat-icon { background: rgba(217,119,6,0.1);  color: #d97706; }
.stat-card-green  .stat-icon { background: rgba(5,150,105,0.1);  color: #059669; }
.stat-card-purple .stat-icon { background: rgba(124,58,237,0.1); color: #7c3aed; }

.stat-card .stat-label { color: #64748b; font-size: 0.8rem; }
.stat-card .stat-value { color: #0f172a; font-weight: 700; font-size: 1.4rem; }

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
    <div class="card hero-card shadow-lg">
      <div class="card-body position-relative p-4 p-lg-5">
        <div class="row align-items-center g-4">
          <div class="col-lg-7">
            <span class="badge rounded-pill px-3 py-2 mb-3 d-inline-flex align-items-center gap-2"
              style="background: rgba(255,255,255,0.15); color:#fff; backdrop-filter:blur(4px); font-size:0.8rem;">
              <i class="fa-solid fa-satellite-dish"></i> Live Admin Center
            </span>
            <h3 class="fw-bold mb-2 text-white">Halo, {{ auth()->user()->name }}!</h3>
            <p class="mb-4 text-white" style="opacity:0.8; font-size:0.95rem;">
              Pantau donasi, kampanye, dan aktivitas pengguna dari satu layar yang terpadu.
            </p>
            <div class="d-flex flex-wrap gap-3">
              <a href="{{ route('admin.campaigns.create') }}" class="hero-btn-primary">
                <i class="fa-solid fa-plus"></i> Tambah Kampanye
              </a>
              <a href="{{ route('admin.campaigns.index') }}" class="hero-btn-outline">
                <i class="fa-solid fa-file-lines"></i> Lihat Laporan
              </a>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="rounded-4 p-4" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.15);">
              <div class="small mb-3" style="color:rgba(255,255,255,0.7);">Distribusi Kampanye Bencana</div>
              <div class="display-5 fw-bold text-white mb-3">{{ $stats['campaigns'] }}</div>
              <div class="row g-2 text-center">
                <div class="col-4">
                  <div class="rounded-3 py-2" style="background: rgba(247, 14, 14, 0.322); border: 1px solid rgba(239, 74, 68, 0.5);">
                    <div class="fw-bold text-white">{{ $statsChart['Darurat'] ?? 0 }}</div>
                    <div style="color:rgba(255,255,255,0.7); font-size:0.72rem;">Darurat</div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="rounded-3 py-2" style="background: rgba(213, 225, 41, 0.35); border: 1px solid rgba(221, 246, 59, 0.5);">
                    <div class="fw-bold text-white">{{ $statsChart['Waspada'] ?? 0 }}</div>
                    <div style="color:rgba(255,255,255,0.7); font-size:0.72rem;">Waspada</div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="rounded-3 py-2" style="background: rgba(18, 104, 243, 0.643); border: 1px solid rgba(255, 255, 255, 0.428);">
                    <div class="fw-bold text-white">{{ $statsChart['Aktif'] ?? 0 }}</div>
                    <div style="color:rgba(255,255,255,0.7); font-size:0.72rem;">Aktif</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-3">
      <div class="col-sm-6 col-xl-3">
        <div class="card stat-card stat-card-blue shadow-sm">
          <div class="card-body d-flex align-items-center gap-3 p-4">
            <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
            <div>
              <div class="stat-label">Total Pengguna</div>
              <div class="stat-value">{{ $stats['users'] }}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="card stat-card stat-card-yellow shadow-sm">
          <div class="card-body d-flex align-items-center gap-3 p-4">
            <div class="stat-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div>
              <div class="stat-label">Total Bencana</div>
              <div class="stat-value">{{ $stats['campaigns'] }}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="card stat-card stat-card-green shadow-sm">
          <div class="card-body d-flex align-items-center gap-3 p-4">
            <div class="stat-icon"><i class="fa-solid fa-coins"></i></div>
            <div>
              <div class="stat-label">Donasi Sukses</div>
              <div class="stat-value" style="font-size:1.1rem;">Rp {{ number_format($stats['donations'], 0, ',', '.') }}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="card stat-card stat-card-purple shadow-sm">
          <div class="card-body d-flex align-items-center gap-3 p-4">
            <div class="stat-icon"><i class="fa-solid fa-user-shield"></i></div>
            <div>
              <div class="stat-label">Total Relawan</div>
              <div class="stat-value">{{ $stats['volunteers'] }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- ========================
        GRAFIK
    ======================== --}}
    <div class="row g-4">
      {{-- Grafik Bar: Donasi per Kampanye (kiri) --}}
      <div class="col-xl-8">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white border-0 pb-0">
            <h6 class="fw-semibold mb-1"><i class="fa-solid fa-chart-bar me-2 text-success"></i>Donasi per Kampanye</h6>
            <p class="small text-muted mb-0">Total donasi masuk berdasarkan kampanye bencana</p>
          </div>
          <div class="card-body" style="overflow-x: auto; padding: 1.5rem;">
            <div style="min-width: {{ max(400, count($donationChart) * 100) }}px; height: 260px;">
              <canvas id="donationChart"></canvas>
            </div>
          </div>
        </div>
      </div>

      {{-- Grafik Donut: Status Bencana (kanan) --}}
      <div class="col-xl-4">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white border-0 pb-0">
            <h6 class="fw-semibold mb-1"><i class="fa-solid fa-chart-pie me-2 text-primary"></i>Status Bencana</h6>
            <p class="small text-muted mb-0">Distribusi kampanye berdasarkan status</p>
          </div>
          <div class="card-body d-flex align-items-center justify-content-center" style="padding: 1.5rem;">
            <div style="width: 100%; height: 280px;">
              <canvas id="statusChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4">
    {{-- Aktivitas Terbaru --}}
    <div class="col-xl-8">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
          <div>
            <h6 class="fw-semibold mb-1">Aktivitas Terbaru</h6>
            <p class="small text-muted mb-0">Filter aktivitas sesuai kebutuhan admin</p>
          </div>
          <div class="d-flex flex-wrap gap-2">
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

    {{-- Aksi Cepat --}}
    <div class="col-xl-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
          <h6 class="fw-semibold mb-1">Aksi Cepat</h6>
          <p class="small text-muted mb-0">Fitur yang sering dipakai admin</p>
        </div>
        <div class="card-body p-3">
          <div class="d-flex flex-column gap-2">
            <a href="{{ route('admin.users.index') }}" class="quick-action-card">
              <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-2 bg-primary-subtle text-primary"><i class="fa-solid fa-users"></i></div>
                <div>
                  <div class="fw-semibold">Kelola Pengguna</div>
                  <div class="small text-muted">Lihat dan atur akun komunitas</div>
                </div>
              </div>
            </a>
            <a href="{{ route('admin.campaigns.index') }}" class="quick-action-card">
              <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 p-2 bg-success-subtle text-success"><i class="fa-solid fa-hand-holding-heart"></i></div>
                <div>
                  <div class="fw-semibold">Pantau Kampanye</div>
                  <div class="small text-muted">Cek status dan progress donasi</div>
                </div>
              </div>
            </a>
            <a href="{{ route('admin.transparency.index') }}" class="quick-action-card">
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
  </div>
@endsection

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@push('scripts')
<script>
  document.querySelectorAll('.filter-chip').forEach(button => {
    button.addEventListener('click', () => {
      document.querySelectorAll('.filter-chip').forEach(item => item.classList.remove('active'));
      button.classList.add('active');

      const filter = button.dataset.filter;
      document.querySelectorAll('.activity-item').forEach(item => {
        item.classList.toggle('is-hidden', item.dataset.type !== filter);
      });
    });
  });
  // Default tampilkan user saja
  document.querySelectorAll('.activity-item').forEach(item => {
      if (item.dataset.type !== 'user') item.classList.add('is-hidden');
  });

// Grafik 1: Donut Status Bencana
const statusData = @json($statsChart);
const statusLabels = Object.keys(statusData);
const statusValues = Object.values(statusData);

const statusColors = {
  'Darurat' : '#ef4444',
  'Waspada' : '#f59e0b',
  'Aktif'   : '#3b82f6',
  'Selesai' : '#10b981',
  'Ditutup' : '#6b7280',
};

new Chart(document.getElementById('statusChart'), {
  type: 'doughnut',
  data: {
    labels: statusLabels,
    datasets: [{
      data: statusValues,
      backgroundColor: statusLabels.map(l => statusColors[l] ?? '#94a3b8'),
      borderWidth: 2,
      borderColor: '#fff',
      hoverOffset: 8,
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'bottom',
        align: 'center',
        labels: { padding: 16, font: { size: 12 }, boxWidth: 12,  usePointStyle: true,}
      },
      tooltip: {
        callbacks: {
          label: ctx => ` ${ctx.label}: ${ctx.parsed} kampanye`
        }
      }
    },
    cutout: '65%',
  }
});

// Grafik 2: Bar Donasi per Kampanye
const donationData = @json($donationChart);
const donationLabels = donationData.map(d => d.title.length > 25 ? d.title.substring(0, 25) + '…' : d.title);
const donationValues = donationData.map(d => d.total);

new Chart(document.getElementById('donationChart'), {
    type: 'bar',
    data: {
      labels: donationLabels,
      datasets: [{
        label: 'Total Donasi (Rp)',
        data: donationValues,
        backgroundColor: donationValues.map((_, i) => {
          const gradients = [
            '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4',
            '#ec4899', '#14b8a6', '#f97316', '#6366f1'
          ];
          return gradients[i % gradients.length];
        }),
        borderRadius: 10,
        borderSkipped: false,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            title: ctx => donationData[ctx[0].dataIndex].title, // nama lengkap di tooltip
            label: ctx => ' Rp ' + ctx.parsed.y.toLocaleString('id-ID')
          }
        }
      },
      scales: {
        x: {
          grid: { display: false },
          ticks: { display: false } // sembunyikan label bawah
        },
        y: {
          grid: { color: '#f1f5f9' },
          ticks: {
            callback: val => 'Rp ' + (val / 1000000).toFixed(1) + 'jt'
          }
        }
      }
    }
  });
</script>
@endpush