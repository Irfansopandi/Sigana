@extends('relawan.layouts.app')

@section('title', 'Detail Relawan — ' . $campaign->title)
@section('page_title', 'Detail Relawan')

@push('styles')
<style>
  .back-link {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 0.85rem;
  font-weight: 600;
  color: #64748b;
  text-decoration: none;
  background: #fff;
  border: 1.5px solid #e2e8f0;
  border-radius: 8px;
  padding: 8px 16px;
  transition: all .2s ease;
}
.back-link:hover {
  color: #fff;
  background: #0a2540;
  border-color: #0a2540;
  transform: translateY(-1px);
}

  .hero-banner {
    border-radius: 18px;
    overflow: hidden;
    position: relative;
    min-height: 200px;
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
  }
  .hero-banner img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    opacity: .45;
  }
  .hero-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 28px 28px 24px;
    background: linear-gradient(to top, rgba(15,23,42,.85) 0%, transparent 60%);
  }
  .hero-status-badge {
    display: inline-block;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: .5px;
    text-transform: uppercase;
    padding: 3px 12px;
    border-radius: 99px;
    margin-bottom: 8px;
  }
  .hero-title {
    color: #fff;
    font-size: 1.35rem;
    font-weight: 700;
    line-height: 1.3;
    margin: 0 0 6px;
  }
  .hero-meta {
    color: rgba(255,255,255,.72);
    font-size: 0.8rem;
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
  }

  /* ── Role Group Card ── */
  .role-group-card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 2px 12px rgba(15,23,42,.07);
    transition: box-shadow .2s;
    overflow: hidden;
  }
  .role-group-card:hover { box-shadow: 0 8px 24px rgba(15,23,42,.12); }

  .role-group-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 20px;
    background: linear-gradient(135deg, #eff6ff 0%, #f0fdf4 100%);
    border-bottom: 1px solid #e2e8f0;
  }
  .role-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1rem;
    flex-shrink: 0;
  }
  .role-name {
    font-size: 1rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
  }
  .role-count-badge {
    margin-left: auto;
    background: #2563eb;
    color: #fff;
    border-radius: 99px;
    padding: 2px 12px;
    font-size: 0.75rem;
    font-weight: 600;
  }

  /* ── Volunteer Item ── */
  .vol-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
    transition: background .15s;
  }
  .vol-item:last-child { border-bottom: none; }
  .vol-item:hover { background: #f8fafc; }

  .vol-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, #38bdf8, #2563eb);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    font-weight: 700;
    color: #fff;
    flex-shrink: 0;
    overflow: hidden;
  }
  .vol-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .vol-name {
    font-weight: 600;
    font-size: 0.88rem;
    color: #0f172a;
    margin: 0;
  }
  .vol-meta {
    font-size: 0.75rem;
    color: #64748b;
    margin: 2px 0 0;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
  }
  .coordinator-badge {
    margin-left: auto;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #fef9c3;
    color: #854d0e;
    border-radius: 99px;
    padding: 3px 10px;
    font-size: 0.72rem;
    font-weight: 600;
    flex-shrink: 0;
  }
  .keahlian-tag {
    display: inline-block;
    background: #eff6ff;
    color: #2563eb;
    border-radius: 6px;
    padding: 1px 8px;
    font-size: 0.68rem;
    font-weight: 600;
    margin-right: 3px;
    margin-top: 2px;
  }

  .summary-bar {
    background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
    border-radius: 14px;
    padding: 18px 22px;
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 24px;
  }
  .summary-bar .num {
    font-size: 2rem;
    font-weight: 800;
    color: #0369a1;
    line-height: 1;
  }
  .summary-bar .lbl {
    font-size: 0.8rem;
    color: #0369a1;
    font-weight: 500;
  }

  /* ── Coordinator Section ── */
  .coordinator-section {
    border-radius: 16px;
    overflow: hidden;
    border: 2px solid #f59e0b;
    box-shadow: 0 0 0 3px rgba(245,158,11,0.15), 0 4px 16px rgba(245,158,11,0.10);
    margin-bottom: 12px;
  }
  .coordinator-section-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border-bottom: 1px solid #fcd34d;
  }
  .coordinator-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1rem;
    flex-shrink: 0;
  }
  .coordinator-section-title {
    font-size: 1rem;
    font-weight: 700;
    color: #92400e;
    margin: 0;
  }
  .coordinator-label {
    margin-left: auto;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #fff;
    border-radius: 99px;
    padding: 3px 12px;
    font-size: 0.72rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    box-shadow: 0 2px 8px rgba(217,119,6,0.3);
  }
  .coordinator-vol-item {
    background: #fffbeb;
  }
  .coordinator-vol-item:hover { background: #fef3c7; }
</style>
@endpush

@section('content')

{{-- Back --}}
<a href="{{ url()->previous() }}" class="back-link mb-3 d-inline-flex">
  <i class="fa-solid fa-arrow-left"></i> Kembali ke Bencana Diikuti
</a>

{{-- Hero Banner --}}
<div class="hero-banner mb-4">
  @if($campaign->image)
    <img src="{{ $campaign->image_url }}" alt="{{ $campaign->title }}">
  @else
    <div style="height:220px;background:linear-gradient(135deg,#1e3a5f,#0f172a);"></div>
  @endif
  <div class="hero-overlay">
    @php
      $statusColor = match($campaign->status) {
        'Darurat' => 'background:#fee2e2;color:#991b1b',
        'Waspada' => 'background:#fef9c3;color:#854d0e',
        default   => 'background:#dcfce7;color:#166534',
      };
    @endphp
    <span class="hero-status-badge" style="{{ $statusColor }}">{{ $campaign->status }}</span>
    <h1 class="hero-title">{{ $campaign->title }}</h1>
    <div class="hero-meta">
      <span><i class="fa-solid fa-location-dot me-1"></i>{{ $campaign->location }}</span>
      @if($campaign->user)
        <span><i class="fa-solid fa-user me-1"></i>Pelapor: {{ $campaign->user->name }}</span>
      @else
        <span><i class="fa-solid fa-user-shield me-1"></i>Dibuat oleh Admin</span>
      @endif
    </div>
  </div>
</div>

{{-- Summary Bar --}}
@php
  $totalRelawan = $grouped->flatten()->count() + ($coordinator ? 1 : 0);
  $kelompokCount = $grouped->count();
@endphp
<div class="summary-bar">
  <div style="width:48px;height:48px;border-radius:12px;background:rgba(3,105,161,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
    <i class="fa-solid fa-users" style="color:#0369a1;font-size:1.25rem;"></i>
  </div>
  <div>
    <div class="num">{{ $totalRelawan }}</div>
    <div class="lbl">Relawan Diterima · {{ $kelompokCount }} Kelompok Tugas{{ $coordinator ? ' · 1 Koordinator' : '' }}</div>
  </div>
</div>

{{-- Coordinator Section (shown first if exists) --}}
@if($coordinator)
  <div class="coordinator-section mb-3">
    <div class="coordinator-section-header">
      <div class="coordinator-icon">
        <i class="fa-solid fa-crown"></i>
      </div>
      <div>
        <p class="coordinator-section-title">Koordinator Bencana</p>
      </div>
      <span class="coordinator-label">
        <i class="fa-solid fa-crown"></i> Koordinator
      </span>
    </div>
    <div class="vol-item coordinator-vol-item">
      {{-- Avatar --}}
      <div class="vol-avatar" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
        @if($coordinator->user?->photo)
          <img src="{{ asset('storage/' . $coordinator->user->photo) }}" alt="{{ $coordinator->user->name }}">
        @else
          {{ strtoupper(substr($coordinator->user?->name ?? '?', 0, 1)) }}
        @endif
      </div>
      {{-- Info --}}
      <div class="flex-grow-1 min-w-0">
        <p class="vol-name">{{ $coordinator->user?->name ?? '—' }}</p>
        <div class="vol-meta">
          @if($coordinator->user?->phone)
            <span><i class="fa-solid fa-phone me-1"></i>{{ $coordinator->user->phone }}</span>
          @endif
          @if($coordinator->joined_at)
            <span><i class="fa-solid fa-calendar me-1"></i>Bergabung {{ $coordinator->joined_at->format('d M Y') }}</span>
          @endif
        </div>
        @if(!empty($coordinator->keahlian))
          <div class="mt-1">
            @foreach($coordinator->keahlian as $skill)
              <span class="keahlian-tag">{{ $skill }}</span>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>
@endif

{{-- Grouped Volunteer List --}}
@if($grouped->isEmpty() && !$coordinator)
  <div class="card border-0 shadow-sm text-center py-5" style="border-radius:16px;">
    <i class="fa-solid fa-user-slash fa-2x mb-3 d-block" style="color:#cbd5e1;"></i>
    <p class="text-muted mb-0">Belum ada relawan yang diterima di bencana ini.</p>
  </div>
@else
  <div class="d-flex flex-column gap-3">
    @foreach($grouped as $roleName => $volunteers)
    <div class="card role-group-card">
      <div class="role-group-header">
        <div class="role-icon">
          <i class="fa-solid fa-list-check"></i>
        </div>
        <div>
          <p class="role-name">{{ $roleName }}</p>
        </div>
        <span class="role-count-badge">{{ $volunteers->count() }} relawan</span>
      </div>

      @foreach($volunteers as $cv)
      <div class="vol-item">
        {{-- Avatar --}}
        <div class="vol-avatar">
          @if($cv->user?->photo)
            <img src="{{ asset('storage/' . $cv->user->photo) }}" alt="{{ $cv->user->name }}">
          @else
            {{ strtoupper(substr($cv->user?->name ?? '?', 0, 1)) }}
          @endif
        </div>

        {{-- Info --}}
        <div class="flex-grow-1 min-w-0">
          <p class="vol-name">{{ $cv->user?->name ?? '—' }}</p>
          <div class="vol-meta">
            @if($cv->user?->phone)
              <span><i class="fa-solid fa-phone me-1"></i>{{ $cv->user->phone }}</span>
            @endif
            @if($cv->joined_at)
              <span><i class="fa-solid fa-calendar me-1"></i>Bergabung {{ $cv->joined_at->format('d M Y') }}</span>
            @endif
          </div>
          @if(!empty($cv->keahlian))
            <div class="mt-1">
              @foreach($cv->keahlian as $skill)
                <span class="keahlian-tag">{{ $skill }}</span>
              @endforeach
            </div>
          @endif
        </div>
      </div>
      @endforeach
    </div>
    @endforeach
  </div>
@endif

@endsection
