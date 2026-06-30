@extends('relawan.layouts.app')

@section('title', 'Notifikasi Relawan')
@section('page_title', 'Notifikasi')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <div class="d-flex align-items-center gap-3">
    <div class="rounded-3 p-2 d-flex align-items-center justify-content-center"
         style="width:44px;height:44px;background:rgba(56,189,248,.12);">
      <i class="fa-solid fa-bell fa-lg" style="color:var(--cyan)"></i>
    </div>
    <div>
      <h5 class="fw-bold mb-0">Notifikasi Saya</h5>
      <p class="text-muted small mb-0">Semua aktivitas dan pembaruan untuk akun relawan Anda.</p>
    </div>
  </div>
  <a href="{{ route('relawan.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-3">
    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
  </a>
</div>

<div class="card border-0 shadow-sm">
  <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
    <h6 class="fw-semibold mb-0">Semua Notifikasi</h6>
    <span class="badge rounded-pill px-3 py-2"
          style="background:rgba(56,189,248,.12);color:var(--cyan);">
      {{ $sorted->count() }} notifikasi
    </span>
  </div>
  <div class="card-body p-0">
    @forelse($sorted as $n)
      <a href="{{ $n['url'] }}" class="d-flex gap-3 px-4 py-3 text-decoration-none border-bottom notif-row {{ $n['type'] === 'coordinator_appointed' ? 'notif-row-coordinator' : '' }}">
        <div class="mt-1 notif-icon-wrap">
          @switch($n['type'])
            @case('account_verified')
              <i class="fa-solid fa-circle-check" style="color:#22c55e;font-size:1.1rem;"></i>
              @break
            @case('account_pending')
              <i class="fa-solid fa-clock-rotate-left" style="color:#f59e0b;font-size:1.1rem;"></i>
              @break
            @case('coordinator_appointed')
              <i class="fa-solid fa-crown" style="color:#f59e0b;font-size:1.1rem;"></i>
              @break
            @case('join_accepted')
              <i class="fa-solid fa-handshake" style="color:#38bdf8;font-size:1.1rem;"></i>
              @break
            @case('join_rejected')
              <i class="fa-solid fa-circle-xmark" style="color:#ef4444;font-size:1.1rem;"></i>
              @break
            @case('join_pending')
              <i class="fa-solid fa-hourglass-half" style="color:#94a3b8;font-size:1.1rem;"></i>
              @break
            @case('new_campaign')
              <i class="fa-solid fa-triangle-exclamation" style="color:#f97316;font-size:1.1rem;"></i>
              @break
            @default
              <i class="fa-solid fa-bell text-muted" style="font-size:1.1rem;"></i>
          @endswitch
        </div>
        <div class="flex-grow-1">
          <div class="fw-semibold text-dark small">{{ $n['title'] }}</div>
          <div class="text-muted small">{{ $n['message'] }}</div>
        </div>
        <div class="text-muted" style="font-size:.75rem;white-space:nowrap;">
          {{ \Carbon\Carbon::parse($n['time'])->diffForHumans() }}
        </div>
      </a>
    @empty
      <div class="text-center text-muted py-5">
        <i class="fa-solid fa-bell-slash fa-2x mb-3 d-block opacity-30"></i>
        Belum ada notifikasi.
      </div>
    @endforelse
  </div>
</div>

@push('styles')
<style>
  .notif-row {
    transition: background .15s;
    color: inherit;
  }
  .notif-row:hover {
    background: #f8fafc;
  }
  .notif-icon-wrap {
    width: 28px;
    flex-shrink: 0;
    display: flex;
    align-items: flex-start;
    justify-content: center;
  }
  .notif-row-coordinator {
    background: #fffbeb;
    border-left: 3px solid #f59e0b !important;
  }
  .notif-row-coordinator:hover {
    background: #fef3c7 !important;
  }
</style>
@endpush

@endsection
