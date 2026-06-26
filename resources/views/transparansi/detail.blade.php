@extends('layouts.app')

@section('title', 'Laporan Penyaluran — ' . $campaign->title . ' — SIGANA')
@section('meta_description', 'Pantau detail laporan alokasi dana, foto bukti penyaluran, timeline penyaluran bantuan, dan dokumen pertanggungjawaban untuk ' . $campaign->title)
@section('body_class', 'page-dark-hero')

@section('content')

{{-- ========================
     Hero Section Detail Transparansi
======================== --}}
<section class="disaster-hero-section" style="padding: 100px 0 80px;">
  <div class="disaster-hero-overlay"></div>
  <div class="container position-relative z-2">
    <div class="text-center">
      <span class="badge {{ $report->status_class }} px-3 py-2 mb-3" style="border-radius: 50px;">
        <i class="{{ $report->status_icon }} me-1"></i> Laporan: {{ $report->status }}
      </span>
      <h1 class="disaster-hero-title">Laporan Penyaluran: <br><span>{{ $campaign->title }}</span></h1>
      <div class="about-hero-breadcrumb mt-4">
        <a href="{{ route('home') }}" class="breadcrumb-link"><i class="fa-solid fa-house me-1"></i>Beranda</a>
        <i class="fa-solid fa-chevron-right mx-2 text-white-50"></i>
        <a href="{{ route('transparansi') }}" class="breadcrumb-link">Transparansi</a>
        <i class="fa-solid fa-chevron-right mx-2 text-white-50"></i>
        <span class="text-white">Detail Laporan</span>
      </div>
    </div>
  </div>
</section>

{{-- ========================
     Main Content Laporan
======================== --}}
<section class="py-5 bg-light-section">
  <div class="container py-3">
    <div class="row g-5">

      {{-- Kolom Kiri: Detail Laporan, Alokasi, Timeline & Galeri --}}
      <div class="col-lg-8">
        
        <!-- Card Deskripsi Laporan -->
        <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm border border-light mb-4 animate-on-scroll">
          <h4 class="fw-bold text-dark mb-3"><i class="fa-solid fa-file-contract text-primary me-2"></i>Deskripsi Penyaluran Bantuan</h4>
          <p class="text-muted" style="line-height: 1.8; font-size: 1rem;">
            {{ $report->description }}
          </p>
          <p class="text-muted" style="line-height: 1.8; font-size: 1rem;">
            Seluruh data belanja barang logistik, obat-obatan, dan operasional pengiriman diverifikasi ketat oleh tim lapangan SIGANA bersama dengan otoritas posko penanggulangan bencana setempat (BNPB/BPBD).
          </p>
        </div>

        <!-- Card Alokasi Dana Rinci -->
        <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm border border-light mb-4 animate-on-scroll">
          <h4 class="fw-bold text-dark mb-1"><i class="fa-solid fa-chart-pie text-primary me-2"></i>Rincian Alokasi Belanja</h4>
          <p class="text-muted small mb-4">Pembagian dana yang telah digunakan untuk operasional darurat lapangan.</p>
          
          <div class="row g-4">
            @foreach($report->allocations as $alloc)
              <div class="col-md-6">
                <div class="p-3 bg-light rounded-3 border border-light h-100 need-item-card d-flex flex-column justify-content-between">
                  <div>
                    <div class="d-flex align-items-center gap-3 mb-2">
                      <div class="alloc-icon-box">
                        <i class="{{ $alloc->icon }} fs-5"></i>                      
                      </div>
                        <h6 class="fw-bold text-dark mb-0">{{ $alloc->kategori }}</h6>
                    </div>
                    <p class="text-muted small mb-3" style="line-height: 1.4;">{{ $alloc->desc }}</p>
                  </div>
                  <div>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                      <span class="small text-muted">Nominal Terpakai</span>
                      <span class="fw-bold text-danger small">{{ $alloc->nominal }}</span>
                    </div>
                    <div class="progress" style="height: 6px; border-radius: 3px;">
                    <div class="progress-bar" role="progressbar" style="width: {{ $alloc->progress }}; background-color: {{ $campaign->progress_color }} !important;" aria-valuenow="{{ $alloc->progress }}" aria-valuemin="0" aria-valuemax="100"></div>                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Card Timeline Aktivitas Penyaluran -->
        <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm border border-light mb-4 animate-on-scroll">
          <h4 class="fw-bold text-dark mb-1"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i>Timeline Penyaluran</h4>
          <p class="text-muted small mb-5">Urutan kronologis distribusi bantuan yang telah dilaksanakan oleh relawan SIGANA.</p>
          
          <div class="timeline-wrapper">
            @foreach($report->timeline as $time)
              <div class="timeline-item">
                <!-- Timeline Dot Icon -->
                <div class="timeline-dot">
                   <i class="{{ $time->icon }}"></i>
                </div>
                
                <div class="timeline-content">
                  <span class="badge bg-light text-muted border border-light-subtle mb-2 px-2.5 py-1.5 fw-semibold" style="font-size: 0.75rem;">
                    <i class="fa-regular fa-calendar me-1 text-primary"></i> {{ $time->tanggal }}
                  </span>
                  <h6 class="fw-bold text-dark mb-1 fs-5">{{ $time->judul }}</h6>
                  <p class="text-muted small mb-0" style="line-height: 1.6;">{{ $time->deskripsi }}</p>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Card Bukti Foto Penyaluran -->
        <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm border border-light animate-on-scroll">
          <h4 class="fw-bold text-dark mb-1"><i class="fa-solid fa-images text-primary me-2"></i>Galeri Bukti Foto Penyaluran</h4>
          <p class="text-muted small mb-4">Dokumentasi foto penyaluran logistik dan pemeriksaan lapangan oleh relawan.</p>
          
          <div class="row g-3">
            @foreach($report->evidence as $idx => $ev)
              <div class="col-md-4 col-sm-6">
                <div class="rounded-3 overflow-hidden border border-light position-relative" style="height: 160px; cursor: pointer;">
                  <img src="{{ asset($ev['url']) }}" class="w-100 h-100 object-fit-cover doc-gallery-img" alt="{{ $ev['desc'] }}"
                       onclick="showPhotoModal('{{ asset($ev->url) }}', '{{ $ev->desc }}')">
                  <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-70 p-2 text-center text-white" style="font-size: 0.75rem;">
                    Foto Bukti #{{ $idx + 1 }}
                  </div>
                </div>
                <p class="text-muted small text-center mt-2 px-1" style="font-size: 0.75rem; line-height: 1.3;">{{ $ev->desc }}</p>
              </div>
            @endforeach
          </div>
        </div>

      </div>

      {{-- Kolom Kanan: Widget Finansial & Unduhan Dokumen Audit --}}
      <div class="col-lg-4">
        <div style="position: sticky; top: 100px; z-index: 10;">
          <!-- Widget Finansial -->
          <div class="bg-white rounded-4 p-4 shadow-sm border border-light mb-4">
            <h5 class="fw-bold text-dark mb-4">Ikhtisar Penyaluran</h5>
          
          <div class="mb-4">
            <div class="d-flex justify-content-between mb-2">
              <span class="text-muted small">Dana Terkumpul</span>
              <span class="text-primary fw-bold">{{ $report->collected }}</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
              <span class="text-muted small">Alokasi Digunakan</span>
              <span class="text-danger fw-bold">{{ $report->used }}</span>
            </div>
            <hr class="opacity-25 my-3">
            <div class="d-flex justify-content-between mb-3">
              <span class="text-muted small">Sisa Saldo Cadangan</span>
              <span class="text-dark fw-bold">{{ $report->remaining }}</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
              <span class="text-muted small">Korban Terbantu</span>
              <span class="text-success fw-bold">{{ number_format($report->beneficiaries, 0, ',', '.') }} Jiwa</span>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-2 mt-4">
              <span class="text-muted small">Progress Penyaluran</span>
              <span class="fw-bold" style="color: {{ $report->progress_color }};">{{ $report->progress }}</span>
            </div>
            <div class="progress" style="height: 8px; border-radius: 4px;">
              <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                  style="width: {{ $report->progress }}; background-color: {{ $report->progress_color }} !important;"
                  aria-valuenow="{{ $report->progress_raw }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>

          <div class="d-grid gap-3 mb-4">
            <a href="{{ route('bencana.donasi', $campaign->slug) }}" class="btn btn-green-custom py-3" style="border-radius: 12px; font-weight: 700; font-size: 1rem;">
              <i class="fa-solid fa-heart me-2"></i>Bantu Kampanye Ini Lagi
            </a>
          </div>

          <div class="p-3 bg-success-subtle text-success-emphasis rounded-3 border border-success-subtle text-center small mb-4">
            <i class="fa-solid fa-shield-check me-1 fs-5"></i> <strong>Laporan Audited</strong>
            <p class="mb-0 mt-1" style="font-size: 0.72rem; line-height: 1.4; color: var(--text-muted);">
              Sistem pencatatan laporan keuangan ini telah disetujui auditor publik (KAP) independen.
            </p>
          </div>

          <!-- Bagian Dokumen PDF/Nota Pertanggungjawaban -->
          <h6 class="fw-bold text-dark mb-3 mt-4">Kuitansi & Dokumen Pendukung</h6>
          <div class="d-flex flex-column gap-2">
            @foreach($report->docs as $doc)
              <div class="doc-item-card d-flex justify-content-between align-items-center">
                <div style="min-width: 0; flex: 1;">
                  <span class="fw-bold text-dark d-block text-truncate small">{{ $doc->nama }}</span>
                  <span class="text-danger fw-semibold d-block mt-0.5" style="font-size: 0.75rem;">{{ $doc->nominal }}</span>                  
                  <span class="text-muted d-block mt-1" style="font-size: 0.68rem; font-family: monospace;">{{ $doc->doc_id }}</span>              </div>
                <a href="#" class="btn btn-outline-primary btn-sm ms-2 flex-shrink-0" style="border-radius: 8px; font-size: 0.72rem;" onclick="event.preventDefault(); alert('Mengunduh berkas {{ $doc->file }} ...');">
                  <i class="fa-solid fa-download me-1"></i>Unduh
                </a>
              </div>
            @endforeach
          </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ========================
     Photo Evidence Viewer Modal (Simulated)
======================== --}}
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
      <div class="modal-header bg-dark text-white border-0 py-3">
        <h6 class="modal-title fw-bold" id="photoModalLabel">Detail Bukti Penyaluran</h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0 bg-dark text-center">
        <img src="" id="photoModalImage" class="img-fluid w-100" style="max-height: 500px; object-fit: contain;" alt="Bukti Foto">
        <div class="p-3 text-white-50 small bg-black bg-opacity-40" id="photoModalCaption"></div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('styles')
<style>
/* Custom styled icon box for allocations */
.alloc-icon-box {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  background-color: rgba(37, 99, 235, 0.08);
  color: #2563eb;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

/* Enforce visibility of empty progress bar */
.progress {
  background-color: #e2e8f0 !important;
  border: 1px solid rgba(15, 23, 42, 0.02);
}

/* Document cards styling */
.doc-item-card {
  width: 100%;
  max-width: 100%;
  min-width: 0;
  background-color: #f8fafc;
  border: 1px solid #f1f5f9;
  border-radius: 12px;
  padding: 14px 16px;
  transition: all 0.3s ease;
  box-sizing: border-box;
}

.doc-item-card:hover {
  background-color: #ffffff;
  border-color: rgba(37, 99, 235, 0.2);
  box-shadow: 0 6px 16px rgba(15, 23, 42, 0.05);
}

/* Timeline Custom Styles */
.timeline-wrapper {
  position: relative;
  padding-left: 20px;
  border-left: 2.5px solid #f1f5f9;
  margin-left: 15px;
}

.timeline-item {
  position: relative;
  margin-bottom: 40px;
}

.timeline-item:last-child {
  margin-bottom: 0;
}

.timeline-dot {
  position: absolute;
  left: -20px; /* Aligns dot center with wrapper's border-left */
  transform: translateX(-50%);
  top: 0;
  width: 34px;
  height: 34px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--primary), var(--primary-hover));
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 10px rgba(37, 99, 235, 0.15);
  border: 3.5px solid #ffffff;
  z-index: 5;
}

.timeline-content {
  padding-left: 15px;
}
</style>
@endpush

@push('scripts')
<script>
function showPhotoModal(imgUrl, caption) {
  document.getElementById('photoModalImage').src = imgUrl;
  document.getElementById('photoModalCaption').textContent = caption;
  const myModal = new bootstrap.Modal(document.getElementById('photoModal'));
  myModal.show();
}
</script>
@endpush
