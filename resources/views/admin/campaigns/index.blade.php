@extends('admin.layouts.app')

@section('title', 'Kampanye Bencana')
@section('page_title', 'Kampanye Bencana')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-hand-holding-heart text-success me-2"></i>Kampanye Bencana</h5>
    <p class="text-muted small mb-0">Kelola kampanye bencana dan tinjau progres setiap program.</p>
  </div>
  <a href="{{ route('admin.campaigns.create') }}" class="btn btn-success btn-sm">
    <i class="fa-solid fa-plus me-2"></i>Tambah Kampanye
  </a>
</div>

<div class="row g-3">
  @forelse($campaigns as $campaign)
  <div class="col-lg-6">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div>
            <h6 class="fw-semibold mb-1">{{ $campaign->title }}</h6>
            <div class="small text-muted">{{ $campaign->location }}</div>
          </div>
          <span class="badge {{ $campaign->status_class }}">{{ $campaign->status }}</span>
        </div>
        <div class="small text-muted mb-2">Terkumpul {{ $campaign->collected }} dari {{ $campaign->target }}</div>
        <div class="progress" style="height: 8px;">
          <div class="progress-bar" role="progressbar" style="width: {{ $campaign->progress_raw }}%; background: {{ $campaign->progress_color }};" aria-valuenow="{{ $campaign->progress_raw }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="mt-3 d-flex justify-content-between align-items-center">
          <span class="small text-muted">{{ $campaign->progress }}</span>
          <a href="{{ route('admin.campaigns.show', $campaign) }}" class="link-primary small">Detail</a>
        </div>
      </div>
    </div>
  </div>
  @empty
  <div class="col-12 text-center text-muted">Belum ada kampanye pada saat ini.</div>
  @endforelse
</div>

<div class="mt-4">{{ $campaigns->links() }}</div>
@endsection
