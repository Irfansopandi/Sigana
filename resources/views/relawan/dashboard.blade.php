@extends('relawan.layouts.app')

@section('title', 'Dashboard Relawan')
@section('page_title', 'Dashboard Relawan')

@section('content')

<div class="mb-4">
  <h5 class="fw-bold mb-1">
    <i class="bi bi-shield-fill-check text-danger me-2"></i>Halo, {{ auth()->user()->name }}!
  </h5>
  <p class="text-muted small mb-0">Terima kasih sudah menjadi relawan SIGANA. Semangat bertugas hari ini!</p>
</div>

<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-4">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-3 p-3" style="background:#eff6ff;">
          <i class="fa-solid fa-map-location-dot fa-lg" style="color:#3b82f6;"></i>
        </div>
        <div>
          <div class="text-muted small">Bencana Aktif</div>
          <div class="fw-bold fs-5">{{ \App\Models\Campaign::where('status', 'Darurat')->count() }}</div>
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
          <div class="text-muted small">Total Kampanye</div>
          <div class="fw-bold fs-5">{{ \App\Models\Campaign::count() }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-4">
    <div class="card border-0 shadow-sm h-100">
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

<div class="card border-0 shadow-sm">
  <div class="card-header bg-white border-0 pt-3 pb-0">
    <h6 class="fw-semibold mb-0">Kampanye Bencana Terkini</h6>
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
            <th>Sisa Hari</th>
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
            <td class="text-muted small">{{ $c->days_left }} hari</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection