@extends('admin.layouts.app')

@section('title', 'Notifikasi')
@section('page_title', 'Notifikasi')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <div class="d-flex align-items-center gap-3">
    <div class="rounded-3 p-2 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width:44px;height:44px;">
      <i class="fa-solid fa-bell fa-lg"></i>
    </div>
    <div>
      <h5 class="fw-bold mb-0">Notifikasi</h5>
      <p class="text-muted small mb-0">Semua notifikasi aktivitas sistem SIGANA.</p>
    </div>
  </div>
  <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-3">
    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
  </a>
</div>

<div class="card border-0 shadow-sm">
  <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
    <h6 class="fw-semibold mb-0">Semua Notifikasi</h6>
    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">{{ $sorted->count() }} notifikasi</span>
  </div>
  <div class="card-body p-0">
    @forelse($sorted as $n)
      <a href="{{ $n['url'] }}" class="d-flex gap-3 px-4 py-3 text-decoration-none border-bottom">
        <div class="mt-1">
          @switch($n['type'])
            @case('campaign_pending')
              <i class="fa-solid fa-triangle-exclamation text-warning"></i>
              @break
            @case('donation_success')
              <i class="fa-solid fa-heart" style="color:#ec4899"></i>
              @break
            @case('coordinator_report')
              <i class="fa-solid fa-clipboard-check text-primary"></i>
              @break
            @case('campaign_expired')
              <i class="fa-solid fa-clock-rotate-left text-muted"></i>
              @break
          @endswitch
        </div>
        <div class="flex-grow-1">
          <div class="fw-semibold text-dark">{{ $n['title'] }}</div>
          <div class="text-muted small">{{ $n['message'] }}</div>
        </div>
        <div class="text-muted small text-nowrap">{{ \Carbon\Carbon::parse($n['time'])->diffForHumans() }}</div>
      </a>
    @empty
      <div class="text-center text-muted py-5">
        <i class="fa-solid fa-bell-slash fa-2x mb-3 d-block opacity-30"></i>
        Belum ada notifikasi.
      </div>
    @endforelse
  </div>
</div>

@endsection