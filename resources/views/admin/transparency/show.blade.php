@extends('admin.layouts.app')

@section('title', 'Detail Laporan Transparansi')
@section('page_title', 'Detail Laporan Transparansi')

@push('styles')
<style>
  .detail-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
  }

  .detail-card h5 {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
  }

  .ikhtisar-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.6rem 0;
    border-bottom: 1px solid #f3f4f6;
    font-size: 0.9rem;
  }

  .ikhtisar-item:last-child { border-bottom: none; }

  .allocation-card {
    background: #f8fafc;
    border-radius: 12px;
    padding: 1rem;
    border: 1px solid #e5e7eb;
  }

  .allocation-card .label {
    font-size: 0.78rem;
    color: #64748b;
  }

  .allocation-card .amount {
    font-size: 0.95rem;
    font-weight: 700;
    color: #dc2626;
  }

  .timeline-item {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
  }

  .timeline-icon {
    width: 40px; height: 40px;
    border-radius: 50%;
    background: #2563eb;
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    font-size: 0.9rem;
  }

  .timeline-content {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
    flex: 1;
  }

  .doc-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f3f4f6;
  }

  .doc-item:last-child { border-bottom: none; }

  .doc-item .doc-name { font-size: 0.85rem; font-weight: 600; }
  .doc-item .doc-amount { font-size: 0.82rem; color: #dc2626; font-weight: 600; }
  .doc-item .doc-code { font-size: 0.72rem; color: #94a3b8; }

  .sidebar-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    padding: 1.25rem;
    margin-bottom: 1.25rem;
  }

  .badge-aktif      { background:#eff6ff; color:#2563eb; }
  .badge-penyaluran { background:#fffbeb; color:#d97706; }
  .badge-selesai    { background:#ecfdf5; color:#059669; }
  .badge-done       { background:#f5f3ff; color:#7c3aed; }

  .btn-save-status {
    background: #eff6ff;
    color: #2563eb;
    border: 1.5px solid #bfdbfe;
    border-radius: 8px;
    padding: 10px;
    font-size: 0.9rem;
    transition: all .2s;
  }
  .btn-save-status:hover {
    background: #dbeafe;
    color: #1d4ed8;
    border-color: #93c5fd;
    transform: translateY(-1px);
  }

  .btn-back {
    background: #fff;
    color: #475569;
    border: 1.5px solid #e2e8f0;
    border-radius: 999px;
    padding: 6px 16px;
    font-size: 0.85rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    transition: all .2s;
    text-decoration: none;
  }
  .btn-back:hover {
    background: #f8fafc;
    color: #1e293b;
    border-color: #cbd5e1;
    transform: translateY(-1px);
  }
</style>
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-file-lines text-info me-2"></i>Detail Laporan Transparansi</h5>
    <p class="text-muted small mb-0">Tinjau detail laporan dan perbarui status penyaluran.</p>
  </div>
    <a href="{{ route('admin.transparency.index') }}" class="btn-back">
      <i class="fa-solid fa-arrow-left me-2"></i>Kembali
  </a>
</div>

@php
  $campaign = $report->campaign;
  $badgeClass = match($report->status) {
    'Dalam Penyaluran' => 'badge-penyaluran',
    'Hampir Selesai'   => 'badge-selesai',
    'Selesai'          => 'badge-done',
    default            => 'badge-aktif',
  };
  $badgeIcon = match($report->status) {
    'Dalam Penyaluran' => 'fa-truck',
    'Hampir Selesai'   => 'fa-circle-check',
    'Selesai'          => 'fa-flag-checkered',
    default            => 'fa-circle-dot',
  };
  $imgPath = $campaign?->getRawOriginal('image');
  $imgUrl = $imgPath
    ? (str_starts_with($imgPath, 'storage/') ? asset($imgPath) : asset('storage/' . $imgPath))
    : null;
@endphp

<div class="row g-4">

  {{-- KONTEN KIRI --}}
  <div class="col-lg-8">

    {{-- Foto & Info Kampanye --}}
    <div class="detail-card p-0 overflow-hidden">
      @if($imgUrl)
        <img src="{{ $imgUrl }}" alt="{{ $campaign->title }}"
             style="width:100%; height:220px; object-fit:cover;">
      @endif
      <div class="p-4">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <div>
            <h5 class="fw-bold mb-1">{{ $campaign->title ?? '-' }}</h5>
            <div class="small text-muted">
              <i class="fa-solid fa-calendar me-1"></i>Tanggal laporan: {{ $report->date }}
            </div>
          </div>
          <span class="badge rounded-pill px-3 py-2 {{ $badgeClass }}">
            <i class="fa-solid {{ $badgeIcon }} me-1"></i>{{ $report->status }}
          </span>
        </div>
      </div>
    </div>

    {{-- Deskripsi --}}
    <div class="detail-card">
      <h5><i class="fa-solid fa-truck-ramp-box text-primary me-2"></i>Deskripsi Penyaluran Bantuan</h5>
      <p class="text-muted mb-0" style="line-height:1.8;">{{ $report->description }}</p>
    </div>

    {{-- Alokasi Belanja --}}
    @if($report->allocations->count())
    <div class="detail-card">
      <h5><i class="fa-solid fa-chart-pie text-warning me-2"></i>Rincian Alokasi Belanja</h5>
      <p class="text-muted small mb-3">Pembagian dana yang telah digunakan untuk operasional darurat lapangan.</p>
      <div class="row g-3">
        @foreach($report->allocations as $alloc)
        <div class="col-md-6">
          <div class="allocation-card">
            <div class="d-flex align-items-center gap-2 mb-2">
              <div style="width:36px;height:36px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center;">
                <i class="fa-solid {{ $alloc->icon ?? 'fa-box' }} text-primary" style="font-size:0.85rem;"></i>
              </div>
              <div class="fw-semibold" style="font-size:0.88rem;">{{ $alloc->kategori }}</div>
            </div>
            <p class="text-muted mb-2" style="font-size:0.78rem;">{{ $alloc->desc }}</p>
            <div class="d-flex justify-content-between align-items-center">
              <span class="label">Nominal Terpakai</span>
              <span class="amount">{{ $alloc->nominal }}</span>
            </div>
            <div class="progress mt-2" style="height:4px;border-radius:99px;">
              <div class="progress-bar" style="width:{{ $alloc->getRawOriginal('progress') ?? 100 }}%; background:#dc2626; border-radius:99px;"></div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    {{-- Timeline --}}
    @if($report->timeline->count())
    <div class="detail-card">
      <h5><i class="fa-solid fa-clock-rotate-left text-info me-2"></i>Timeline Penyaluran</h5>
      <p class="text-muted small mb-4">Urutan kronologis distribusi bantuan yang telah dilaksanakan oleh relawan SIGANA.</p>
      @foreach($report->timeline as $tl)
      <div class="timeline-item">
        <div class="timeline-icon">
          <i class="fa-solid {{ $tl->icon ?? 'fa-truck' }} fa-xs"></i>
        </div>
        <div class="timeline-content">
          <div class="small text-muted mb-1">
            <i class="fa-solid fa-calendar-days me-1"></i>{{ $tl->tanggal }}
          </div>
          <div class="fw-semibold mb-1">{{ $tl->judul }}</div>
          <p class="text-muted small mb-0">{{ $tl->deskripsi }}</p>
        </div>
      </div>
      @endforeach
    </div>
    @endif
    {{-- Galeri Bukti Foto Penyaluran --}}
      @if($report->evidence->count())
      <div class="detail-card">
        <h5><i class="fa-solid fa-images text-primary me-2"></i>Galeri Bukti Foto Penyaluran</h5>
        <p class="text-muted small mb-3">Dokumentasi foto penyaluran logistik dan pemeriksaan lapangan oleh relawan.</p>
        <div class="row g-3">
          @foreach($report->evidence as $i => $ev)
          <div class="col-md-4">
            <div class="rounded-3 overflow-hidden border" style="position:relative;">
              <a href="{{ $ev->photo_url }}" target="_blank">
                <img src="{{ $ev->photo_url }}" style="width:100%;height:150px;object-fit:cover;" alt="Foto Bukti {{ $i+1 }}">
              </a>
              <div class="px-2 py-1" style="background:#0f172a;color:#fff;font-size:0.72rem;text-align:center;">
                Foto Bukti #{{ $i + 1 }}
              </div>
            </div>
            @if($ev->desc)
              <p class="text-muted small mt-2 mb-0">{{ $ev->desc }}</p>
            @endif
          </div>
          @endforeach
        </div>
      </div>
      @endif

  </div>

  {{-- SIDEBAR KANAN --}}
  <div class="col-lg-4">

    {{-- Ikhtisar Penyaluran --}}
    <div class="sidebar-card">
      <h6 class="fw-bold mb-3">Ikhtisar Penyaluran</h6>

      <div class="ikhtisar-item">
        <span class="text-muted">Dana Terkumpul</span>
        <span class="fw-semibold text-primary">{{ $report->collected }}</span>
      </div>
      <div class="ikhtisar-item">
        <span class="text-muted">Alokasi Digunakan</span>
        <span class="fw-semibold text-danger">{{ $report->used }}</span>
      </div>
      <div class="ikhtisar-item">
        <span class="text-muted">Sisa Saldo Cadangan</span>
        <span class="fw-semibold">{{ $report->remaining }}</span>
      </div>
      @if($report->beneficiaries)
      <div class="ikhtisar-item">
        <span class="text-muted">Korban Terbantu</span>
        <span class="fw-semibold text-success">{{ number_format($report->beneficiaries, 0, ',', '.') }} Jiwa</span>
      </div>
      @endif
      <div class="ikhtisar-item">
        <span class="text-muted">Progress Penyaluran</span>
        <span class="fw-semibold" style="color:{{ $report->progress_color }};">{{ $report->progress }}</span>
      </div>
      <div class="progress mt-2" style="height:8px; border-radius:99px;">
        <div class="progress-bar" role="progressbar"
             style="width:{{ $report->progress_raw }}%; background:{{ $report->progress_color }}; border-radius:99px;">
        </div>
      </div>
    </div>

    {{-- Update Status --}}
    <div class="sidebar-card">
      <h6 class="fw-bold mb-3">Perbarui Status</h6>
      <form action="{{ route('admin.transparency.update', $report) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
          <label for="status" class="form-label small fw-medium">Status Laporan</label>
          <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
            @foreach($statusOptions as $value => $label)
              <option value="{{ $value }}" {{ old('status', $report->status) == $value ? 'selected' : '' }}>
                {{ $label }}
              </option>
            @endforeach
          </select>
          @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <button type="submit" class="btn-save-status w-100">
          <i class="fa-solid fa-check me-2"></i>Simpan Perubahan
        </button>
      </form>
    </div>

    {{-- Dokumen Pendukung --}}
    @if($report->docs->count())
    <div class="sidebar-card">
      <h6 class="fw-bold mb-3">Kuitansi & Dokumen Pendukung</h6>
      @foreach($report->docs as $doc)
      <div class="doc-item">
        <div>
          <div class="doc-name">{{ Str::limit($doc->nama, 30) }}</div>
          @if($doc->getRawOriginal('nominal') > 0)
            <div class="doc-amount">{{ $doc->nominal }}</div>
          @endif
          <div class="doc-code">{{ $doc->doc_id ?? '' }}</div>
        </div>
        <a href="{{ Storage::url($doc->file) }}" target="_blank"
          class="btn btn-sm btn-outline-primary rounded-3" style="font-size:0.75rem;">
          <i class="fa-solid fa-download me-1"></i>Unduh
        </a>
      </div>
      @endforeach
    </div>
    @endif

  </div>
</div>
@endsection