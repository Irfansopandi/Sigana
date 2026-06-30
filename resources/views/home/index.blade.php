@extends('layouts.app')

<style>
#btn-lapor-hero,
#btn-donasi-hero {
  font-size: 0.85rem !important;
  padding: 0.75rem 1.2rem !important;
}

#btn-relawan-hero {
  font-size: 0.85rem;
  padding: 0.75rem 1.2rem !important;
  border: 1.5px solid #81878f;
  color: #81878f;
  background: transparent;
  border-radius: 50px;
  transition: all 0.3s ease;
  line-height: 1.5;
  display: inline-flex;
  align-items: center;
}

#btn-relawan-hero:hover {
  border-color: #111827;
  color: #111827;
  background: transparent;
  box-shadow: 0 6px 20px rgba(37, 35, 35, 0.294);
}

[data-bs-theme="dark"] #btn-relawan-hero {
  border-color: #475569;
  color: #94a3b8;
  background: transparent;
}

[data-bs-theme="dark"] #btn-relawan-hero:hover {
  border-color: #e2e8f0;
  color: #f1f5f9;
  background: transparent;
  box-shadow: 0 6px 20px rgba(255, 255, 255, 0.294);
}
</style>

@section('content')

{{-- Section: Hero --}}
<section class="hero-section" id="beranda">
  <div class="container">
    <div class="row align-items-center">

      {{-- Kiri: Teks --}}
      <div class="col-lg-6 hero-content animate-on-scroll animate-fade-in-left">
        <span class="section-tag"><i class="fa-solid fa-shield-halved me-1"></i> Tanggap & Terpercaya</span>
        <h1 class="hero-title">
          Bersama Membantu Korban Bencana dengan <span>Cepat & Transparan</span>
        </h1>
        <p class="hero-desc">
          Laporkan kejadian bencana di sekitar Anda dan salurkan bantuan kepada korban melalui platform digital yang
          aman, cepat, dan terpercaya.
        </p>
        <div class="hero-buttons" style="gap: 10px;">
        @auth
          @if(auth()->user()->role === 'admin')
            {{-- Admin: tidak dapat button apapun --}}

          @elseif(auth()->user()->role === 'relawan')
            {{-- Relawan: Laporan + Daftar Relawan (ke kampanye) --}}
            <a href="{{ route('user.lapor-bencana.store') }}" class="btn px-4 py-3" id="btn-lapor-hero"
              style="border-radius:50px; border:1.5px solid #ef4444; color:#ef4444; background:rgba(239,68,68,0.08); font-size:0.85rem; transition:all 0.3s ease;"
              onmouseover="this.style.background='rgba(239,68,68,0.15)';this.style.boxShadow='0 6px 20px rgba(239,68,68,0.2)';"
              onmouseout="this.style.background='rgba(239,68,68,0.08)';this.style.boxShadow='none';">
              <i class="fa-solid fa-triangle-exclamation me-2"></i>Laporkan Bencana
            </a>
            <a href="{{ route('bencana') }}" class="btn px-4 py-3"
              style="border-radius:50px; border:1.5px solid #6c757d; color:#6c757d; background:rgba(108,117,125,0.08); font-size:0.85rem; transition:all 0.3s ease;"
              onmouseover="this.style.background='rgba(108,117,125,0.15)';this.style.boxShadow='0 6px 20px rgba(108,117,125,0.2)';"
              onmouseout="this.style.background='rgba(108,117,125,0.08)';this.style.boxShadow='none';">
              <i class="fa-solid fa-hands-helping me-2"></i>Daftar Relawan
            </a>

          @elseif(auth()->user()->role === 'user')
            {{-- User: Laporan + Donasi --}}
            <a href="{{ route('user.lapor-bencana.store') }}" class="btn px-4 py-3" id="btn-lapor-hero"
              style="border-radius:50px; border:1.5px solid #ef4444; color:#ef4444; background:rgba(239,68,68,0.08); font-size:0.85rem; transition:all 0.3s ease;"
              onmouseover="this.style.background='rgba(239,68,68,0.15)';this.style.boxShadow='0 6px 20px rgba(239,68,68,0.2)';"
              onmouseout="this.style.background='rgba(239,68,68,0.08)';this.style.boxShadow='none';">
              <i class="fa-solid fa-triangle-exclamation me-2"></i>Laporkan Bencana
            </a>
            <a href="{{ route('bencana') }}" class="btn px-4 py-3"
              style="border-radius:50px; border:1.5px solid #16a34a; color:#16a34a; background:rgba(22,163,74,0.08); font-size:0.85rem; transition:all 0.3s ease;"
              onmouseover="this.style.background='rgba(22,163,74,0.15)';this.style.boxShadow='0 6px 20px rgba(22,163,74,0.2)';"
              onmouseout="this.style.background='rgba(22,163,74,0.08)';this.style.boxShadow='none';">
              <i class="fa-solid fa-hand-holding-heart me-2"></i>Donasi
            </a>

          @endif
        @else
          {{-- Guest: Laporan + Gabung Relawan + Donasi --}}
          <a href="#" class="btn px-4 py-3" id="btn-lapor-hero"
            data-bs-toggle="modal" data-bs-target="#modalAuthRequired"
            style="border-radius:50px; border:1.5px solid #ef4444; color:#ef4444; background:rgba(239,68,68,0.08); font-size:0.85rem; transition:all 0.3s ease;"
            onmouseover="this.style.background='rgba(239,68,68,0.15)';this.style.boxShadow='0 6px 20px rgba(239,68,68,0.2)';"
            onmouseout="this.style.background='rgba(239,68,68,0.08)';this.style.boxShadow='none';">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>Laporkan Bencana
          </a>
          <a href="{{ route('register.relawan') }}" class="btn px-4 py-3" id="btn-relawan-hero"
            style="border-radius:50px; border:1.5px solid #6c757d; color:#6c757d; background:rgba(108,117,125,0.08); font-size:0.85rem; transition:all 0.3s ease;"
            onmouseover="this.style.background='rgba(108,117,125,0.15)';this.style.boxShadow='0 6px 20px rgba(108,117,125,0.2)';"
            onmouseout="this.style.background='rgba(108,117,125,0.08)';this.style.boxShadow='none';">
            <i class="fa-solid fa-hands-helping me-2"></i>Gabung Relawan
          </a>
          <a href="{{ route('bencana') }}" class="btn px-4 py-3"
            style="border-radius:50px; border:1.5px solid #16a34a; color:#16a34a; background:rgba(22,163,74,0.08); font-size:0.85rem; transition:all 0.3s ease;"
            onmouseover="this.style.background='rgba(22,163,74,0.15)';this.style.boxShadow='0 6px 20px rgba(22,163,74,0.2)';"
            onmouseout="this.style.background='rgba(22,163,74,0.08)';this.style.boxShadow='none';">
            <i class="fa-solid fa-hand-holding-heart me-2"></i>Donasi
          </a>
        @endauth
      </div>
    </div> 

      {{-- Kanan: Hero Carousel --}}
      <div class="col-lg-6 mt-5 mt-lg-0 hero-image-wrapper text-center animate-on-scroll animate-fade-in-right">
        <div class="hero-carousel" id="heroCarousel">
          <div class="hero-carousel-track" id="heroCarouselTrack">

            {{-- Slide 1 --}}
            <div class="hero-slide">
              <div class="hero-slide-inner">
                <span class="hero-slide-badge">
                  <i class="fa-solid fa-bullhorn me-2"></i>Pelaporan Bencana
                </span>
                <img src="{{ asset('storage/assets/carasul/laporan.jpg') }}"
                  alt="Pelaporan Bencana" class="hero-image img-fluid">
              </div>
            </div>

            {{-- Slide 2 --}}
            <div class="hero-slide">
              <div class="hero-slide-inner">
                <span class="hero-slide-badge badge-green">
                  <i class="fa-solid fa-hand-holding-heart me-2"></i>Donasi Transparan
                </span>
                <img src="{{ asset('storage/assets/carasul/donasi.jpg') }}"
                  alt="Donasi Transparan" class="hero-image img-fluid">
              </div>
            </div>

            {{-- Slide 3 --}}
            <div class="hero-slide">
              <div class="hero-slide-inner">
                <span class="hero-slide-badge badge-blue">
                  <i class="fa-solid fa-magnifying-glass-chart me-2"></i>Monitoring Bantuan
                </span>
                <img src="{{ asset('storage/assets/carasul/monitoring.jpg') }}"
                  alt="Monitoring Bantuan" class="hero-image img-fluid">
              </div>
            </div>

          </div>

          {{-- Dots --}}
          <div class="hero-carousel-dots">
            <span class="hero-dot active" data-index="0"></span>
            <span class="hero-dot" data-index="1"></span>
            <span class="hero-dot" data-index="2"></span>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>  

{{-- Section: Tentang Kami --}}
<section class="bg-light-section" id="tentang">
  <div class="container text-center">
    <span class="section-tag section-tag-red animate-on-scroll"><i class="fa-solid fa-circle-info me-1"></i> Tentang Kami</span>
    <h2 class="section-title animate-on-scroll">Apa itu SIGANA?</h2>
    <p class="section-desc animate-on-scroll">
      SIGANA (Sistem Informasi Tanggap Bencana dan Donasi) hadir sebagai solusi jembatan informasi antara pelapor bencana di lapangan, donatur, dan tim penyalur bantuan secara digital.
    </p>

    <div class="row g-4 text-start mt-2">
      <div class="col-md-6 col-lg-3 animate-on-scroll">
        <div class="tentang-box">
          <div class="tentang-icon">
            <i class="fa-solid fa-bullhorn"></i>
          </div>
          <h4>Pelaporan Bencana</h4>
          <p>Membantu masyarakat melaporkan kejadian bencana secara langsung dan cepat agar segera direspons oleh pihak terkait.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 animate-on-scroll">
        <div class="tentang-box red-theme">
          <div class="tentang-icon">
            <i class="fa-solid fa-database"></i>
          </div>
          <h4>Pengelolaan Informasi</h4>
          <p>Menyediakan data bencana yang terverifikasi dan akurat untuk meminimalkan persebaran berita bohong (hoaks).</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 animate-on-scroll">
        <div class="tentang-box">
          <div class="tentang-icon">
            <i class="fa-solid fa-hand-holding-dollar"></i>
          </div>
          <h4>Penggalangan Donasi</h4>
          <p>Platform pengumpulan dana dan bantuan logistik secara aman dengan berbagai alternatif metode pembayaran.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 animate-on-scroll">
        <div class="tentang-box red-theme">
          <div class="tentang-icon">
            <i class="fa-solid fa-magnifying-glass-chart"></i>
          </div>
          <h4>Transparansi Penyaluran</h4>
          <p>Menyajikan laporan keuangan dan distribusi logistik secara real-time yang dapat diakses oleh publik kapan saja.</p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Section: Fitur Utama Platform --}}
<section id="fitur">
  <div class="container text-center">
    <span class="section-tag animate-on-scroll"><i class="fa-solid fa-star me-1"></i> Fitur Unggulan</span>
    <h2 class="section-title animate-on-scroll">Fitur Utama Platform</h2>
    <p class="section-desc animate-on-scroll">
      Sistem kami dilengkapi berbagai fitur modern untuk menunjang aktivitas penanggulangan bencana dan pengelolaan donasi.
    </p>

    <div class="row g-4 text-start mt-2">
      <div class="col-md-4 animate-on-scroll">
        <div class="feature-card red-border">
          <div class="feature-icon-wrapper">
            <i class="fa-solid fa-triangle-exclamation feature-icon"></i>
          </div>
          <h4>1. Pelaporan Bencana</h4>
          <p>Masyarakat dapat melaporkan kejadian bencana dengan menyertakan lokasi, foto, dan deskripsi kondisi.</p>
        </div>
      </div>
      <div class="col-md-4 animate-on-scroll">
        <div class="feature-card">
          <div class="feature-icon-wrapper">
            <i class="fa-solid fa-hand-holding-heart feature-icon"></i>
          </div>
          <h4>2. Kampanye Donasi</h4>
          <p>Setiap bencana yang telah diverifikasi memiliki halaman kampanye donasi tersendiri dengan target dan progress donasi.</p>
        </div>
      </div>
      <div class="col-md-4 animate-on-scroll">
        <div class="feature-card green-border">
          <div class="feature-icon-wrapper">
            <i class="fa-solid fa-circle-dollar-to-slot feature-icon"></i>
          </div>
          <h4>3. Transparansi Donasi</h4>
          <p>Menampilkan informasi dana terkumpul, dana yang telah digunakan, serta sisa dana secara transparan.</p>
        </div>
      </div>
      <div class="col-md-4 animate-on-scroll">
        <div class="feature-card">
          <div class="feature-icon-wrapper">
            <i class="fa-solid fa-camera feature-icon"></i>
          </div>
          <h4>4. Dokumentasi Lapangan</h4>
          <p>Relawan mengunggah foto dan laporan kondisi terkini dari lokasi bencana untuk memastikan bantuan tepat sasaran.</p>
        </div>
      </div>
      <div class="col-md-4 animate-on-scroll">
        <div class="feature-card" style="--accent-color: #d97706;">
          <div class="feature-icon-wrapper">
            <i class="fa-solid fa-truck feature-icon" style="color: #d97706;"></i>
          </div>
          <h4>5. Monitoring Bantuan</h4>
          <p>Masyarakat dapat memantau perkembangan penyaluran bantuan dan kebutuhan korban secara real-time.</p>
        </div>
      </div>
      <div class="col-md-4 animate-on-scroll">
        <div class="feature-card red-border">
          <div class="feature-icon-wrapper">
            <i class="fa-solid fa-user-check feature-icon" style="color: #2563eb;"></i>
          </div>
          <h4>6. Verifikasi dan Validasi</h4>
          <p>Seluruh laporan bencana diverifikasi oleh admin sebelum dipublikasikan untuk menjaga keakuratan informasi.</p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Section: Statistik Real-time --}}
<section class="stats-section">
  <div class="container">
    <div class="row g-4 text-center justify-content-center">
      <div class="col-6 col-md-3 animate-on-scroll">
        <div class="stats-card">
          <div class="stats-icon"><i class="fa-solid fa-bullhorn" style="color: #f87171;"></i></div>
          <div class="stats-number" id="stat-laporan">{{ $totalKampanye }}</div>
          <div class="stats-label">Laporan Bencana</div>
        </div>
      </div>
      <div class="col-6 col-md-3 animate-on-scroll">
        <div class="stats-card">
          <div class="stats-icon"><i class="fa-solid fa-users" style="color: #60a5fa;"></i></div>
          <div class="stats-number" id="stat-donatur">{{ $totalDonatur }}</div>
          <div class="stats-label">Total Transaksi Donasi</div>
        </div>
      </div>
      <div class="col-6 col-md-3 animate-on-scroll">
        <div class="stats-card">
          <div class="stats-icon"><i class="fa-solid fa-rupiah-sign" style="color: #34d399;"></i></div>
          <div class="stats-number" id="stat-donasi">Rp{{ number_format($totalDonasi, 0, ',', '.') }}</div>
          <div class="stats-label">Donasi Terkumpul</div>
        </div>
      </div>
      <div class="col-6 col-md-3 animate-on-scroll">
        <div class="stats-card">
          <div class="stats-icon"><i class="fa-solid fa-heart-circle-check" style="color: #fbbf24;"></i></div>
          <div class="stats-number" id="stat-korban">{{ number_format($totalKorbanTerbantu, 0, ',', '.') }}</div>
          <div class="stats-label">Korban Terbantu</div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Section: Kampanye Donasi Kemanusiaan --}}
<section class="bg-light-section" id="donasi">
  <div class="container">
    <div class="text-center">
      <span class="section-tag section-tag-red animate-on-scroll"><i class="fa-solid fa-heart me-1"></i> Bencana Terbaru</span>
      <h2 class="section-title animate-on-scroll">Kampanye Donasi Kemanusiaan</h2>
      <p class="section-desc animate-on-scroll">
        Ulurkan tangan Anda untuk membantu saudara-saudara kita yang tertimpa musibah bencana alam melalui kampanye donasi aktif di bawah ini.
      </p>
    </div>

    <div class="row g-4 mt-2">
      @foreach($campaigns as $campaign)
      <div class="col-md-6 col-lg-4 animate-on-scroll">
        <div class="card h-100 campaign-card border-0 shadow-sm">
          <div class="campaign-img-wrapper position-relative" style="height: 200px;">
            <span class="badge {{ $campaign->status_class }} position-absolute top-3 start-3 z-3" style="padding: 6px 12px; font-weight: 600;"><i class="{{ $campaign->status_icon }} me-1"></i> {{ $campaign->status }}</span>
            @if($campaign->image_url)
              <img src="{{ $campaign->image_url }}" class="card-img-top w-100 h-100 object-fit-cover" alt="{{ $campaign->title }}">
            @else
              <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background:#f1f5f9;color:#94a3b8;">
                <i class="fa-solid fa-image fa-2x"></i>
              </div>
            @endif
          </div>
          <div class="card-body p-4 d-flex flex-column">
            <div class="campaign-location mb-3">
              <i class="fa-solid fa-location-dot me-1"></i> {{ $campaign->location }}
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
              <div class="progress" style="height: 8px;">
                <div class="progress-bar" role="progressbar" 
                    style="width: {{ $campaign->progress }}; background-color: {{ $campaign->progress_color }} !important;" 
                    aria-valuenow="{{ $campaign->progress_raw }}" 
                    aria-valuemin="0" aria-valuemax="100">
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
              <span class="small text-muted">Target: <strong>{{ $campaign->target }}</strong></span>
              <span class="small text-muted"><i class="fa-regular fa-clock me-1"></i> {{ $campaign->days_left }} hari lagi</span>
            </div>
            <div class="d-flex gap-2">
              <a href="{{ route('bencana.detail', $campaign->slug) }}" class="btn flex-fill text-center"
                style="border-radius:12px; border:1.5px solid #2563eb; color:#2563eb; background:rgba(37,99,235,0.08); transition:all 0.3s ease;"
                onmouseover="this.style.background='rgba(37,99,235,0.15)';this.style.boxShadow='0 6px 20px rgba(37,99,235,0.2)';"
                onmouseout="this.style.background='rgba(37,99,235,0.08)';this.style.boxShadow='none';">
                Detail
              </a>
              @auth
                @if(auth()->user()->role === 'relawan')
                  <a href="{{ route('relawan.volunteer-join.create', $campaign->id) }}" class="btn flex-fill text-center"
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
      @endforeach
    </div>
    <div class="text-center mt-5 animate-on-scroll">
      <a href="{{ route('bencana') }}" class="btn btn-primary px-5 py-3">
        <i class="fa-solid fa-list-check me-2"></i>Lihat Semua Kampanye Bencana
      </a>
    </div>
  </div>
</section>

{{-- Section: Transparansi Donasi --}}
<section id="laporan-transparansi">
  <div class="container">
    <div class="text-center">
      <span class="section-tag animate-on-scroll"><i class="fa-solid fa-magnifying-glass-chart me-1"></i> Transparansi</span>
      <h2 class="section-title animate-on-scroll">Transparansi Donasi dan Penyaluran Bantuan</h2>
      <p class="section-desc animate-on-scroll">
        Pantau penggunaan dana donasi dan perkembangan bantuan yang telah disalurkan kepada korban bencana secara transparan.
      </p>
    </div>

    <div class="row g-4 mt-2">
      @foreach($transparansi as $item)
      @if($item->transparencyReport)
      <div class="col-md-6 col-lg-4 animate-on-scroll">
        <div class="card h-100 transparency-card border-0 shadow-sm">
          <div class="transparency-img-wrapper">
            <div class="transparency-overlay">
              <span class="badge transparency-badge-{{ $item->transparencyReport->status_slug }} px-3 py-2">
                <i class="{{ $item->transparencyReport->status_icon }} me-1"></i> {{ $item->transparencyReport->status }}
              </span>
            </div>
            <img src="{{ $item->image_url }}" class="w-100 object-fit-cover" style="height: 200px;" alt="{{ $item->title }}">
          </div>
          <div class="card-body p-4 d-flex flex-column">
            <h5 class="fw-bold mb-1">{{ $item->title }}</h5>
            <div class="campaign-location mb-3">
              <i class="fa-solid fa-location-dot me-1"></i> {{ $item->location }}
            </div>
            <div class="transparency-fund-info mb-3">
              <div class="d-flex justify-content-between fund-row mb-1">
                <span class="text-muted small">Dana Terkumpul:</span>
                <strong class="text-primary small">{{ $item->collected }}</strong>
              </div>
              <div class="d-flex justify-content-between fund-row mb-3">
                <span class="text-muted small">Dana Digunakan:</span>
                <strong class="text-danger small">{{ $item->transparencyReport->used }}</strong>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted small">Progress Bantuan</span>
                <span class="fw-bold small" style="color: {{ $item->progress_color }};">{{ $item->transparencyReport->progress }}</span>
              </div>
              <div class="progress" style="height: 8px;">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" 
                    style="width: {{ $item->transparencyReport->progress }}; background-color: {{ $item->transparencyReport->progress_color }} !important;"
                    aria-valuenow="{{ $item->transparencyReport->progress_raw }}" aria-valuemin="0" aria-valuemax="100">
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="badge transparency-badge-{{ $item->transparencyReport->status_slug }} px-3 py-2">
                <i class="{{ $item->transparencyReport->status_icon }} me-1"></i> {{ $item->transparencyReport->status }}
              </span>
              <span class="small text-muted">
                <i class="fa-regular fa-calendar me-1"></i> {{ $item->transparencyReport->date }}
              </span>
            </div>
            <a href="{{ route('transparansi.detail', $item->slug) }}" class="btn btn-outline-primary w-100 mt-auto">
              <i class="fa-solid fa-file-lines me-2"></i>Lihat Laporan
            </a>
          </div>
        </div>
      </div>
      @endif
      @endforeach
    </div>
    <div class="text-center mt-5 animate-on-scroll">
      <p class="text-muted mb-4 small">Semua laporan penggunaan dana tersedia untuk publik. Kami berkomitmen penuh terhadap transparansi.</p>
      <a href="{{ route('transparansi') }}" class="btn btn-primary px-5 py-3">
        <i class="fa-solid fa-list-check me-2"></i>Lihat Semua Laporan Transparansi
      </a>
    </div>
  </div>
</section>

{{-- Section: Peta Sebaran Bencana --}}
<section class="bg-light-section" id="peta">
  <div class="container">
    <div class="text-center">
      <span class="section-tag section-tag-red animate-on-scroll">
        <i class="fa-solid fa-map-pin me-1"></i> Titik Bencana
      </span>
      <h2 class="section-title animate-on-scroll">Peta Sebaran Bencana</h2>
      <p class="section-desc animate-on-scroll">
        Pantau persebaran laporan bencana aktif dan jalannya penyaluran donasi logistik di lapangan secara real-time.
      </p>
    </div>

    <div class="animate-on-scroll mt-4" style="border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.12);">
      <div id="map" style="width: 100%; height: 480px;"></div>
    </div>

    <div class="text-center mt-3 text-muted animate-on-scroll" style="font-size: 0.9rem;">
      <i class="fa-solid fa-circle-info me-1"></i> Klik pin pada peta untuk melihat detail informasi bencana.
    </div>
  </div>
</section>

{{-- Section: Testimoni --}}
<section id="testimoni">
  <div class="container">
    <div class="text-center">
      <span class="section-tag section-tag-red animate-on-scroll"><i class="fa-solid fa-comments me-1"></i> Suara Mereka</span>
      <h2 class="section-title animate-on-scroll">Testimoni & Tanggapan</h2>
      <p class="section-desc animate-on-scroll">
        Bagaimana platform SIGANA telah membantu merubah cara tanggap darurat bencana di Indonesia.
      </p>
    </div>

    <div class="testimonial-track-wrapper animate-on-scroll mt-4">
      <div class="testimonial-track" id="testimonialTrack">
        <!-- Card 1 -->
        <div class="testimonial-card-auto">
          <div class="testimonial-stars mb-3">
            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
          </div>
          <p class="testimonial-text">"Proses donasi lewat SIGANA sangat mudah dan yang paling penting transparan. Saya bisa melacak mutasi dana donasi yang saya kirim sampai dibelanjakan logistik apa."</p>
          <div class="testimonial-profile">
            <div class="testimonial-avatar-placeholder bg-primary text-white d-flex align-items-center justify-content-center rounded-circle fw-bold" style="width:50px;height:50px;font-size:1.1rem;flex-shrink:0;">BS</div>
            <div class="testimonial-info ms-3">
              <h5 class="mb-0">Budi Santoso</h5>
              <span>Donatur Aktif (Swasta)</span>
            </div>
          </div>
        </div>
        <!-- Card 2 -->
        <div class="testimonial-card-auto">
          <div class="testimonial-stars mb-3">
            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
          </div>
          <p class="testimonial-text">"Sebagai relawan di lapangan, laporan validasi dari SIGANA sangat membantu kami mendistribusikan selimut dan makanan tanpa takut salah sasaran atau tumpang tindih posko."</p>
          <div class="testimonial-profile">
            <div class="testimonial-avatar-placeholder bg-secondary text-white d-flex align-items-center justify-content-center rounded-circle fw-bold" style="width:50px;height:50px;font-size:1.1rem;flex-shrink:0;">SA</div>
            <div class="testimonial-info ms-3">
              <h5 class="mb-0">Sarah Amelia</h5>
              <span>Relawan PMI (Volunteer)</span>
            </div>
          </div>
        </div>
        <!-- Card 3 -->
        <div class="testimonial-card-auto">
          <div class="testimonial-stars mb-3">
            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
          </div>
          <p class="testimonial-text">"Saat banjir besar melanda pemukiman kami, laporan tetangga kami di SIGANA langsung mendapat respons cepat dari tim evakuasi daerah dalam waktu kurang dari 2 jam."</p>
          <div class="testimonial-profile">
            <div class="testimonial-avatar-placeholder d-flex align-items-center justify-content-center rounded-circle fw-bold text-white" style="width:50px;height:50px;font-size:1.1rem;flex-shrink:0;background:#d97706;">PA</div>
            <div class="testimonial-info ms-3">
              <h5 class="mb-0">Pak Ahmad</h5>
              <span>Korban Banjir Bandang (Penerima Manfaat)</span>
            </div>
          </div>
        </div>
        <!-- Card 4 -->
        <div class="testimonial-card-auto">
          <div class="testimonial-stars mb-3">
            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
          </div>
          <p class="testimonial-text">"SIGANA menjadi andalan kami sebagai lembaga sosial dalam mengkoordinir penyaluran logistik bencana. Fitur verifikasi laporan benar-benar meminimalisir data ganda."</p>
          <div class="testimonial-profile">
            <div class="testimonial-avatar-placeholder bg-success text-white d-flex align-items-center justify-content-center rounded-circle fw-bold" style="width:50px;height:50px;font-size:1.1rem;flex-shrink:0;">DW</div>
            <div class="testimonial-info ms-3">
              <h5 class="mb-0">Dewi Wulandari</h5>
              <span>Koordinator Lembaga Sosial</span>
            </div>
          </div>
        </div>
        <!-- Card 5 -->
        <div class="testimonial-card-auto">
          <div class="testimonial-stars mb-3">
            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
          </div>
          <p class="testimonial-text">"Fitur peta sebaran bencana sangat membantu tim kami dalam menentukan prioritas lokasi yang paling membutuhkan bantuan logistik secara cepat dan akurat."</p>
          <div class="testimonial-profile">
            <div class="testimonial-avatar-placeholder d-flex align-items-center justify-content-center rounded-circle fw-bold text-white" style="width:50px;height:50px;font-size:1.1rem;flex-shrink:0;background:#7c3aed;">RH</div>
            <div class="testimonial-info ms-3">
              <h5 class="mb-0">Rudi Hermawan</h5>
              <span>Petugas BPBD Jawa Tengah</span>
            </div>
          </div>
        </div>
        <!-- Card 6 -->
        <div class="testimonial-card-auto">
          <div class="testimonial-stars mb-3">
            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
          </div>
          <p class="testimonial-text">"Saya berhasil mengumpulkan donasi dari teman-teman kantor lewat SIGANA hanya dalam 3 hari. Laporan transparansi dana-nya membuat mereka percaya untuk ikut berdonasi lebih besar."</p>
          <div class="testimonial-profile">
            <div class="testimonial-avatar-placeholder d-flex align-items-center justify-content-center rounded-circle fw-bold text-white" style="width:50px;height:50px;font-size:1.1rem;flex-shrink:0;background:#0891b2;">NP</div>
            <div class="testimonial-info ms-3">
              <h5 class="mb-0">Nadia Putri</h5>
              <span>Inisiator Donasi Perusahaan</span>
            </div>
          </div>
        </div>
        <!-- Duplikat untuk efek infinite scroll -->
        <div class="testimonial-card-auto" aria-hidden="true">
          <div class="testimonial-stars mb-3">
            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
          </div>
          <p class="testimonial-text">"Proses donasi lewat SIGANA sangat mudah dan yang paling penting transparan. Saya bisa melacak mutasi dana donasi yang saya kirim sampai dibelanjakan logistik apa."</p>
          <div class="testimonial-profile">
            <div class="testimonial-avatar-placeholder bg-primary text-white d-flex align-items-center justify-content-center rounded-circle fw-bold" style="width:50px;height:50px;font-size:1.1rem;flex-shrink:0;">BS</div>
            <div class="testimonial-info ms-3">
              <h5 class="mb-0">Budi Santoso</h5>
              <span>Donatur Aktif (Swasta)</span>
            </div>
          </div>
        </div>
        <div class="testimonial-card-auto" aria-hidden="true">
          <div class="testimonial-stars mb-3">
            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
          </div>
          <p class="testimonial-text">"Sebagai relawan di lapangan, laporan validasi dari SIGANA sangat membantu kami mendistribusikan selimut dan makanan tanpa takut salah sasaran atau tumpang tindih posko."</p>
          <div class="testimonial-profile">
            <div class="testimonial-avatar-placeholder bg-secondary text-white d-flex align-items-center justify-content-center rounded-circle fw-bold" style="width:50px;height:50px;font-size:1.1rem;flex-shrink:0;">SA</div>
            <div class="testimonial-info ms-3">
              <h5 class="mb-0">Sarah Amelia</h5>
              <span>Relawan PMI (Volunteer)</span>
            </div>
          </div>
        </div>
        <div class="testimonial-card-auto" aria-hidden="true">
          <div class="testimonial-stars mb-3">
            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
          </div>
          <p class="testimonial-text">"Saat banjir besar melanda pemukiman kami, laporan tetangga kami di SIGANA langsung mendapat respons cepat dari tim evakuasi daerah dalam waktu kurang dari 2 jam."</p>
          <div class="testimonial-profile">
            <div class="testimonial-avatar-placeholder d-flex align-items-center justify-content-center rounded-circle fw-bold text-white" style="width:50px;height:50px;font-size:1.1rem;flex-shrink:0;background:#d97706;">PA</div>
            <div class="testimonial-info ms-3">
              <h5 class="mb-0">Pak Ahmad</h5>
              <span>Korban Banjir Bandang (Penerima Manfaat)</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Section: Bagaimana SIGANA Bekerja? (Timeline) --}}
<section class="bg-light-section" id="alur">
  <div class="container">
    <div class="text-center">
      <span class="section-tag section-tag-red animate-on-scroll"><i class="fa-solid fa-gears me-1"></i> Alur Sistem</span>
      <h2 class="section-title animate-on-scroll">Bagaimana SIGANA Bekerja?</h2>
      <p class="section-desc animate-on-scroll">
        Alur kerja yang terstruktur dan aman dari proses registrasi hingga bantuan tepat sasaran dan terlaporkan secara transparan.
      </p>
    </div>

    <div class="timeline mt-5">
      <div class="timeline-container timeline-left animate-on-scroll">
        <div class="timeline-number">1</div>
        <div class="timeline-content">
          <h4>Registrasi Akun</h4>
          <p>Pengguna baru melakukan pendaftaran akun di platform SIGANA secara cepat menggunakan email dan verifikasi OTP.</p>
        </div>
      </div>
      <div class="timeline-container timeline-right red-node animate-on-scroll">
        <div class="timeline-number">2</div>
        <div class="timeline-content">
          <h4>Login ke Sistem</h4>
          <p>Pengguna masuk menggunakan kredensial terdaftar untuk mengakses dashboard personal/donatur.</p>
        </div>
      </div>
      <div class="timeline-container timeline-left animate-on-scroll">
        <div class="timeline-number">3</div>
        <div class="timeline-content">
          <h4>Melaporkan Bencana / Berdonasi</h4>
          <p>Pengguna dapat mengunggah laporan bencana baru atau memilih galang dana donasi aktif untuk menyalurkan uang.</p>
        </div>
      </div>
      <div class="timeline-container timeline-right red-node animate-on-scroll">
        <div class="timeline-number">4</div>
        <div class="timeline-content">
          <h4>Verifikasi Data Admin</h4>
          <p>Admin pusat mengevaluasi kesesuaian laporan bencana lapangan atau mencocokkan mutasi masuk donasi.</p>
        </div>
      </div>
      <div class="timeline-container timeline-left animate-on-scroll">
        <div class="timeline-number">5</div>
        <div class="timeline-content">
          <h4>Informasi Dipublikasikan</h4>
          <p>Laporan bencana terverifikasi langsung tampil di peta publik agar memancing atensi relawan dan donatur lain.</p>
        </div>
      </div>
      <div class="timeline-container timeline-right red-node animate-on-scroll">
        <div class="timeline-number">6</div>
        <div class="timeline-content">
          <h4>Penyaluran Bantuan</h4>
          <p>Tim relawan lapangan membelanjakan dana donasi menjadi paket logistik dan mendistribusikannya ke titik bencana.</p>
        </div>
      </div>
      <div class="timeline-container timeline-left animate-on-scroll">
        <div class="timeline-number">7</div>
        <div class="timeline-content">
          <h4>Laporan Transparansi Ditampilkan</h4>
          <p>Laporan penggunaan dana dan dokumentasi penyaluran diterbitkan secara terbuka agar bisa dipantau siapa saja secara real-time.</p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Modal: Map Marker --}}
<div class="modal fade" id="mapMarkerModal" tabindex="-1" aria-labelledby="mapMarkerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mapMarkerModalLabel">Detail Laporan Bencana</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="text-center mb-4">
          <span id="modalMarkerStatus" class="badge p-2 mb-2">Darurat</span>
          <h4 id="modalMarkerLocation" class="fw-bold mb-1">Jawa Tengah</h4>
          <p id="modalMarkerType" class="text-primary fw-semibold">Banjir Bandang</p>
        </div>
        <div class="p-3 bg-light rounded mb-4">
          <h6 class="fw-bold text-dark mb-2">Kondisi Terkini:</h6>
          <p id="modalMarkerDesc" class="mb-0 text-muted" style="font-size: 0.95rem; line-height: 1.6;"></p>
        </div>
        <div class="d-grid gap-2">
          <a href="#donasi" class="btn btn-primary" id="btnModalAction" data-bs-dismiss="modal">Bantu Sekarang</a>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Modal: Donasi --}}
<div class="modal fade" id="donationModal" tabindex="-1" aria-labelledby="donationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="donationModalLabel">Donasi untuk Bencana</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="text-center mb-4">
          <p class="text-muted mb-1" style="font-size: 0.85rem;">Anda akan berdonasi untuk:</p>
          <h5 id="modalDonationTitle" class="fw-bold text-dark px-3">Bantuan Logistik Erupsi Gunung Semeru</h5>
        </div>

        <div id="donationFormContainer">
          <div class="mb-3">
            <label class="form-label">Pilih Paket Donasi</label>
            <div class="donation-package-grid">
              <div class="donation-btn active" data-amount="50000">Rp50.000</div>
              <div class="donation-btn" data-amount="100000">Rp100.000</div>
              <div class="donation-btn" data-amount="250000">Rp250.000</div>
              <div class="donation-btn" data-amount="500000">Rp500.000</div>
              <div class="donation-btn" data-amount="1000000">Rp1.000.000</div>
              <div class="donation-btn" data-amount="other">Lainnya</div>
            </div>
          </div>
          <div class="mb-3 d-none" id="customAmountWrapper">
            <label class="form-label" for="customDonationAmount">Jumlah Donasi Kustom (Rp)</label>
            <input type="number" class="form-control" id="customDonationAmount" placeholder="Contoh: 150000" min="10000">
          </div>
          <div class="mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <div class="payment-methods-grid">
              <div class="payment-btn active" data-method="GOPAY">
                <i class="fa-solid fa-wallet"></i><span>GoPay</span>
              </div>
              <div class="payment-btn" data-method="OVO">
                <i class="fa-solid fa-mobile-screen"></i><span>OVO</span>
              </div>
              <div class="payment-btn" data-method="TRANSFER">
                <i class="fa-solid fa-building-columns"></i><span>Transfer Bank</span>
              </div>
            </div>
          </div>
          <div class="mb-4">
            <label class="form-label" for="donatorName">Nama Lengkap (Boleh Anonim)</label>
            <input type="text" class="form-control" id="donatorName" placeholder="Contoh: Hamba Allah" value="Hamba Allah">
          </div>
          <div class="d-grid">
            <button class="btn btn-primary py-2" id="btnSubmitDonation">Lanjutkan Pembayaran</button>
          </div>
        </div>

        <div id="donationSuccessContainer" class="d-none success-screen">
          <div class="success-icon"><i class="fa-solid fa-circle-check"></i></div>
          <h4 class="fw-bold text-dark mb-2">Donasi Berhasil!</h4>
          <p class="text-muted px-4 mb-4" style="font-size: 0.95rem;">
            Terima kasih <strong><span id="successDonatorName">Hamba Allah</span></strong> atas kebaikan Anda. Donasi sebesar <strong><span id="successDonationAmount">Rp50.000</span></strong> via <strong><span id="successPaymentMethod">GoPay</span></strong> untuk <span id="successCampaignName">Bencana</span> telah kami terima secara transparan.
          </p>
          <button class="btn btn-primary px-4" data-bs-dismiss="modal">Selesai</button>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Modal: Harus Login --}}
<div class="modal fade" id="modalAuthRequired" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4">
      <div class="mb-3">
        <i class="fa-solid fa-lock fa-3x text-warning"></i>
      </div>
      <h5 class="fw-bold mb-2">Login Diperlukan</h5>
      <p class="text-muted mb-4">
        Untuk melaporkan bencana, Anda harus login atau membuat akun terlebih dahulu.
      </p>
      <div class="d-flex gap-2 justify-content-center">
        <a href="{{ route('login') }}" class="btn btn-primary px-4">
          <i class="fa-solid fa-right-to-bracket me-1"></i>Login
        </a>
        <a href="{{ route('register.create') }}" class="btn btn-outline-primary px-4">
          <i class="fa-solid fa-user-plus me-1"></i>Daftar
        </a>
      </div>
      <div class="mt-3">
        <button class="btn btn-sm btn-link text-muted" data-bs-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

@endsection