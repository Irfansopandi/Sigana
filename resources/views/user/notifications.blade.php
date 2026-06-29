@extends('user.layouts.app')

@section('title', 'Notifikasi')
@section('page_title', 'Notifikasi')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-1">
  <div class="d-flex align-items-center gap-3">
    <div class="rounded-3 p-2" style="background: rgba(99,102,241,0.1);">
      <i class="fa-solid fa-bell fs-5" style="color:#6366f1;"></i>
    </div>
    <div>
      <h5 class="fw-bold mb-0">Notifikasi</h5>
      <p class="text-muted small mb-0">Semua notifikasi aktivitas akun Anda.</p>
    </div>
  </div>
  <a href="{{ route('user.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
    <i class="fa-solid fa-arrow-left me-1"></i>Kembali
  </a>
</div>
<hr class="mb-4">

<div class="card border-0 shadow-sm">
  <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-4">
    <span class="fw-semibold">Semua Notifikasi</span>
    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">
      {{ $notifications->total() }} notifikasi
    </span>
  </div>
  <div class="card-body p-0">
    @forelse($notifications as $notif)
    @php
      $icons = [
        'campaign_approved'   => ['icon' => 'fa-circle-check',       'color' => '#22c55e', 'bg' => 'rgba(34,197,94,0.1)'],
        'campaign_rejected'   => ['icon' => 'fa-circle-xmark',       'color' => '#ef4444', 'bg' => 'rgba(239,68,68,0.1)'],
        'donation_success'    => ['icon' => 'fa-heart',              'color' => '#ec4899', 'bg' => 'rgba(236,72,153,0.1)'],
        'transparency_update' => ['icon' => 'fa-file-lines',         'color' => '#6366f1', 'bg' => 'rgba(99,102,241,0.1)'],
        'new_campaign'        => ['icon' => 'fa-hand-holding-heart', 'color' => '#f59e0b', 'bg' => 'rgba(245,158,11,0.1)'],
      ];
      $ic = $icons[$notif->type] ?? ['icon' => 'fa-bell', 'color' => '#6b7280', 'bg' => 'rgba(107,114,128,0.1)'];
    @endphp
    <div class="d-flex gap-3 px-4 py-3 border-bottom {{ !$notif->is_read ? 'bg-light' : '' }}"
         style="transition: background .2s;">
      {{-- Icon --}}
      <div class="rounded-3 p-2 flex-shrink-0" style="background:{{ $ic['bg'] }}; width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
        <i class="fa-solid {{ $ic['icon'] }}" style="color:{{ $ic['color'] }};"></i>
      </div>
      {{-- Content --}}
      <div class="flex-grow-1">
        <div class="d-flex justify-content-between align-items-start">
          <div class="small fw-semibold text-dark">{{ $notif->title }}</div>
          @if(!$notif->is_read)
            <span class="badge rounded-pill ms-2 flex-shrink-0" style="background:#6366f1; font-size:.6rem;">Baru</span>
          @endif
        </div>
        <div class="small text-muted mt-1">{{ $notif->message }}</div>
        <div class="small text-muted mt-1">
          <i class="fa-regular fa-clock me-1"></i>{{ $notif->created_at->diffForHumans() }}
        </div>
        @if($notif->url)
        <a href="{{ $notif->url }}" class="small mt-1 d-inline-block" style="color:#6366f1;">
          Lihat detail <i class="fa-solid fa-arrow-right ms-1" style="font-size:.65rem;"></i>
        </a>
        @endif
      </div>
    </div>
    @empty
    <div class="text-center text-muted py-5">
      <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
           style="width:64px;height:64px;background:rgba(99,102,241,0.1);">
        <i class="fa-solid fa-bell-slash fs-4" style="color:#6366f1;"></i>
      </div>
      <div class="fw-semibold">Belum ada notifikasi</div>
      <div class="small mt-1">Notifikasi aktivitas akun Anda akan muncul di sini.</div>
    </div>
    @endforelse
  </div>
</div>

@if($notifications->hasPages())
<div class="mt-4 d-flex justify-content-center">
  {{ $notifications->links() }}
</div>
@endif

@endsection