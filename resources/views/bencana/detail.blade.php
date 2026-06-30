@extends('layouts.app')

@section('title', $campaign->title . ' — SIGANA')
@section('meta_description', $campaign->description_short)
@section('body_class', 'page-dark-hero')

@section('content')

{{-- ========================
     Hero Detail Bencana
======================== --}}
<section class="disaster-hero-section">
  <div class="disaster-hero-overlay"></div>
  <div class="container position-relative z-2">
    <div class="row align-items-center justify-content-center text-center">
      <div class="col-lg-8 animate-on-scroll animate-fade-in-left">
        <span class="section-tag section-tag-white mb-4">
          <i class="fa-solid fa-heart me-1"></i> Aksi Kemanusiaan
        </span>
        <h1 class="disaster-hero-title">Detail Kampanye: <span>{{ $campaign->title }}</span></h1>
          <div class="about-hero-breadcrumb">
            <a href="{{ route('home') }}" class="breadcrumb-link"><i class="fa-solid fa-house me-1"></i>Beranda</a>
            <i class="fa-solid fa-chevron-right mx-2 text-white-50"></i>
            <a href="{{ route('bencana') }}" class="breadcrumb-link">Bencana</a>
            <i class="fa-solid fa-chevron-right mx-2 text-white-50"></i>
            <span class="text-white">{{ $campaign->title }}</span>
          </div>
      </div>
    </div>
  </div>
</section>

{{-- ========================
     Main Layout Detail
======================== --}}
<section class="py-5 bg-light-section">
  <div class="container py-3">
    <div class="row g-5">
      
      {{-- Kolom Kiri: Detail & Cerita Bencana --}}
      <div class="col-lg-8">
        <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm border border-light">
          <!-- Main Image -->
          @php
            $imgPath = $campaign->getRawOriginal('image');
            $imgUrl = $imgPath
              ? (str_starts_with($imgPath, 'storage/') ? asset($imgPath) : asset('storage/' . $imgPath))
              : null;
          @endphp
          <div class="position-relative rounded-4 overflow-hidden mb-4 shadow-sm" style="max-height: 450px;">
            <span class="badge {{ $campaign->status_class }} position-absolute top-3 start-3 z-3 px-3 py-2 fs-6 fw-bold">
              <i class="fa-solid fa-triangle-exclamation me-1"></i> Status: {{ $campaign->status }}
            </span>
            @if($imgUrl)
              <img src="{{ $imgUrl }}" class="w-100 object-fit-cover" style="min-height: 300px; max-height: 450px;" alt="{{ $campaign->title }}">
            @else
              <div class="w-100 d-flex align-items-center justify-content-center" style="min-height: 300px; background:#f1f5f9;color:#94a3b8;">
                <i class="fa-solid fa-image fa-3x"></i>
              </div>
            @endif
          </div>

          <!-- Meta Info -->
          <div class="d-flex flex-wrap gap-4 align-items-center mb-4 pb-4 border-bottom border-light">
            <div class="d-flex align-items-center gap-2 text-muted">
              <i class="fa-solid fa-location-dot text-danger fs-5"></i>
                <span class="fw-semibold text-dark">{{ $campaign->location }}</span>
            </div>
            <div class="d-flex align-items-center gap-2 text-muted">
              <i class="fa-regular fa-calendar text-primary fs-5"></i>
                <span>Diterbitkan: <strong>{{ $campaign->date_published }}</strong></span>
            </div>
            <div class="d-flex align-items-center gap-2 text-muted">
              <i class="fa-solid fa-tag text-success fs-5"></i>
              <span class="text-capitalize">Kategori: <strong>{{ $campaign->category }}</strong></span>
            </div>
            <div class="d-flex align-items-center gap-2 text-muted">
              <i class="fa-solid fa-users text-danger fs-5"></i>
              <span>Korban Terdampak: <strong>{{ number_format($campaign->victims, 0, ',', '.') }} Jiwa</strong></span>
            </div>
          </div>

          <!-- Description / Story -->
          <div class="mb-5">
            <h4 class="fw-bold mb-4 text-dark"><i class="fa-solid fa-book-open text-primary me-2"></i>Cerita Penggalangan Dana</h4>
            <div class="text-muted" style="line-height: 1.85; font-size: 1.05rem;">
              <p class="mb-4">{{ $campaign->description_short }}</p>
              <p class="mb-0">{{ $campaign->description_long }}</p>
            </div>
          </div>

          <!-- Urgent Needs -->
          <div class="mb-5">
            <h4 class="fw-bold mb-4 text-dark"><i class="fa-solid fa-truck-ramp-box text-primary me-2"></i>Kebutuhan Logistik Mendesak</h4>
            <p class="text-muted mb-4">Berikut adalah barang dan dukungan logistik darurat yang sangat dibutuhkan pengungsi di lapangan:</p>
            <div class="row g-3">
              @foreach($campaign->needs as $need)
                <div class="col-md-6">
                  <div class="need-item-card d-flex align-items-center p-3 rounded-3 bg-light border border-light h-100">
                    <div class="d-flex align-items-center justify-content-center bg-white text-primary rounded-circle shadow-sm" style="width: 48px; height: 48px; flex-shrink: 0;">
                      <i class="{{ $need->icon }} fs-5"></i>
                    </div>
                    <div class="ms-3">
                      <h6 class="mb-1 fw-bold text-dark">{{ $need->name }}</h6>
                      <span class="small text-muted">Target Kebutuhan: <strong>{{ $need->qty }}</strong></span>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          {{-- Documentation / Field Gallery --}}
          @php $docs = array_filter([$campaign->documentation_1, $campaign->documentation_2, $campaign->documentation_3]); @endphp
          @if(!empty($docs))
          <div class="mb-5">
            <h4 class="fw-bold mb-4 text-dark"><i class="fa-solid fa-camera text-primary me-2"></i>Dokumentasi Kondisi Lapangan</h4>
            <div class="row g-3">
              @foreach($docs as $i => $doc)
                @php $ext = strtolower(pathinfo($doc, PATHINFO_EXTENSION)); @endphp
                <div class="col-4">
                  @if(in_array($ext, ['jpg','jpeg','png','webp']))
                    <a href="{{ url('storage/' . $doc) }}" target="_blank" class="d-block rounded-3 overflow-hidden shadow-sm ratio ratio-4x3">
                      <img src="{{ url('storage/' . $doc) }}" class="doc-gallery-img object-fit-cover w-100 h-100" alt="Dokumentasi {{ $i+1 }}">
                    </a>
                  @else
                    <a href="{{ url('storage/' . $doc) }}" target="_blank" class="d-flex flex-column align-items-center justify-content-center rounded-3 shadow-sm ratio ratio-4x3 bg-light text-decoration-none">
                      <i class="fa-solid fa-file-pdf text-danger fs-1 mb-2"></i>
                      <span class="small text-dark">Lihat PDF</span>
                    </a>
                  @endif
                </div>
              @endforeach
            </div>
          </div>
          @endif

          <!-- Recent Donors -->
          <div>
            <h4 class="fw-bold mb-4 text-dark"><i class="fa-solid fa-hand-holding-heart text-primary me-2"></i>Donatur Terbaru</h4>
            <div class="d-flex flex-column gap-3">
              @foreach($donors as $donor)
                <div class="donor-item-card d-flex p-3 rounded-3 bg-light border border-light align-items-start">
                  <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold text-white shadow-sm flex-shrink-0" 
                       style="width: 46px; height: 46px; font-size: 1.1rem; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);">
                    {{ substr($donor->name, 0, 1) }}
                  </div>
                  <div class="ms-3 flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                      <h6 class="mb-0 fw-bold text-dark">{{ $donor->name }}</h6>
                      <span class="small text-muted">{{ $donor->time }}</span>
                    </div>
                    <div class="mb-2">
                      <span class="badge bg-white text-primary border border-primary-subtle fw-bold">Berdonasi {{ $donor->amount }}</span>
                    </div>
                     <p class="mb-0 text-muted small" style="line-height: 1.5; font-style: italic;">"{{ $donor->message }}"</p>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

        </div>
      </div>

      {{-- Kolom Kanan: Sticky Donation Widget --}}
      <div class="col-lg-4">
        <div class="sticky-donation-widget bg-white rounded-4 p-4 shadow-sm border border-light" style="position: sticky; top: 100px;">
          <h5 class="fw-bold mb-4 text-dark">Informasi Penggalangan</h5>
          
          <div class="mb-4">
            <div class="d-flex justify-content-between mb-2">
              <span class="text-muted small">Terkumpul</span>
              <span class="text-primary fw-bold">{{ $campaign->progress }}</span>
            </div>
            <h3 class="fw-bold text-primary mb-3">{{ $campaign->collected }}</h3>
            <div class="progress mb-3" style="height: 10px; border-radius: 5px;">
              <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $campaign->progress }}; background-color: {{ $campaign->progress_color }} !important;" aria-valuenow="{{ $campaign->progress_raw }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="d-flex justify-content-between text-muted small mb-4">
              <span>Target: <strong>{{ $campaign->target }}</strong></span>
              <span><i class="fa-regular fa-clock me-1 text-warning"></i> <strong>{{ $campaign->days_left }} Hari</strong> Tersisa</span>
            </div>
          </div>

          <div class="d-grid gap-3 mb-4">
            <a href="{{ route('bencana.donasi', $campaign->slug) }}"
               class="btn btn-green-custom py-3" 
               style="border-radius: 12px; font-weight: 700; font-size: 1.05rem; text-decoration: none;">
              <i class="fa-solid fa-hand-holding-heart me-2"></i>Donasi Sekarang
            </a>
            <button class="btn btn-outline-secondary py-2" style="border-radius: 12px; font-weight: 600;" onclick="navigator.clipboard.writeText(window.location.href); this.innerHTML='<i class=\'fa-solid fa-check me-2\'></i>Link Disalin!'; setTimeout(()=>{this.innerHTML='<i class=\'fa-solid fa-share-nodes me-2\'></i>Bagikan Kampanye';}, 2000);">
              <i class="fa-solid fa-share-nodes me-2"></i>Bagikan Kampanye
            </button>
          </div>

          <!-- Trust verification badge -->
          <div class="p-3 bg-light rounded-3 border border-light">
            <div class="d-flex align-items-start">
              <i class="fa-solid fa-shield-heart text-success fs-3 flex-shrink-0 mt-1"></i>
              <div class="ms-3">
                <h6 class="mb-1 fw-bold text-dark small" style="font-size:0.85rem;">Terverifikasi Aman & Transparan</h6>
                <p class="mb-0 text-muted small" style="font-size:0.75rem; line-height: 1.4;">
                  Dana disalurkan melalui koordinasi ketat BNPB dan lembaga resmi terkait. Laporan keuangan terbit secara real-time.
                </p>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>

@section('meta')
@php
  $imgPath = $campaign->getRawOriginal('image');
  $imgUrl = $imgPath
    ? (str_starts_with($imgPath, 'storage/') ? asset($imgPath) : asset('storage/' . $imgPath))
    : asset('storage/assets/default-campaign.jpg');
@endphp
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $campaign->title }} — SIGANA">
<meta property="og:description" content="Sudah terkumpul {{ $campaign->collected }} dari target {{ $campaign->target }}. Yuk bantu donasi sekarang!">
<meta property="og:image" content="{{ $imgUrl }}">
<meta property="og:url" content="{{ route('bencana.detail', $campaign->slug) }}">
<meta property="og:site_name" content="SIGANA">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $campaign->title }} — SIGANA">
<meta name="twitter:description" content="Sudah terkumpul {{ $campaign->collected }} dari target {{ $campaign->target }}.">
<meta name="twitter:image" content="{{ $imgUrl }}">
@endsection
