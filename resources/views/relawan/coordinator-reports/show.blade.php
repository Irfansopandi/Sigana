@extends('relawan.layouts.app')

@section('title', 'Detail Laporan — ' . $coordinatorReport->title)
@section('page_title', 'Detail Laporan')

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

  .hero-img {
    width: 100%;
    height: 280px;
    object-fit: cover;
    border-radius: 16px 16px 0 0;
  }
  .hero-img-placeholder {
    width: 100%;
    height: 280px;
    border-radius: 16px 16px 0 0;
    background: linear-gradient(135deg, #e2e8f0, #f1f5f9);
    display: flex; align-items: center; justify-content: center;
    color: #94a3b8; font-size: 3rem;
  }

  .info-card {
    border-radius: 16px;
    border: none;
  }

  .status-pill {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 5px 14px;
    border-radius: 99px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .status-pending  { background:#fef9c3; color:#854d0e; }
  .status-approved { background:#dcfce7; color:#166534; }
  .status-rejected { background:#fee2e2; color:#991b1b; }

  .sidebar-card {
    border-radius: 16px;
    border: none;
  }
  .sidebar-card .card-header {
    background: #fff;
    border-bottom: 1px solid #f1f5f9;
    border-radius: 16px 16px 0 0 !important;
    padding: 16px 20px;
    font-weight: 700;
    font-size: 0.92rem;
    color: #0a2540;
  }
  .summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    border-bottom: 1px solid #f8fafc;
    font-size: 0.85rem;
  }
  .summary-row:last-child { border-bottom: none; }
  .summary-label { color: #64748b; }
  .summary-value { font-weight: 700; color: #0f172a; }

  .progress-thin { height: 8px; border-radius: 99px; }

  .section-card {
    border-radius: 16px;
    border: none;
    margin-bottom: 1.25rem;
  }
  .section-card .card-header {
    background: #fff;
    border-bottom: 1px solid #f1f5f9;
    border-radius: 16px 16px 0 0 !important;
    padding: 16px 20px;
    font-weight: 700;
    font-size: 0.92rem;
    color: #0a2540;
  }
  .section-card .card-body { padding: 20px; }

  .alloc-item {
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 14px;
    height: 100%;
  }
  .alloc-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: #eff6ff;
    color: #2563eb;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.9rem;
    margin-bottom: 8px;
  }
  .alloc-amount { font-weight: 700; color: #0f172a; font-size: 0.95rem; }

  .timeline-wrap { position: relative; }
  .timeline-item {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    position: relative;
    margin-bottom: 20px;
  }
  .timeline-item:last-child { margin-bottom: 0; }
  .timeline-item::before {
    content: '';
    position: absolute;
    left: 17px;
    top: 36px;
    bottom: -20px;
    width: 2px;
    background: #e2e8f0;
    z-index: 1;
  }
  .timeline-item:last-child::before { display: none; }
  .timeline-dot {
    position: relative;
    z-index: 2;
    width: 36px; height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem;
    flex-shrink: 0;
    box-shadow: 0 0 0 4px #fff;
  }
  .timeline-card {
    flex: 1;
    min-width: 0;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 14px 18px;
    transition: border-color .2s, box-shadow .2s;
  }
  .timeline-card:hover {
    border-color: #bfdbfe;
    box-shadow: 0 4px 14px rgba(37,99,235,0.08);
  }

  .gallery-thumb {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 12px 12px 0 0;
  }
  .gallery-caption {
    background: #0f172a;
    color: #fff;
    font-size: 0.75rem;
    padding: 8px 12px;
    border-radius: 0 0 12px 12px;
    text-align: center;
  }
  .gallery-card {
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 16px;
  }

  .doc-item {
    display: flex;
    align-items: center;
    gap: 12px;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px 16px;
    margin-bottom: 10px;
  }
  .doc-icon {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: #fef2f2;
    color: #dc2626;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .btn-download {
    background: #eff6ff; color: #2563eb; border: 1.5px solid #bfdbfe;
    border-radius: 8px; font-size: 0.78rem; padding: 5px 12px;
    margin-left: auto; transition: all .2s;
    white-space: nowrap;
    text-decoration: none;
  }
  .btn-download:hover { background: #2563eb; color: #fff; border-color: #2563eb; }

  .rejection-note {
    background: #fef2f2;
    border-left: 4px solid #dc2626;
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 1.25rem;
  }

  .btn-edit-report {
    background: #fffbeb; color: #92400e; border: 1.5px solid #fde68a;
    border-radius: 8px; font-size: 0.85rem; padding: 8px 18px; font-weight: 600;
    transition: all .2s;
    text-decoration: none;
  }
  .btn-edit-report:hover { background: #d97706; color: #fff; border-color: #d97706; }
</style>
@endpush

@section('content')

<div class="mb-3 d-flex justify-content-between align-items-start flex-wrap gap-2">
  <a href="{{ route('relawan.coordinator-reports.index') }}" class="back-link">
    <i class="fa-solid fa-arrow-left"></i> Kembali ke Laporan Bencana
  </a>
  @if($coordinatorReport->status !== 'approved')
    <a href="{{ route('relawan.coordinator-reports.edit', $coordinatorReport->id) }}" class="btn-edit-report">
      <i class="fa-solid fa-pen me-1"></i>Edit Laporan
    </a>
  @endif
</div>

@if($coordinatorReport->status === 'rejected' && $coordinatorReport->rejection_note)
  <div class="rejection-note">
    <div class="fw-bold mb-1" style="color:#991b1b;font-size:0.88rem;">
      <i class="fa-solid fa-circle-exclamation me-1"></i>Laporan Ditolak
    </div>
    <div class="small" style="color:#991b1b;">{{ $coordinatorReport->rejection_note }}</div>
  </div>
@endif

<div class="row g-4">
  {{-- ── MAIN COLUMN ── --}}
  <div class="col-lg-8">

    <div class="card info-card shadow-sm mb-4">
      @if($coordinatorReport->photos->first())
        <img src="{{ Storage::url($coordinatorReport->photos->first()->photo) }}" class="hero-img" alt="cover">
      @else
        <div class="hero-img-placeholder"><i class="fa-solid fa-image"></i></div>
      @endif
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
          <h5 class="fw-bold mb-0">{{ $coordinatorReport->title }}</h5>
          @if($coordinatorReport->status === 'pending')
            <span class="status-pill status-pending"><i class="fa-solid fa-hourglass-half"></i> Menunggu Verifikasi</span>
          @elseif($coordinatorReport->status === 'approved')
            <span class="status-pill status-approved"><i class="fa-solid fa-circle-check"></i> Disetujui</span>
          @else
            <span class="status-pill status-rejected"><i class="fa-solid fa-circle-xmark"></i> Ditolak</span>
          @endif
        </div>
        <div class="small text-muted">
          <i class="fa-solid fa-map-location-dot me-1"></i>{{ $coordinatorReport->campaign->title ?? '-' }}
          <span class="mx-2">&middot;</span>
          <i class="fa-regular fa-calendar me-1"></i>Tanggal laporan: {{ \Carbon\Carbon::parse($coordinatorReport->reported_at)->translatedFormat('d F Y') }}
        </div>
      </div>
    </div>

    {{-- Deskripsi --}}
    <div class="card section-card shadow-sm">
      <div class="card-header"><i class="fa-solid fa-hands-holding-child me-2 text-primary"></i>Deskripsi Penyaluran Bantuan</div>
      <div class="card-body">
        <p class="mb-0" style="font-size:0.9rem;color:#334155;">{{ $coordinatorReport->description }}</p>
      </div>
    </div>

    {{-- Rincian Alokasi --}}
    @if($coordinatorReport->items->isNotEmpty())
      <div class="card section-card shadow-sm">
        <div class="card-header"><i class="fa-solid fa-chart-pie me-2 text-warning"></i>Rincian Alokasi Belanja</div>
        <div class="card-body">
          <p class="text-muted small mb-3">Pembagian dana yang telah digunakan untuk operasional lapangan.</p>
          <div class="row g-3">
            @php
              $allocIconMap = [
                'makan'    => 'fa-bowl-food',
                'nasi'     => 'fa-bowl-food',
                'logistik' => 'fa-truck-fast',
                'air'      => 'fa-droplet',
                'minum'    => 'fa-droplet',
                'selimut'  => 'fa-mug-hot',
                'pakaian'  => 'fa-shirt',
                'baju'     => 'fa-shirt',
                'obat'     => 'fa-kit-medical',
                'medis'    => 'fa-kit-medical',
                'kesehatan'=> 'fa-kit-medical',
                'tenda'    => 'fa-campground',
                'evakuasi' => 'fa-people-carry-box',
                'transport'=> 'fa-truck',
                'bensin'   => 'fa-gas-pump',
                'operasional' => 'fa-briefcase',
                'listrik'  => 'fa-bolt',
                'penerangan' => 'fa-lightbulb',
                'sanitasi' => 'fa-pump-soap',
                'bayi'     => 'fa-baby',
                'anak'     => 'fa-child-reaching',
              ];
              $getAllocIcon = function ($text) use ($allocIconMap) {
                $text = strtolower($text);
                foreach ($allocIconMap as $keyword => $icon) {
                  if (str_contains($text, $keyword)) return $icon;
                }
                return 'fa-box';
              };
            @endphp
            @foreach($coordinatorReport->items as $item)
              @php $icon = $getAllocIcon($item->category . ' ' . $item->description); @endphp
              <div class="col-md-6">
                <div class="alloc-item">
                  <div class="alloc-icon"><i class="fa-solid {{ $icon }}"></i></div>
                  <div class="fw-semibold mb-1" style="font-size:0.88rem;">{{ $item->category }}</div>
                  @if($item->description)
                    <div class="small text-muted mb-2">{{ $item->description }}</div>
                  @endif
                  <div class="alloc-amount">Rp{{ number_format($item->amount, 0, ',', '.') }}</div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    @endif

    {{-- Timeline --}}
    @if($coordinatorReport->timelines->isNotEmpty())
      <div class="card section-card shadow-sm">
        <div class="card-header"><i class="fa-solid fa-timeline me-2 text-info"></i>Timeline Kegiatan</div>
        <div class="card-body">
          <div class="timeline-wrap">
            @foreach($coordinatorReport->timelines->sortBy('date') as $tl)
              <div class="timeline-item">
                <div class="timeline-dot"><i class="fa-solid fa-truck-fast"></i></div>
                <div class="timeline-card">
                  <div class="small text-muted mb-1">
                    <i class="fa-regular fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($tl->date)->translatedFormat('d F Y') }}
                  </div>
                  <div class="fw-semibold mb-1" style="font-size:0.88rem;">{{ $tl->title }}</div>
                  @if($tl->description)
                    <div class="small text-muted">{{ $tl->description }}</div>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    @endif

    {{-- Galeri Foto --}}
    @if($coordinatorReport->photos->isNotEmpty())
      <div class="card section-card shadow-sm">
        <div class="card-header"><i class="fa-solid fa-images me-2 text-primary"></i>Galeri Bukti Foto Penyaluran</div>
        <div class="card-body">
          <p class="text-muted small mb-3">Dokumentasi foto penyaluran bantuan di lapangan.</p>
          <div class="row g-3">
            @foreach($coordinatorReport->photos as $i => $photo)
              <div class="col-md-4">
                <div class="gallery-card">
                  <a href="{{ Storage::url($photo->photo) }}" target="_blank">
                    <img src="{{ Storage::url($photo->photo) }}" class="gallery-thumb" alt="Foto Bukti">
                  </a>
                  <div class="gallery-caption">{{ $photo->caption ?: 'Foto Bukti #' . ($i + 1) }}</div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    @endif

  </div>

  {{-- ── SIDEBAR ── --}}
  <div class="col-lg-4">
    @php
      $collectedRaw = $coordinatorReport->campaign->collected_raw ?? 0;
      $used         = $coordinatorReport->total_distribution;
      $remaining     = max($collectedRaw - $used, 0);
      $progress      = $collectedRaw > 0 ? min(round(($used / $collectedRaw) * 100, 1), 100) : 0;
    @endphp

    <div class="card sidebar-card shadow-sm mb-4">
      <div class="card-header"><i class="fa-solid fa-chart-line me-2 text-primary"></i>Ikhtisar Penyaluran</div>
      <div class="card-body p-0">
        <div class="summary-row">
          <span class="summary-label">Dana Terkumpul</span>
          <span class="summary-value" style="color:#2563eb;">Rp{{ number_format($collectedRaw, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
          <span class="summary-label">Alokasi Digunakan</span>
          <span class="summary-value" style="color:#dc2626;">Rp{{ number_format($used, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
          <span class="summary-label">Sisa Saldo Cadangan</span>
          <span class="summary-value">Rp{{ number_format($remaining, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
          <span class="summary-label">Korban Terbantu</span>
          <span class="summary-value" style="color:#166534;">{{ $coordinatorReport->victim_helped }} Jiwa</span>
        </div>
        <div class="summary-row">
          <span class="summary-label">Progress Penyaluran</span>
          @if($collectedRaw > 0)
            <span class="summary-value" style="color:#2563eb;">{{ $progress }}%</span>
          @else
            <span class="summary-value text-muted" style="font-size:0.78rem;font-weight:600;">Belum ada dana terkumpul</span>
          @endif
        </div>
        <div class="px-4 pb-4 pt-1">
          @if($collectedRaw > 0)
            <div class="progress progress-thin">
              <div class="progress-bar bg-primary" style="width:{{ $progress }}%;"></div>
            </div>
          @else
            <div class="progress progress-thin">
              <div class="progress-bar" style="width:100%;background:#e2e8f0;"></div>
            </div>
          @endif
        </div>
      </div>
    </div>

    @if($coordinatorReport->verifiedBy)
      <div class="card sidebar-card shadow-sm mb-4">
        <div class="card-header"><i class="fa-solid fa-user-check me-2 text-success"></i>Verifikasi Admin</div>
        <div class="card-body">
          <div class="small text-muted mb-1">Diverifikasi oleh</div>
          <div class="fw-semibold mb-2" style="font-size:0.88rem;">{{ $coordinatorReport->verifiedBy->name }}</div>
          @if($coordinatorReport->verified_at)
            <div class="small text-muted">
              <i class="fa-regular fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($coordinatorReport->verified_at)->translatedFormat('d F Y, H:i') }}
            </div>
          @endif
        </div>
      </div>
    @endif

    @if($coordinatorReport->documents->isNotEmpty())
      <div class="card sidebar-card shadow-sm mb-4">
        <div class="card-header"><i class="fa-solid fa-paperclip me-2 text-secondary"></i>Kuitansi &amp; Dokumen Pendukung</div>
        <div class="card-body">
          @foreach($coordinatorReport->documents as $doc)
            <div class="doc-item">
              <div class="doc-icon"><i class="fa-solid fa-file"></i></div>
              <div class="flex-grow-1 min-w-0">
                <div class="fw-semibold" style="font-size:0.83rem;">{{ $doc->name }}</div>
                @if($doc->code)
                  <div class="small text-muted">Kode: {{ $doc->code }}</div>
                @endif
              </div>
              <a href="{{ Storage::url($doc->file) }}" target="_blank" class="btn-download">
                <i class="fa-solid fa-download me-1"></i>Unduh
              </a>
            </div>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</div>

@endsection