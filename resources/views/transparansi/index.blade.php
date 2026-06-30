@extends('layouts.app')

@section('title', 'Transparansi Real-Time Donasi & Penyaluran — SIGANA')
@section('meta_description', 'Pantau arus dana masuk dan alokasi bantuan kemanusiaan secara real-time di SIGANA. Transparansi 100% demi kepercayaan Anda.')
@section('body_class', 'page-dark-hero')

@section('content')

{{-- ========================
     Hero Section Transparansi
======================== --}}
<section class="disaster-hero-section" style="padding: 100px 0 80px;">
  <div class="disaster-hero-overlay"></div>
  <div class="container position-relative z-2">
    <div class="text-center">
      <span class="section-tag section-tag-white mb-4 d-inline-block">
        <i class="fa-solid fa-chart-line me-1"></i> Transparansi Real-Time
      </span>
      <h1 class="disaster-hero-title">Laporan Keuangan & <span>Penyaluran Bantuan</span></h1>
      <p class="text-white-50 mt-3 mx-auto" style="max-width: 650px; font-size: 1.05rem; line-height: 1.7;">
        Kami menjamin akuntabilitas setiap rupiah yang Anda donasikan. Pantau laporan penerimaan dan alokasi dana secara langsung di bawah ini.
      </p>
      <div class="about-hero-breadcrumb mt-4">
        <a href="{{ route('home') }}" class="breadcrumb-link"><i class="fa-solid fa-house me-1"></i>Beranda</a>
        <i class="fa-solid fa-chevron-right mx-2 text-white-50"></i>
        <span class="text-white">Transparansi</span>
      </div>
    </div>
  </div>
</section>

{{-- ========================
     Statistik Ringkasan
======================== --}}
<section class="position-relative" style="margin-top: -40px; z-index: 10;">
  <div class="container">
    <div class="bg-white rounded-4 p-4 shadow-lg border border-light animate-scale-in">
      <div class="row g-4 text-center">
        <div class="col-6 col-lg-3 border-end border-light">
          <p class="text-muted small fw-semibold text-uppercase mb-2" style="letter-spacing: 0.5px;">Total Dana Masuk</p>
          <h3 class="fw-extrabold text-primary mb-0" style="font-family: var(--font-title); font-size: 1.8rem;">Rp{{ number_format($totalCollected, 0, ',', '.') }}</h3>
          <span class="badge bg-success-subtle text-success small mt-2 d-inline-flex align-items-center gap-1" style="font-size: 0.75rem; border-radius: 50px;">
            <i class="fa-solid fa-circle-arrow-up"></i> 100% Terverifikasi
          </span>
        </div>
        <div class="col-6 col-lg-3 border-end border-light-md">
          <p class="text-muted small fw-semibold text-uppercase mb-2" style="letter-spacing: 0.5px;">Dana Disalurkan</p>
          <h3 class="fw-extrabold text-success mb-0" style="font-family: var(--font-title); font-size: 1.8rem;">Rp{{ number_format($totalUsed, 0, ',', '.') }}</h3>          
          <span class="badge bg-primary-subtle text-primary small mt-2 d-inline-flex align-items-center gap-1" style="font-size: 0.75rem; border-radius: 50px;">
            Alokasi Bantuan: {{ $totalCollected > 0 ? number_format(($totalUsed / $totalCollected) * 100, 1) : 0 }}%
          </span>
        </div>
        <div class="col-6 col-lg-3 border-end border-light">
          <p class="text-muted small fw-semibold text-uppercase mb-2" style="letter-spacing: 0.5px;">Sisa Saldo Siap Salur</p>
          <h3 class="fw-extrabold text-dark mb-0" style="font-family: var(--font-title); font-size: 1.8rem;">Rp{{ number_format($totalRemaining, 0, ',', '.') }}</h3>
          <span class="badge bg-warning-subtle text-warning-emphasis small mt-2 d-inline-flex align-items-center gap-1" style="font-size: 0.75rem; border-radius: 50px;">
            <i class="fa-solid fa-clock"></i> Diproses Alokasi
          </span>
        </div>
        <div class="col-6 col-lg-3">
          <p class="text-muted small fw-semibold text-uppercase mb-2" style="letter-spacing: 0.5px;">Total Donatur Terdaftar</p>
          <h3 class="fw-extrabold text-info-emphasis mb-0" style="font-family: var(--font-title); font-size: 1.8rem;">{{ number_format($totalDonors, 0, ',', '.') }} Donatur</h3>
          <span class="badge bg-secondary-subtle text-secondary small mt-2 d-inline-flex align-items-center gap-1" style="font-size: 0.75rem; border-radius: 50px;">
            <i class="fa-solid fa-users"></i> Aktif Berbagi
          </span>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ========================
     Search, Filter, & Sort Toolbar
======================== --}}
<section class="pt-5 bg-light-section" style="padding-bottom: 0;">
  <div class="container">
    <div class="search-filter-panel shadow-sm">
      <div class="row g-3 align-items-center">
        <!-- Search Input -->
        <div class="col-lg-4 col-md-6 col-12">
          <div class="search-input-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="transparencySearchInput" class="form-control" placeholder="Cari laporan transparansi...">
          </div>
        </div>

        <!-- Filter Buttons (Desktop) -->
        <div class="col-lg-5 col-12 d-none d-lg-block">
          <div class="filter-categories-container justify-content-start">
            <button class="filter-cat-btn active" data-status="all">Semua Status</button>
            <button class="filter-cat-btn" data-status="penyaluran">Dalam Penyaluran</button>
            <button class="filter-cat-btn" data-status="selesai">Hampir Selesai</button>
            <button class="filter-cat-btn" data-status="aktif">Aktif</button>
          </div>
        </div>

        <!-- Mobile Filter Dropdown (Tablet & Mobile) -->
        <div class="col-md-6 col-12 d-lg-none">
          <select id="mobileStatusSelect" class="form-select" style="height: 48px; border-radius: 12px; border: 1px solid rgba(15,23,42,0.1); font-weight: 600;">
            <option value="all">Semua Status</option>
            <option value="penyaluran">Dalam Penyaluran</option>
            <option value="selesai">Hampir Selesai</option>
            <option value="aktif">Aktif</option>
          </select>
        </div>

        <!-- Sorting Selector -->
        <div class="col-lg-3 col-md-6 col-12 ms-auto">
          <select id="transparencySortSelect" class="form-select" style="height: 48px; border-radius: 12px; border: 1px solid rgba(15,23,42,0.1); font-weight: 600;">
            <option value="newest">Laporan Terbaru</option>
            <option value="progress-highest">Progress Bantuan Tertinggi</option>
            <option value="collected-highest">Dana Terkumpul Terbesar</option>
            <option value="used-highest">Dana Digunakan Terbesar</option>
          </select>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ========================
     Transparency Cards Grid Section
======================== --}}
<section class="py-5 bg-light-section">
  <div class="container pb-4">
    <div class="row g-4" id="transparencyGrid">

      <!-- Card 1: Banjir Demak -->
      @forelse($campaigns as $campaign)
        @php($report = $campaign->transparencyReport)
        @continue(!$report)
        <div class="col-md-6 col-lg-4 transparency-card-item" 
            data-name="{{ strtolower($campaign->title . ' ' . $campaign->location) }}"
            data-status="{{ $report->status_slug }}"
            data-collected="{{ $campaign->collected_raw }}"
            data-used="{{ $report->getRawOriginal('used') }}"
            data-progress="{{ $report->progress_raw }}"
            data-date="{{ strtotime($report->getRawOriginal('date')) }}">
          <div class="card h-100 transparency-card border-0 shadow-sm">
            <div class="transparency-img-wrapper" style="height: 200px;">
              <div class="transparency-overlay">
                <span class="badge {{ $report->status_class }} px-3 py-2"><i class="{{ $report->status_icon }} me-1"></i> {{ $report->status }}</span>
              </div>
              <img src="{{ $campaign->image_url }}" class="w-100 h-100 object-fit-cover" alt="{{ $campaign->title }}">
            </div>
            <div class="card-body p-4 d-flex flex-column">
              <h5 class="fw-bold mb-1 text-dark" style="font-size: 1.15rem;">{{ $campaign->title }}</h5>
              <div class="campaign-location mb-3">
                <i class="fa-solid fa-location-dot me-1 text-danger"></i> {{ $campaign->location }}
              </div>
              <div class="transparency-fund-info mb-3">
                <div class="d-flex justify-content-between fund-row mb-1">
                  <span class="text-muted small">Dana Terkumpul:</span>
                  <strong class="text-primary small">{{ $campaign->collected }}</strong>
                </div>
                <div class="d-flex justify-content-between fund-row mb-3">
                  <span class="text-muted small">Dana Digunakan:</span>
                  <strong class="text-danger small">{{ $report->used }}</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="text-muted small">Progress Bantuan</span>
                  <span class="fw-bold small" style="color: {{ $report->progress_color }};">{{ $report->progress }}</span>
                </div>
                <div class="progress" style="height: 8px; border-radius: 4px;">
                  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                      style="width: {{ $report->progress }}; background-color: {{ $report->progress_color }} !important;"
                      aria-valuenow="{{ $report->progress_raw }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-3 mt-auto">
                <span class="badge {{ $report->status_class }} px-3 py-2"><i class="{{ $report->status_icon }} me-1"></i> {{ $report->status }}</span>
                <span class="small text-muted"><i class="fa-regular fa-calendar me-1"></i> {{ $report->date }}</span>
              </div>
              <a href="{{ route('transparansi.detail', $campaign->slug) }}" class="btn btn-outline-primary w-100 mt-2" style="border-radius: 12px; font-weight: 600;"><i class="fa-solid fa-file-lines me-2"></i>Lihat Laporan</a>
            </div>
          </div>
        </div>
      @empty
        <p class="text-muted text-center py-5">Belum ada laporan transparansi tersedia.</p>
      @endforelse
    </div>

    <!-- Fallback Empty State -->
    <div id="transparencyEmptyState" class="d-none empty-state-wrapper py-5 text-center">
      <div class="empty-state-icon mb-3"><i class="fa-regular fa-folder-open text-muted fs-1"></i></div>
      <h3 class="fw-bold text-dark mb-2">Laporan Tidak Ditemukan</h3>
      <p class="text-muted small">Maaf, kami tidak dapat menemukan laporan transparansi yang cocok dengan kata kunci atau filter Anda.</p>
    </div>

  </div>
</section>

{{-- ========================
     Log Mutasi Dana Masuk/Keluar
======================== --}}
<section class="py-5 bg-white" style="border-top: 1px solid rgba(0,0,0,0.03);">
  <div class="container py-3">
    
    <div class="row align-items-end mb-4">
      <div class="col-lg-6">
        <span class="section-tag mb-2 d-inline-block"><i class="fa-solid fa-clipboard-list me-1"></i> Buku Mutasi</span>
        <h2 class="fw-bold text-dark mb-1" style="font-size: 1.85rem;">Mutasi Rekening Donasi</h2>
        <p class="text-muted mb-0">Daftar lengkap transaksi penerimaan donasi dan pengeluaran belanja tanggap bencana.</p>
      </div>
      
      {{-- Filter Transaksi --}}
      <div class="col-lg-6 mt-3 mt-lg-0 text-lg-end">
        <div class="d-flex gap-2 justify-content-lg-end flex-wrap">
          <select id="filterBencana" class="form-select border-light-subtle shadow-sm" style="width: auto; min-width: 180px; border-radius: 10px; height: 42px;">
            <option value="all">Semua Kampanye</option>
            @foreach($campaigns as $camp)
              <option value="{{ $camp->slug }}">{{ $camp->title }}</option>
            @endforeach
          </select>
          <select id="filterTipe" class="form-select border-light-subtle shadow-sm" style="width: auto; min-width: 140px; border-radius: 10px; height: 42px;">
            <option value="all">Semua Tipe</option>
            <option value="pemasukan">Dana Masuk</option>
            <option value="pengeluaran">Dana Keluar</option>
          </select>
        </div>
      </div>
    </div>

    {{-- Daftar Mutasi Table --}}
    <div class="bg-white rounded-4 border border-light-subtle shadow-sm overflow-hidden animate-on-scroll">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="mutasiTable">
          <thead>
            <tr class="table-light">
              <th class="py-3 px-4 text-muted small fw-bold border-0" style="font-size: 0.8rem;">TANGGAL</th>
              <th class="py-3 text-muted small fw-bold border-0" style="font-size: 0.8rem;">ID TRANSAKSI</th>
              <th class="py-3 text-muted small fw-bold border-0" style="font-size: 0.8rem;">KATEGORI BENCANA</th>
              <th class="py-3 text-muted small fw-bold border-0" style="font-size: 0.8rem;">TIPE</th>
              <th class="py-3 text-muted small fw-bold border-0" style="font-size: 0.8rem;">KETERANGAN</th>
              <th class="py-3 text-end text-muted small fw-bold border-0" style="font-size: 0.8rem;">NOMINAL</th>
              <th class="py-3 text-center text-muted small fw-bold border-0" style="font-size: 0.8rem; width: 140px;">DOKUMEN BUKTI</th>
            </tr>
          </thead>
          <tbody>
            <!-- Row 1 -->
            <tr class="mutasi-row" data-bencana="donasi-darurat-banjir-bandang-demak" data-tipe="pengeluaran">
              <td class="py-3 px-4 text-dark small fw-semibold">18 Juni 2026</td>
              <td><code class="text-uppercase" style="font-size: 0.8rem;">OUT-DMK-001</code></td>
              <td><span class="small fw-semibold text-dark">Banjir Bandang Demak</span></td>
              <td><span class="badge bg-danger-subtle text-danger px-2.5 py-1.5 small border border-danger-subtle" style="font-size: 0.7rem;"><i class="fa-solid fa-circle-arrow-down me-1"></i> Dana Keluar</span></td>
              <td><span class="text-muted small">Pembelian 500 Paket Sembako & Selimut di Posko Demak</span></td>
              <td class="text-end fw-bold text-danger">-Rp45.000.000</td>
              <td class="text-center">
                <a href="#" class="btn btn-outline-primary btn-sm px-3" style="border-radius: 8px; font-size: 0.75rem;"><i class="fa-solid fa-file-pdf me-1"></i>Nota & Foto</a>
              </td>
            </tr>
            <!-- Row 2 -->
            <tr class="mutasi-row" data-bencana="donasi-darurat-banjir-bandang-demak" data-tipe="pemasukan">
              <td class="py-3 px-4 text-dark small fw-semibold">18 Juni 2026</td>
              <td><code class="text-uppercase" style="font-size: 0.8rem;">IN-DMK-043</code></td>
              <td><span class="small fw-semibold text-dark">Banjir Bandang Demak</span></td>
              <td><span class="badge bg-success-subtle text-success px-2.5 py-1.5 small border border-success-subtle" style="font-size: 0.7rem;"><i class="fa-solid fa-circle-arrow-up me-1"></i> Dana Masuk</span></td>
              <td><span class="text-muted small">Donasi Komunitas Pemuda Peduli Jawa Tengah</span></td>
              <td class="text-end fw-bold text-success">+Rp15.000.000</td>
              <td class="text-center">
                <a href="#" class="btn btn-outline-primary btn-sm px-3" style="border-radius: 8px; font-size: 0.75rem;"><i class="fa-solid fa-file-pdf me-1"></i>Kuitansi</a>
              </td>
            </tr>
            <!-- Row 3 -->
            <tr class="mutasi-row" data-bencana="peduli-korban-gempa-bumi-mamuju" data-tipe="pengeluaran">
              <td class="py-3 px-4 text-dark small fw-semibold">17 Juni 2026</td>
              <td><code class="text-uppercase" style="font-size: 0.8rem;">OUT-MMJ-002</code></td>
              <td><span class="small fw-semibold text-dark">Gempa Bumi Mamuju</span></td>
              <td><span class="badge bg-danger-subtle text-danger px-2.5 py-1.5 small border border-danger-subtle" style="font-size: 0.7rem;"><i class="fa-solid fa-circle-arrow-down me-1"></i> Dana Keluar</span></td>
              <td><span class="text-muted small">Sewa Alat Berat & Evakuasi Reruntuhan Pemukiman</span></td>
              <td class="text-end fw-bold text-danger">-Rp60.000.000</td>
              <td class="text-center">
                <a href="#" class="btn btn-outline-primary btn-sm px-3" style="border-radius: 8px; font-size: 0.75rem;"><i class="fa-solid fa-file-pdf me-1"></i>Faktur Mitra</a>
              </td>
            </tr>
            <!-- Row 4 -->
            <tr class="mutasi-row" data-bencana="bantuan-logistik-erupsi-gunung-semeru" data-tipe="pengeluaran">
              <td class="py-3 px-4 text-dark small fw-semibold">16 Juni 2026</td>
              <td><code class="text-uppercase" style="font-size: 0.8rem;">OUT-SMR-005</code></td>
              <td><span class="small fw-semibold text-dark">Erupsi Gunung Semeru</span></td>
              <td><span class="badge bg-danger-subtle text-danger px-2.5 py-1.5 small border border-danger-subtle" style="font-size: 0.7rem;"><i class="fa-solid fa-circle-arrow-down me-1"></i> Dana Keluar</span></td>
              <td><span class="text-muted small">Penyaluran Masker Medis & Obat Pernapasan (ISPA)</span></td>
              <td class="text-end fw-bold text-danger">-Rp18.000.000</td>
              <td class="text-center">
                <a href="#" class="btn btn-outline-primary btn-sm px-3" style="border-radius: 8px; font-size: 0.75rem;"><i class="fa-solid fa-file-pdf me-1"></i>Nota Apotik</a>
              </td>
            </tr>
            <!-- Row 5 -->
            <tr class="mutasi-row" data-bencana="peduli-korban-gempa-bumi-mamuju" data-tipe="pengeluaran">
              <td class="py-3 px-4 text-dark small fw-semibold">15 Juni 2026</td>
              <td><code class="text-uppercase" style="font-size: 0.8rem;">OUT-MMJ-001</code></td>
              <td><span class="small fw-semibold text-dark">Gempa Bumi Mamuju</span></td>
              <td><span class="badge bg-danger-subtle text-danger px-2.5 py-1.5 small border border-danger-subtle" style="font-size: 0.7rem;"><i class="fa-solid fa-circle-arrow-down me-1"></i> Dana Keluar</span></td>
              <td><span class="text-muted small">Pengadaan 100 Unit Tenda Pengungsian Darurat</span></td>
              <td class="text-end fw-bold text-danger">-Rp100.000.000</td>
              <td class="text-center">
                <a href="#" class="btn btn-outline-primary btn-sm px-3" style="border-radius: 8px; font-size: 0.75rem;"><i class="fa-solid fa-file-pdf me-1"></i>PO & Nota</a>
              </td>
            </tr>
            <!-- Row 6 -->
            <tr class="mutasi-row" data-bencana="bantuan-krisis-air-bersih-gunungkidul" data-tipe="pengeluaran">
              <td class="py-3 px-4 text-dark small fw-semibold">14 Juni 2026</td>
              <td><code class="text-uppercase" style="font-size: 0.8rem;">OUT-GK-001</code></td>
              <td><span class="small fw-semibold text-dark">Bantuan Krisis Air Bersih Gunungkidul</span></td>
              <td><span class="badge bg-danger-subtle text-danger px-2.5 py-1.5 small border border-danger-subtle" style="font-size: 0.7rem;"><i class="fa-solid fa-circle-arrow-down me-1"></i> Dana Keluar</span></td>
              <td><span class="text-muted small">Distribusi 50 Mobil Tangki Air Bersih ke Desa Terpencil</span></td>
              <td class="text-end fw-bold text-danger">-Rp15.000.000</td>
              <td class="text-center">
                <a href="#" class="btn btn-outline-primary btn-sm px-3" style="border-radius: 8px; font-size: 0.75rem;"><i class="fa-solid fa-file-pdf me-1"></i>Surat Jalan</a>
              </td>
            </tr>
            <!-- Row 7 -->
            <tr class="mutasi-row" data-bencana="penanganan-darurat-tanah-longsor-bogor" data-tipe="pemasukan">
              <td class="py-3 px-4 text-dark small fw-semibold">12 Juni 2026</td>
              <td><code class="text-uppercase" style="font-size: 0.8rem;">IN-BGR-012</code></td>
              <td><span class="small fw-semibold text-dark">Tanah Longsor Bogor</span></td>
              <td><span class="badge bg-success-subtle text-success px-2.5 py-1.5 small border border-success-subtle" style="font-size: 0.7rem;"><i class="fa-solid fa-circle-arrow-up me-1"></i> Dana Masuk</span></td>
              <td><span class="text-muted small">Donasi CSR Perusahaan Swasta Nasional</span></td>
              <td class="text-end fw-bold text-success">+Rp25.000.000</td>
              <td class="text-center">
                <a href="#" class="btn btn-outline-primary btn-sm px-3" style="border-radius: 8px; font-size: 0.75rem;"><i class="fa-solid fa-file-pdf me-1"></i>Kuitansi</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      {{-- Empty state table --}}
      <div id="emptyMutasi" class="d-none text-center py-5 border-top border-light-subtle">
        <i class="fa-regular fa-folder-open text-muted fs-1 mb-3"></i>
        <h5 class="fw-bold text-dark">Tidak Ada Mutasi</h5>
        <p class="text-muted small">Maaf, mutasi rekening tidak ditemukan dengan kombinasi filter saat ini.</p>
      </div>

      <div class="card-footer bg-light border-0 py-3 text-center">
        <span class="text-muted small"><i class="fa-solid fa-circle-info me-1 text-primary"></i> Data mutasi direfresh otomatis oleh sistem perbankan setiap jam.</span>
      </div>
    </div>

  </div>
</section>

{{-- ========================
     Banner Auditor & Kredibilitas
======================== --}}
<section class="py-5" style="background: #f8fafc; border-top: 1px solid rgba(0,0,0,0.03);">
  <div class="container py-3">
    <div class="bg-white rounded-4 p-4 p-md-5 border border-light shadow-sm">
      <div class="row align-items-center g-4">
        <div class="col-lg-7">
          <div class="d-flex align-items-center gap-2 mb-3">
            <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-bold" style="font-size: 0.75rem;">AUDITED & COMPLIANT</span>
            <i class="fa-solid fa-shield-check text-success fs-5"></i>
          </div>
          <h3 class="fw-extrabold text-dark mb-3">Diaudit Secara Independen oleh Akuntan Publik</h3>
          <p class="text-muted mb-0" style="line-height: 1.7;">
            Setiap akhir kuartal, seluruh laporan keuangan, donasi masuk, serta bukti pemakaian logistik SIGANA diaudit oleh Kantor Akuntan Publik (KAP) independen terdaftar untuk memastikan kepatuhan regulasi Kementerian Sosial RI dan BNPB.
          </p>
        </div>
        <div class="col-lg-5">
          <div class="d-flex align-items-center justify-content-center justify-content-lg-end gap-3 flex-wrap">
            
            <div class="mitra-logo-box">
              <img src="{{ asset('storage/assets/mitra/kemensos.png') }}" alt="Kemensos RI" class="mitra-logo-img">
              <span class="mitra-logo-label">Kemensos RI</span>
            </div>

            <div class="mitra-logo-box">
              <img src="{{ asset('storage/assets/mitra/BNPB.png') }}" alt="BNPB" class="mitra-logo-img">
              <span class="mitra-logo-label">BNPB</span>
            </div>

            <div class="mitra-logo-box">
              <img src="{{ asset('storage/assets/mitra/KAP AUDITED.png') }}" alt="KAP Audited" class="mitra-logo-img">
              <span class="mitra-logo-label">KAP Audited</span>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  
  // ==========================================
  // Transparency Cards Filtering & Sorting
  // ==========================================
  const searchInput = document.getElementById('transparencySearchInput');
  const filterBtns = document.querySelectorAll('.filter-cat-btn');
  const mobileSelect = document.getElementById('mobileStatusSelect');
  const sortSelect = document.getElementById('transparencySortSelect');
  const grid = document.getElementById('transparencyGrid');
  const emptyState = document.getElementById('transparencyEmptyState');

  if (grid) {
    const cards = Array.from(grid.querySelectorAll('.transparency-card-item'));
    let activeStatus = 'all';
    let searchQuery = '';

    function applyFilterAndSort() {
      let visibleCount = 0;

      // 1. Filtering
      cards.forEach(card => {
        const name = card.getAttribute('data-name');
        const status = card.getAttribute('data-status');

        const matchesSearch = name.includes(searchQuery);
        const matchesStatus = (activeStatus === 'all' || status === activeStatus);

        if (matchesSearch && matchesStatus) {
          card.classList.remove('d-none');
          visibleCount++;
        } else {
          card.classList.add('d-none');
        }
      });

      if (visibleCount === 0) {
        emptyState.classList.remove('d-none');
      } else {
        emptyState.classList.add('d-none');
      }

      // 2. Sorting
      const sortBy = sortSelect.value;
      const sortedCards = [...cards];

      sortedCards.sort((a, b) => {
        if (sortBy === 'newest') {
          return parseInt(b.getAttribute('data-date')) - parseInt(a.getAttribute('data-date'));
        } else if (sortBy === 'progress-highest') {
          return parseFloat(b.getAttribute('data-progress')) - parseFloat(a.getAttribute('data-progress'));
        } else if (sortBy === 'collected-highest') {
          return parseFloat(b.getAttribute('data-collected')) - parseFloat(a.getAttribute('data-collected'));
        } else if (sortBy === 'used-highest') {
          return parseFloat(b.getAttribute('data-used')) - parseFloat(a.getAttribute('data-used'));
        }
        return 0;
      });

      sortedCards.forEach(card => {
        grid.appendChild(card);
      });
    }

    // Input Search Listener
    if (searchInput) {
      searchInput.addEventListener('input', (e) => {
        searchQuery = e.target.value.toLowerCase().trim();
        applyFilterAndSort();
      });
    }

    // Desktop Buttons Filter Listener
    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        activeStatus = btn.getAttribute('data-status');
        
        if (mobileSelect) {
          mobileSelect.value = activeStatus;
        }
        applyFilterAndSort();
      });
    });

    // Mobile Select Filter Listener
    if (mobileSelect) {
      mobileSelect.addEventListener('change', (e) => {
        activeStatus = e.target.value;
        filterBtns.forEach(btn => {
          if (btn.getAttribute('data-status') === activeStatus) {
            btn.classList.add('active');
          } else {
            btn.classList.remove('active');
          }
        });
        applyFilterAndSort();
      });
    }

    // Sort Dropdown Listener
    if (sortSelect) {
      sortSelect.addEventListener('change', applyFilterAndSort);
    }

    // Run sorting once at initial load
    applyFilterAndSort();
  }

  // ==========================================
  // Table Mutasi Filtering
  // ==========================================
  const filterBencana = document.getElementById('filterBencana');
  const filterTipe = document.getElementById('filterTipe');
  const mutasiRows = document.querySelectorAll('.mutasi-row');
  const emptyMutasi = document.getElementById('emptyMutasi');

  function applyTableFilters() {
    const selectedBencana = filterBencana.value;
    const selectedTipe = filterTipe.value;
    let visibleCount = 0;

    mutasiRows.forEach(row => {
      const rowBencana = row.getAttribute('data-bencana');
      const rowTipe = row.getAttribute('data-tipe');

      const matchesBencana = (selectedBencana === 'all' || rowBencana === selectedBencana);
      const matchesTipe = (selectedTipe === 'all' || rowTipe === selectedTipe);

      if (matchesBencana && matchesTipe) {
        row.classList.remove('d-none');
        visibleCount++;
      } else {
        row.classList.add('d-none');
      }
    });

    if (visibleCount === 0) {
      emptyMutasi.classList.remove('d-none');
      document.querySelector('#mutasiTable').classList.add('d-none');
    } else {
      emptyMutasi.classList.add('d-none');
      document.querySelector('#mutasiTable').classList.remove('d-none');
    }
  }

  if (filterBencana) {
    filterBencana.addEventListener('change', applyTableFilters);
  }
  if (filterTipe) {
    filterTipe.addEventListener('change', applyTableFilters);
  }
});
</script>
@endpush
