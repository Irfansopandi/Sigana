@extends('relawan.layouts.app')

@section('title', 'Dashboard Relawan')
@section('page_title', 'Dashboard Relawan')

@push('styles')
<style>
  .dashboard-shell {
    display: grid;
    gap: 2rem;
  }

  .hero-card {
    background: linear-gradient(135deg, #0f172a 0%, #1e40af 50%, #0ea5e9 100%);
    color: #fff;
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
    width: 300px; height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
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

  .stat-card-dash {
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    border-left: 4px solid transparent;
    transition: transform .2s, box-shadow .2s;
    background: #fff;
  }
  .stat-card-dash:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(15,23,42,.08);
  }

  .table thead th {
    font-size: .78rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: .04em;
    border-bottom: 1px solid #e2e8f0;
    padding: 12px 16px;
  }
  .table tbody td { padding: 12px 16px; border-color: #f1f5f9; vertical-align: middle; }
  .table-hover tbody tr:hover { background: #f8fafc; }
</style>
@endpush

@section('content')

@php
  $totalKampanye = \App\Models\Campaign::where('report_status', 'disetujui')->count();
  $jumlahDarurat = \App\Models\Campaign::where('report_status', 'disetujui')->where('status', 'Darurat')->count();
  $jumlahWaspada = \App\Models\Campaign::where('report_status', 'disetujui')->where('status', 'Waspada')->count();
  $jumlahAktif   = \App\Models\Campaign::where('report_status', 'disetujui')->where('status', 'Aktif')->count();
@endphp

<div class="dashboard-shell">

  {{-- Hero Card --}}
  <div class="card hero-card shadow-lg">
    <div class="card-body position-relative p-4 p-lg-5">
      <div class="row align-items-center g-4">
        <div class="col-lg-7">
          <span class="badge rounded-pill px-3 py-2 mb-3 d-inline-flex align-items-center gap-2"
            style="background: rgba(255,255,255,0.15); color:#fff; backdrop-filter:blur(4px); font-size:0.8rem;">
            <i class="fa-solid fa-shield-halved"></i> Relawan Aktif
          </span>
          <h3 class="fw-bold mb-2 text-white">Halo, {{ auth()->user()->name }}!</h3>
          <p class="mb-4 text-white" style="opacity:0.8; font-size:0.95rem;">
            Terima kasih sudah menjadi relawan SIGANA. Semangat bertugas hari ini!
          </p>
          <div class="d-flex flex-wrap gap-3">
            <a href="{{ route('bencana') }}" class="hero-btn-outline">
              <i class="fa-solid fa-map-location-dot"></i> Lihat Bencana
            </a>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="rounded-4 p-4" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.15);">
            <div class="small mb-3" style="color:rgba(255,255,255,0.7);">Distribusi Kampanye Bencana</div>
            <div class="display-5 fw-bold text-white mb-3">{{ $totalKampanye }}</div>
            <div class="row g-2 text-center">
              <div class="col-4">
                <div class="rounded-3 py-2" style="background: rgba(247,14,14,0.322); border: 1px solid rgba(239,74,68,0.5);">
                  <div class="fw-bold text-white">{{ $jumlahDarurat }}</div>
                  <div style="color:rgba(255,255,255,0.7); font-size:0.72rem;">Darurat</div>
                </div>
              </div>
              <div class="col-4">
                <div class="rounded-3 py-2" style="background: rgba(213,225,41,0.35); border: 1px solid rgba(221,246,59,0.5);">
                  <div class="fw-bold text-white">{{ $jumlahWaspada }}</div>
                  <div style="color:rgba(255,255,255,0.7); font-size:0.72rem;">Waspada</div>
                </div>
              </div>
              <div class="col-4">
                <div class="rounded-3 py-2" style="background: rgba(18,104,243,0.643); border: 1px solid rgba(255,255,255,0.428);">
                  <div class="fw-bold text-white">{{ $jumlahAktif }}</div>
                  <div style="color:rgba(255,255,255,0.7); font-size:0.72rem;">Aktif</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Stat Cards --}}
  <div class="row g-3">
    <div class="col-sm-6 col-xl-3">
      <div class="card stat-card-dash shadow-sm h-100" style="border-left-color: #dc2626;">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="rounded-3 p-3" style="background:#fef2f2;">
            <i class="fa-solid fa-map-location-dot fa-lg" style="color:#dc2626;"></i>
          </div>
          <div>
            <div class="text-muted small">Bencana Darurat</div>
            <div class="fw-bold fs-5">{{ $jumlahDarurat }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card stat-card-dash shadow-sm h-100" style="border-left-color: #16a34a;">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="rounded-3 p-3" style="background:#f0fdf4;">
            <i class="fa-solid fa-hand-holding-heart fa-lg" style="color:#16a34a;"></i>
          </div>
          <div>
            <div class="text-muted small">Kampanye Aktif</div>
            <div class="fw-bold fs-5">{{ $jumlahAktif }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card stat-card-dash shadow-sm h-100" style="border-left-color: #d97706;">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="rounded-3 p-3" style="background:#fffbeb;">
            <i class="fa-solid fa-circle-exclamation fa-lg" style="color:#d97706;"></i>
          </div>
          <div>
            <div class="text-muted small">Bencana Waspada</div>
            <div class="fw-bold fs-5">{{ $jumlahWaspada }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card stat-card-dash shadow-sm h-100" style="border-left-color: #ca8a04;">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="rounded-3 p-3" style="background:#fef9c3;">
            <i class="fa-solid fa-users fa-lg" style="color:#ca8a04;"></i>
          </div>
          <div>
            <div class="text-muted small">Sesama Relawan</div>
            <div class="fw-bold fs-5">{{ \App\Models\User::where('role', 'relawan')->count() }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Tabel Kampanye --}}
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
      <h6 class="fw-semibold mb-0">
        <i class="fa-solid fa-list-check me-2 text-primary"></i>Kampanye Bencana Terkini
      </h6>
      <a href="{{ route('bencana') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
          <thead class="table-light">
            <tr>
              <th class="ps-4" style="width:50px">#</th>
              <th>Kampanye</th>
              <th>Lokasi</th>
              <th style="width:120px">Status</th>
              <th style="width:120px">Sisa Hari</th>
            </tr>
          </thead>
          <tbody>
            @forelse(\App\Models\Campaign::where('report_status', 'disetujui')->latest()->take(5)->get() as $i => $c)
            <tr>
              <td class="ps-4 text-muted small">{{ $i + 1 }}</td>
              <td class="fw-medium">{{ $c->title }}</td>
              <td class="text-muted small">
                <i class="fa-solid fa-location-dot me-1 text-muted"></i>{{ $c->location }}
              </td>
              <td>
                @if($c->status === 'Darurat')
                  <span class="badge bg-danger rounded-pill px-3">Darurat</span>
                @elseif($c->status === 'Waspada')
                  <span class="badge bg-warning text-dark rounded-pill px-3">Waspada</span>
                @else
                  <span class="badge bg-success rounded-pill px-3">Aktif</span>
                @endif
              </td>
              <td class="text-muted small">{{ $c->days_left }} hari</td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-4">
                <i class="fa-solid fa-inbox fa-2x mb-2 d-block opacity-30"></i>
                Belum ada kampanye tersedia.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
@endsection