@extends('admin.layouts.app')

@section('title', 'Detail Kampanye')
@section('page_title', 'Detail Kampanye')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-circle-info text-primary me-2"></i>{{ $campaign->title }}</h5>
    <p class="text-muted small mb-0">Rincian lengkap kampanye bencana dan status dana terkumpul.</p>
  </div>
  <div class="d-flex flex-wrap gap-2">
    <a href="{{ route('admin.campaigns.edit', $campaign) }}" class="btn btn-warning btn-sm">
      <i class="fa-solid fa-pen-to-square me-2"></i>Edit
    </a>
    <form action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kampanye ini?');">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger btn-sm">
        <i class="fa-solid fa-trash me-2"></i>Hapus
      </button>
    </form>
    <a href="{{ route('admin.campaigns.index') }}" class="btn btn-outline-secondary btn-sm">
      <i class="fa-solid fa-arrow-left me-2"></i>Kembali
    </a>
  </div>
</div>

<div class="row g-4">
  <div class="col-xl-8">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <div class="mb-4">
          <img src="{{ $campaign->image ? asset('storage/' . $campaign->image) : asset('storage/assets/default-campaign.jpg') }}" class="img-fluid rounded-4 w-100" alt="{{ $campaign->title }}">
        </div>

        <div class="mb-4">
          <h6 class="fw-semibold">Deskripsi Singkat</h6>
          <p class="text-muted">{{ $campaign->description_short }}</p>
        </div>

        <div class="mb-4">
          <h6 class="fw-semibold">Deskripsi Lengkap</h6>
          <p class="text-muted">{{ $campaign->description_long }}</p>
        </div>

        <div class="row g-3">
          <div class="col-md-6">
            <div class="p-3 rounded-4 border bg-light">
              <div class="small text-muted">Kategori</div>
              <div class="fw-semibold">{{ $campaign->category }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="p-3 rounded-4 border bg-light">
              <div class="small text-muted">Lokasi</div>
              <div class="fw-semibold">{{ $campaign->location }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="p-3 rounded-4 border bg-light">
              <div class="small text-muted">Tanggal Publikasi</div>
              <div class="fw-semibold">{{ $campaign->date_published }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="p-3 rounded-4 border bg-light">
              <div class="small text-muted">Jumlah Korban</div>
              <div class="fw-semibold">{{ $campaign->victims ?? '-' }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-4">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div>
            <div class="small text-muted">Status</div>
            <span class="badge {{ $campaign->status_class }}">{{ $campaign->status }}</span>
          </div>
          <div class="text-end">
            <div class="small text-muted">Sisa Hari</div>
            <div class="fw-semibold">{{ $campaign->days_left }}</div>
          </div>
        </div>

        <div class="mb-3">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="small text-muted">Target Donasi</span>
            <span class="fw-semibold">{{ $campaign->target }}</span>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="small text-muted">Terkumpul</span>
            <span class="fw-semibold">{{ $campaign->collected }}</span>
          </div>
          <div class="progress" style="height: 12px;">
            <div class="progress-bar" role="progressbar" style="width: {{ $campaign->progress_raw }}%; background: {{ $campaign->progress_color }};" aria-valuenow="{{ $campaign->progress_raw }}" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <div class="mt-2 small text-muted">{{ $campaign->progress }} terkumpul</div>
        </div>

        <div class="mt-4">
          <h6 class="fw-semibold mb-2">Koordinat</h6>
          <div class="small text-muted">Latitude</div>
          <div class="mb-2 fw-semibold">{{ $campaign->latitude ?? '-' }}</div>
          <div class="small text-muted">Longitude</div>
          <div class="fw-semibold">{{ $campaign->longitude ?? '-' }}</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection