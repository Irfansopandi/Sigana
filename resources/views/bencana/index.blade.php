@extends('layouts.app')

@section('title', 'Daftar Bencana & Kampanye Donasi — SIGANA')
@section('meta_description', 'Ulurkan tangan Anda untuk membantu korban bencana alam di Indonesia. Pantau penggalangan dana dan penyaluran bantuan secara real-time dan 100% transparan.')
@section('body_class', 'page-dark-hero')

@section('content')

{{-- ========================
     Hero Daftar Bencana
======================== --}}
<section class="disaster-hero-section">
  <div class="disaster-hero-overlay"></div>
  <div class="container position-relative z-2">
    <div class="row align-items-center justify-content-center text-center">
      <div class="col-lg-8 animate-on-scroll animate-fade-in-left">
        <span class="section-tag section-tag-white mb-4">
          <i class="fa-solid fa-heart me-1"></i> Aksi Kemanusiaan
        </span>
        <h1 class="disaster-hero-title">Ulurkan Tangan, Bantu <span>Saudara Kita</span></h1>
        <p class="disaster-hero-desc">
          Daftar penggalangan dana dan kampanye donasi bencana aktif yang terverifikasi. Seluruh bantuan disalurkan secara cepat dan terpantau dengan transparansi penuh.
        </p>
        <div class="about-hero-breadcrumb">
          <a href="{{ route('home') }}" class="breadcrumb-link"><i class="fa-solid fa-house me-1"></i>Beranda</a>
          <i class="fa-solid fa-chevron-right mx-2 text-white-50"></i>
          <span class="text-white">Bencana</span>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ========================
     Pencarian & Filter Panel
======================== --}}
<section class="container" style="position: relative; z-index: 10;">
  <div class="search-filter-panel animate-on-scroll">
    <div class="row g-4 align-items-center">
      <!-- Search Input -->
      <div class="col-lg-4 col-12">
        <div class="search-input-wrapper">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="text" id="searchInput" class="form-control" placeholder="Cari lokasi atau nama bencana...">
        </div>
      </div>
      <!-- Category Filter (Desktop) -->
      <div class="col-lg-5 d-none d-lg-block">
        <div class="filter-categories-container" id="categoryFilterContainer">
          <button class="filter-cat-btn active" data-category="all">Semua</button>
          <button class="filter-cat-btn" data-category="banjir">Banjir</button>
          <button class="filter-cat-btn" data-category="gempa">Gempa</button>
          <button class="filter-cat-btn" data-category="erupsi">Erupsi</button>
          <button class="filter-cat-btn" data-category="lainnya">Lainnya</button>
        </div>
      </div>
      <!-- Category Select (Mobile & Tablet) -->
      <div class="col-md-6 col-12 d-lg-none">
        <select id="mobileCategorySelect" class="form-select filter-select">
          <option value="all">Semua Kategori</option>
          <option value="banjir">Banjir</option>
          <option value="gempa">Gempa Bumi</option>
          <option value="erupsi">Erupsi Gunung Berapi</option>
          <option value="lainnya">Lainnya / Kemanusiaan</option>
        </select>
      </div>
      <!-- Sort Select -->
      <div class="col-md-6 col-lg-3 col-12">
        <select id="sortSelect" class="form-select filter-select">
          <option value="newest">Urutkan: Terbaru</option>
          <option value="days-left">Sisa Hari Terdekat</option>
          <option value="target-highest">Target Tertinggi</option>
          <option value="target-lowest">Target Terendah</option>
          <option value="progress-highest">Progress Tertinggi</option>
        </select>
      </div>
    </div>
  </div>
</section>

{{-- ========================
     Grid Daftar Kampanye
======================== --}}
<section class="disaster-grid-section bg-light-section">
  <div class="container">
    <div class="row g-4" id="campaignsGrid">
      
      <!-- Card 1: Banjir Demak -->
      @forelse($campaigns as $campaign)
      <div class="col-md-6 col-lg-4 campaign-card-item" 
          data-name="{{ strtolower($campaign->title . ' ' . $campaign->location) }}"
          data-category="{{ $campaign->category }}"
          data-target="{{ $campaign->target_raw }}"
          data-collected="{{ $campaign->collected_raw }}"
          data-progress="{{ $campaign->progress_raw }}"
          data-days="{{ $campaign->days_left }}"
          data-date="{{ strtotime($campaign->getRawOriginal('date_published')) }}">
        <div class="card h-100 campaign-card border-0 shadow-sm">
          <div class="campaign-img-wrapper position-relative" style="height: 200px;">
            <span class="badge {{ $campaign->status_class }} position-absolute top-3 start-3 z-3" style="padding: 6px 12px; font-weight: 600;"><i class="{{ $campaign->status_icon }} me-1"></i> {{ $campaign->status }}</span>
            <img src="{{ asset($campaign->image) }}" class="card-img-top w-100 h-100 object-fit-cover" alt="{{ $campaign->title }}">
          </div>
          <div class="card-body p-4 d-flex flex-column">
            <div class="campaign-location mb-3">
              <i class="fa-solid fa-location-dot me-1 text-danger"></i> {{ $campaign->location }}
            </div>
            <h5 class="card-title fw-bold mb-3" style="font-size: 1.15rem;">{{ $campaign->title }}</h5>
            <p class="card-text text-muted mb-4 flex-grow-1" style="font-size: 0.9rem; line-height: 1.6;">
              {{ $campaign->description_short }}
            </p>
            <div class="campaign-progress-block mb-3">
              <div class="d-flex justify-content-between mb-2">
                <span class="small text-muted">Terkumpul: <strong>{{ $campaign->collected }}</strong></span>
                <span class="small text-primary fw-bold">{{ $campaign->progress }}</span>
              </div>
              <div class="progress" style="height: 8px; border-radius: 4px;">
              <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $campaign->progress }}; background-color: {{ $campaign->progress_color }} !important;" aria-valuenow="{{ $campaign->progress_raw }}" aria-valuemin="0" aria-valuemax="100"></div>              </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
              <span class="small text-muted">Target: <strong>{{ $campaign->target }}</strong></span>
              <span class="small text-muted"><i class="fa-regular fa-clock me-1 text-warning"></i> {{ $campaign->days_left }} hari lagi</span>
            </div>
            <div class="d-flex gap-2 mt-auto">
              <a href="{{ route('bencana.detail', $campaign->slug) }}" class="btn flex-fill text-center"
                style="border-radius:12px; border:1.5px solid #2563eb; color:#2563eb; background:rgba(37,99,235,0.08); transition:all 0.3s ease;"
                onmouseover="this.style.background='rgba(37,99,235,0.15)';this.style.boxShadow='0 6px 20px rgba(37,99,235,0.2)';"
                onmouseout="this.style.background='rgba(37,99,235,0.08)';this.style.boxShadow='none';">
                Detail
              </a>
              @auth
                @if(auth()->user()->role === 'relawan')
                  <a href="{{ route('register.relawan') }}" class="btn flex-fill text-center"
                    style="border-radius:12px; border:1.5px solid #ef4444; color:#ef4444; background:rgba(239,68,68,0.08); transition:all 0.3s ease;"
                    onmouseover="this.style.background='rgba(239,68,68,0.15)';this.style.boxShadow='0 6px 20px rgba(239,68,68,0.2)';"
                    onmouseout="this.style.background='rgba(239,68,68,0.08)';this.style.boxShadow='none';">
                    <i class="fa-solid fa-user-plus me-1"></i>Gabung Relawan
                  </a>
                @else
                  <a href="{{ route('bencana.donasi', $campaign->slug) }}" class="btn flex-fill text-center"
                    style="border-radius:12px; border:1.5px solid #16a34a; color:#16a34a; background:rgba(22,163,74,0.08); transition:all 0.3s ease;"
                    onmouseover="this.style.background='rgba(22,163,74,0.15)';this.style.boxShadow='0 6px 20px rgba(22,163,74,0.2)';"
                    onmouseout="this.style.background='rgba(22,163,74,0.08)';this.style.boxShadow='none';">
                    <i class="fa-solid fa-hand-holding-heart me-1"></i>Donasi
                  </a>
                @endif
              @else
                <a href="{{ route('bencana.donasi', $campaign->slug) }}" class="btn flex-fill text-center"
                  style="border-radius:12px; border:1.5px solid #16a34a; color:#16a34a; background:rgba(22,163,74,0.08); transition:all 0.3s ease;"
                  onmouseover="this.style.background='rgba(22,163,74,0.15)';this.style.boxShadow='0 6px 20px rgba(22,163,74,0.2)';"
                  onmouseout="this.style.background='rgba(22,163,74,0.08)';this.style.boxShadow='none';">
                  <i class="fa-solid fa-hand-holding-heart me-1"></i>Donasi
                </a>
              @endauth
            </div>
          </div>
        </div>
      </div>
      @empty
        <p class="text-muted text-center py-5">Belum ada kampanye bencana yang aktif saat ini.</p>
      @endforelse
      </div>

          <!-- Fallback Empty State -->
          <div id="emptyState" class="d-none empty-state-wrapper animate-on-scroll">
            <div class="empty-state-icon"><i class="fa-regular fa-folder-open text-muted"></i></div>
            <h3 class="empty-state-title">Kampanye Tidak Ditemukan</h3>
            <p class="empty-state-desc">Maaf, kami tidak dapat menemukan kampanye bencana yang cocok dengan kata kunci atau filter Anda. Silakan coba pencarian lain.</p>
          </div>

        </div>
</section>

{{-- ========================
     CTA Pelaporan & Relawan
======================== --}}
<section class="py-5" style="background: var(--white);">
  <div class="container py-3">
    <div class="about-cta-card animate-on-scroll">
      <div class="row align-items-center g-4">
        <div class="col-lg-7">
          <span class="section-tag section-tag-white mb-3">
            <i class="fa-solid fa-hands-holding-child me-1"></i> 
              @auth @if(auth()->user()->role === 'user') Tanggap Darurat @else Bergabunglah @endif @else Bergabunglah @endauth
            </span>
          <h2 class="fw-bold text-white mb-3" style="font-size: 2rem;">
            @auth
              @if(auth()->user()->role === 'user')
                Laporkan Kejadian Bencana di Sekitar Anda
              @else
                Jadilah Bagian dari Gerakan Kemanusiaan Indonesia
              @endif
            @else
              Jadilah Bagian dari Gerakan Kemanusiaan Indonesia
            @endauth
          </h2>
          <p class="text-white mb-0" style="opacity: 0.85; line-height: 1.7;">
            @auth
              @if(auth()->user()->role === 'user')
                Mengetahui ada kejadian bencana alam yang belum tertangani? Laporkan segera ke platform kami agar tim relawan dan dinas sosial dapat berkoordinasi melakukan penanganan dan membuka galang dana darurat.
              @else
                Ribuan relawan dan donatur sudah bersama kami. Setiap kontribusi Anda, sekecil apapun, bermakna besar bagi korban bencana yang membutuhkan pertolongan segera.
              @endif
            @else
              Ribuan relawan dan donatur sudah bersama kami. Setiap kontribusi Anda, sekecil apapun, bermakna besar bagi korban bencana yang membutuhkan pertolongan segera.
            @endauth
          </p>
        </div>

        <div class="col-lg-5 text-lg-end d-flex flex-column flex-lg-row gap-3 justify-content-lg-end">
          <a href="{{ route('bencana') }}" class="btn btn-donasi d-flex align-items-center justify-content-center gap-2">
            <i class="fa-solid fa-heart"></i> Donasi Sekarang
          </a>
          @guest
          <a href="{{ route('register.relawan') }}" class="btn btn-relawan btn-outline-light about-cta-btn-outline d-flex align-items-center justify-content-center gap-2">
            <i class="fa-solid fa-user-plus"></i> Daftar Relawan
          </a>
          @endguest
          @auth
            @if(auth()->user()->role === 'user')
            <a href="{{ route('user.lapor-bencana.store') }}" class="btn btn-lapor d-flex align-items-center justify-content-center gap-2">
              <i class="fa-solid fa-triangle-exclamation"></i> Laporkan Bencana
            </a>
            @else
            <a href="{{ route('register.relawan') }}" class="btn btn-relawan btn-outline-light about-cta-btn-outline d-flex align-items-center justify-content-center gap-2">
              <i class="fa-solid fa-user-plus"></i> Daftar Relawan
            </a>
            @endif
          @endauth
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
