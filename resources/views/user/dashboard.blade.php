@extends('user.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Saya')

@section('content')

<div class="mb-4">
  <h5 class="fw-bold mb-1">
    <i class="bi bi-house-heart-fill text-success me-2"></i>Halo, {{ auth()->user()->name }}!
  </h5>
  <p class="text-muted small mb-0">Selamat datang kembali di SIGANA. Yuk, bantu sesama hari ini.</p>
</div>

<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-4">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 p-3" style="background:#eff6ff;">
          <i class="fa-solid fa-money-bill-wave fa-lg" style="color:#3b82f6;"></i>
        </div>
        <div>
          <div class="text-muted small">Total Donasi Saya</div>
          <div class="fw-bold fs-5">
            Rp {{ number_format(\App\Models\Donation::where('name', auth()->user()->name)->sum('amount'), 0, ',', '.') }}
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-4">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 p-3" style="background:#f0fdf4;">
          <i class="fa-solid fa-hand-holding-heart fa-lg" style="color:#16a34a;"></i>
        </div>
        <div>
          <div class="text-muted small">Kampanye Aktif</div>
          <div class="fw-bold fs-5">{{ \App\Models\Campaign::count() }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-4">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 p-3" style="background:#fef9c3;">
          <i class="fa-solid fa-triangle-exclamation fa-lg" style="color:#ca8a04;"></i>
        </div>
        <div>
          <div class="text-muted small">Bencana Darurat</div>
          <div class="fw-bold fs-5">{{ \App\Models\Campaign::where('status', 'Darurat')->count() }}</div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card border-0 shadow-sm mb-4">
  <div class="card-header bg-white border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
    <h6 class="fw-semibold mb-0">Laporan Bencana Saya</h6>
    <a href="{{ route('laporan.bencana.create') }}" class="btn btn-sm btn-primary">+ Buat Laporan</a>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0 align-middle">
        <thead class="table-light">
          <tr>
            <th class="ps-3">#</th>
            <th>Judul</th>
            <th>Lokasi</th>
            <th>Status Verifikasi</th>
            <th>Waktu</th>
          </tr>
        </thead>
        <tbody>
          @forelse($reports as $i => $report)
          <tr>
            <td class="ps-3 text-muted small">{{ $i + 1 }}</td>
            <td class="fw-medium">{{ $report->title }}</td>
            <td class="text-muted small">{{ $report->location }}</td>
            <td>
              @if($report->report_status === 'disetujui')
                <span class="badge bg-success">Disetujui</span>
              @elseif($report->report_status === 'ditolak')
                <span class="badge bg-danger">Ditolak</span>
              @else
                <span class="badge bg-warning text-dark">Menunggu</span>
              @endif
            </td>
            <td class="text-muted small">{{ $report->created_at->translatedFormat('d M Y') }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center py-4 text-muted">Belum ada laporan bencana yang Anda kirim.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="card border-0 shadow-sm">
  <div class="card-header bg-white border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
    <h6 class="fw-semibold mb-0">Kampanye Butuh Bantuan</h6>
    <a href="{{ route('bencana') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0 align-middle">
        <thead class="table-light">
          <tr>
            <th class="ps-3">#</th>
            <th>Kampanye</th>
            <th>Lokasi</th>
            <th>Status</th>
            <th>Target</th>
          </tr>
        </thead>
        <tbody>
          @foreach(\App\Models\Campaign::latest()->take(5)->get() as $i => $c)
          <tr>
            <td class="ps-3 text-muted small">{{ $i + 1 }}</td>
            <td class="fw-medium">{{ $c->title }}</td>
            <td class="text-muted small">{{ $c->location }}</td>
            <td>
              @if($c->status === 'Darurat')
                <span class="badge bg-danger">Darurat</span>
              @elseif($c->status === 'Waspada')
                <span class="badge bg-warning text-dark">Waspada</span>
              @else
                <span class="badge bg-success">Aktif</span>
              @endif
            </td>
            <td class="text-muted small">Rp {{ number_format($c->target_raw, 0, ',', '.') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection