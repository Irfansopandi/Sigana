@extends('layouts.app')

@section('title', 'Tentang Kami — SIGANA')
@section('meta_description', 'Kenali lebih dalam tentang SIGANA, platform digital tanggap bencana dan donasi kemanusiaan Indonesia yang transparan, cepat, dan terpercaya.')
@section('body_class', 'page-dark-hero')

@section('content')

{{-- ========================
     Hero Tentang Kami
======================== --}}
<section class="about-hero-section">
  <div class="about-hero-overlay"></div>
  <div class="container position-relative z-2">
    <div class="row align-items-center justify-content-center text-center">
      <div class="col-lg-8 animate-on-scroll animate-fade-in-left">
        <span class="section-tag section-tag-white mb-4">
          <i class="fa-solid fa-circle-info me-1"></i> Tentang Kami
        </span>
        <h1 class="about-hero-title">Kami Hadir untuk Menjembatani <span>Kebaikan & Kemanusiaan</span></h1>
        <p class="about-hero-desc">
          SIGANA adalah platform digital yang lahir dari kepedulian terhadap lambatnya respons bencana dan kurangnya transparansi dalam penyaluran donasi di Indonesia.
        </p>
        <div class="about-hero-breadcrumb">
          <a href="{{ route('home') }}" class="breadcrumb-link"><i class="fa-solid fa-house me-1"></i>Beranda</a>
          <i class="fa-solid fa-chevron-right mx-2 text-white-50"></i>
          <span class="text-white">Tentang Kami</span>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ========================
     Narasi / Cerita Asal
======================== --}}
<section class="py-5 my-3" id="cerita-kami">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6 animate-on-scroll animate-fade-in-left">
        <div class="about-story-img-wrapper">
          <div class="about-story-img-card">
            <div class="about-story-img-main">
              <div class="about-story-illu d-flex align-items-center justify-content-center" style="height:320px; background: linear-gradient(135deg, #1e3a5f 0%, #0c2340 100%); border-radius: 20px;">
                <div class="text-center text-white p-4">
                  <i class="fa-solid fa-shield-heart mb-4" style="font-size: 5rem; color: rgba(255,255,255,0.15);"></i>
                  <div class="row g-3">
                    <div class="col-6">
                      <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.08);">
                        <div class="fw-bold fs-4" style="color: #f87171;">250+</div>
                        <div style="font-size: 0.75rem; color: rgba(255,255,255,0.7);">Laporan Bencana</div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.08);">
                        <div class="fw-bold fs-4" style="color: #60a5fa;">1.500+</div>
                        <div style="font-size: 0.75rem; color: rgba(255,255,255,0.7);">Donatur Aktif</div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.08);">
                        <div class="fw-bold fs-4" style="color: #34d399;">Rp500 Jt</div>
                        <div style="font-size: 0.75rem; color: rgba(255,255,255,0.7);">Donasi Tersalur</div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.08);">
                        <div class="fw-bold fs-4" style="color: #fbbf24;">5.000+</div>
                        <div style="font-size: 0.75rem; color: rgba(255,255,255,0.7);">Korban Terbantu</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="about-story-badge">
            <i class="fa-solid fa-award me-2"></i>Platform Terpercaya 2026
          </div>
        </div>
      </div>

      <div class="col-lg-6 animate-on-scroll animate-fade-in-right">
        <span class="section-tag section-tag-red mb-3">
          <i class="fa-solid fa-book-open me-1"></i> Cerita Kami
        </span>
        <h2 class="section-title text-start mb-4">Mengapa SIGANA Hadir?</h2>
        <p class="text-muted mb-4" style="line-height: 1.85; font-size: 1rem;">
          Indonesia adalah salah satu negara paling rawan bencana di dunia. Namun selama ini, proses pelaporan bencana masih lambat, koordinasi bantuan sering tumpang tindih, dan donasi masyarakat tidak selalu tersalurkan secara transparan.
        </p>
        <p class="text-muted mb-4" style="line-height: 1.85; font-size: 1rem;">
          <strong class="text-dark">SIGANA</strong> lahir sebagai jawaban atas tantangan tersebut. Dibangun di atas prinsip <em>kecepatan, akuntabilitas, dan transparansi</em>, kami menyediakan ekosistem digital yang menghubungkan pelapor bencana di lapangan, donatur di seluruh Indonesia, dan tim penyalur bantuan secara efisien.
        </p>
        <div class="about-value-list">
          <div class="about-value-item">
            <div class="about-value-icon"><i class="fa-solid fa-bolt"></i></div>
            <div>
              <strong>Respons Cepat</strong>
              <p class="mb-0 text-muted small">Laporan bencana terverifikasi dalam hitungan jam, bukan hari.</p>
            </div>
          </div>
          <div class="about-value-item">
            <div class="about-value-icon green"><i class="fa-solid fa-eye"></i></div>
            <div>
              <strong>Transparan 100%</strong>
              <p class="mb-0 text-muted small">Setiap rupiah donasi bisa dipantau penggunaannya secara publik.</p>
            </div>
          </div>
          <div class="about-value-item">
            <div class="about-value-icon blue"><i class="fa-solid fa-shield-halved"></i></div>
            <div>
              <strong>Data Terverifikasi</strong>
              <p class="mb-0 text-muted small">Setiap laporan bencana dikurasi admin sebelum dipublikasikan.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ========================
     Visi & Misi
======================== --}}
<section class="about-vimis-section py-5">
  <div class="container">
    <div class="text-center mb-5">
      <span class="section-tag animate-on-scroll"><i class="fa-solid fa-compass me-1"></i> Arah Kami</span>
      <h2 class="section-title animate-on-scroll">Visi & Misi SIGANA</h2>
    </div>
    <div class="row g-4 justify-content-center">
      <div class="col-md-5 animate-on-scroll">
        <div class="vimis-card vimis-visi">
          <div class="vimis-icon-top">
            <i class="fa-solid fa-eye"></i>
          </div>
          <div class="vimis-label">Visi</div>
          <h3 class="vimis-title">Menjadi Ekosistem Tanggap Bencana Digital Paling Terpercaya di Indonesia</h3>
          <p class="vimis-desc">
            Kami bermimpi tentang Indonesia yang setiap warganya dapat melaporkan bencana, berdonasi, dan memantau penyaluran bantuan hanya dalam genggaman tangan — cepat, mudah, dan tanpa keraguan.
          </p>
        </div>
      </div>
      <div class="col-md-7 animate-on-scroll">
        <div class="vimis-card vimis-misi h-100">
          <div class="vimis-icon-top red">
            <i class="fa-solid fa-bullseye"></i>
          </div>
          <div class="vimis-label red">Misi</div>
          <h3 class="vimis-title">Langkah Nyata yang Kami Tempuh</h3>
          <ul class="vimis-misi-list">
            <li>
              <i class="fa-solid fa-check-circle"></i>
              Membangun sistem pelaporan bencana berbasis digital yang mudah diakses oleh seluruh lapisan masyarakat Indonesia.
            </li>
            <li>
              <i class="fa-solid fa-check-circle"></i>
              Menyediakan platform donasi kemanusiaan yang aman, terverifikasi, dan sepenuhnya transparan kepada publik.
            </li>
            <li>
              <i class="fa-solid fa-check-circle"></i>
              Membangun jejaring relawan dan lembaga sosial agar koordinasi bantuan lapangan lebih efektif dan tepat sasaran.
            </li>
            <li>
              <i class="fa-solid fa-check-circle"></i>
              Memanfaatkan teknologi peta digital untuk memvisualisasikan persebaran bencana dan jalur distribusi logistik secara real-time.
            </li>
            <li>
              <i class="fa-solid fa-check-circle"></i>
              Menjaga integritas data dengan proses verifikasi berlapis sebelum laporan dipublikasikan ke masyarakat luas.
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ========================
     Nilai-Nilai Kami
======================== --}}
<section class="py-5 my-2" id="nilai-kami">
  <div class="container">
    <div class="text-center mb-5">
      <span class="section-tag section-tag-red animate-on-scroll"><i class="fa-solid fa-heart me-1"></i> Nilai Kami</span>
      <h2 class="section-title animate-on-scroll">Prinsip yang Mendasari Kami</h2>
      <p class="section-desc animate-on-scroll">Setiap keputusan dan fitur yang kami bangun selalu berpijak pada nilai-nilai inti berikut.</p>
    </div>
    <div class="row g-4">
      <div class="col-md-6 col-lg-3 animate-on-scroll">
        <div class="nilai-card">
          <div class="nilai-icon" style="--clr: #3b82f6; --clr-bg: #eff6ff;">
            <i class="fa-solid fa-shield-halved"></i>
          </div>
          <h4>Integritas</h4>
          <p>Kami berkomitmen pada kejujuran penuh dalam setiap laporan, transaksi, dan komunikasi yang kami jalankan.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 animate-on-scroll">
        <div class="nilai-card">
          <div class="nilai-icon" style="--clr: #ef4444; --clr-bg: #fef2f2;">
            <i class="fa-solid fa-heart"></i>
          </div>
          <h4>Empati</h4>
          <p>Kami memahami kesulitan korban bencana dan merancang setiap fitur dengan penuh empati terhadap mereka.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 animate-on-scroll">
        <div class="nilai-card">
          <div class="nilai-icon" style="--clr: #10b981; --clr-bg: #f0fdf4;">
            <i class="fa-solid fa-magnifying-glass-chart"></i>
          </div>
          <h4>Transparansi</h4>
          <p>Semua data donasi dan distribusi bantuan tersedia untuk publik tanpa pengecualian — tidak ada yang disembunyikan.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3 animate-on-scroll">
        <div class="nilai-card">
          <div class="nilai-icon" style="--clr: #f59e0b; --clr-bg: #fffbeb;">
            <i class="fa-solid fa-bolt"></i>
          </div>
          <h4>Kecepatan</h4>
          <p>Setiap menit sangat berarti dalam situasi bencana. Sistem kami dirancang untuk respons dan aksi yang secepat mungkin.</p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Partner & Lembaga --}}
<section class="about-partner-section py-5 bg-light-section" id="mitra">
  <div class="container">
    <div class="text-center mb-5">
      <span class="section-tag animate-on-scroll"><i class="fa-solid fa-handshake me-1"></i> Mitra Kami</span>
      <h2 class="section-title animate-on-scroll">Didukung oleh Lembaga Terpercaya</h2>
      <p class="section-desc animate-on-scroll">Kami berkolaborasi dengan berbagai lembaga resmi untuk memastikan bantuan sampai tepat sasaran.</p>
    </div>
    <div class="partner-marquee-wrapper">
      <div class="partner-marquee-track" id="partnerTrack">
        @php
          $mitras = [
            ['file' => 'BNPB.png',          'name' => 'BNPB'],
            ['file' => 'PMI.png',            'name' => 'PMI Indonesia'],
            ['file' => 'BPBD.png',           'name' => 'BPBD Nasional'],
            ['file' => 'kemensos.png',        'name' => 'Kemensos RI'],
            ['file' => 'dompet-dhuafa.png',  'name' => 'Dompet Dhuafa'],
            ['file' => 'OCHA.png',           'name' => 'UN OCHA'],
          ];
        @endphp

        {{-- duplikat untuk seamless loop --}}
        @foreach(array_merge($mitras, $mitras) as $m)
          <div class="partner-marquee-item">
            <img src="{{ asset('storage/assets/mitra/' . $m['file']) }}"
                 alt="{{ $m['name'] }}"
                 class="partner-marquee-logo">
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

{{-- ========================
     CTA Bergabung
======================== --}}
<section class="about-cta-section">
  <div class="container">
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
