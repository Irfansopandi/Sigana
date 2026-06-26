@extends('layouts.app')

@section('title', 'Hubungi Kami — SIGANA')
@section('meta_description', 'Hubungi tim SIGANA untuk pelaporan bencana, pengajuan kemitraan lembaga, pertanyaan seputar donasi, atau pendaftaran relawan.')
@section('body_class', 'page-dark-hero')

@section('content')

{{-- ========================
     Hero Section Hubungi Kami
     ======================== --}}
<section class="about-hero-section">
  <div class="about-hero-overlay"></div>
  <div class="container position-relative z-2">
    <div class="row align-items-center justify-content-center text-center">
      <div class="col-lg-8 animate-on-scroll">
        <span class="section-tag section-tag-white mb-4">
          <i class="fa-solid fa-headset me-1"></i> Hubungi Kami
        </span>
        <h1 class="about-hero-title">Hubungi Tim <span>SIGANA</span></h1>
        <p class="about-hero-desc">
          Kami siap mendengar laporan bencana, kemitraan lembaga, koordinasi relawan, atau menanggapi pertanyaan seputar donasi Anda 24/7.
        </p>
        <div class="about-hero-breadcrumb">
          <a href="{{ route('home') }}" class="breadcrumb-link"><i class="fa-solid fa-house me-1"></i>Beranda</a>
          <i class="fa-solid fa-chevron-right mx-2 text-white-50"></i>
          <span class="text-white">Hubungi Kami</span>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ========================
     Main Content Kontak
     ======================== --}}
<section class="py-5 bg-light-section">
  <div class="container py-4">
    <div class="row g-5">
      
      {{-- Kolom Kiri: Informasi Kontak --}}
      <div class="col-lg-5 animate-on-scroll">
        <span class="section-tag section-tag-red mb-3">
          <i class="fa-solid fa-circle-nodes me-1"></i> Informasi
        </span>
        <h2 class="section-title text-start mb-4">Saluran Komunikasi Resmi</h2>
        <p class="text-muted mb-5" style="line-height: 1.8;">
          Jangan ragu untuk menghubungi kami melalui kanal di bawah ini. Tim tanggap darurat dan admin finansial kami siap melayani kebutuhan Anda.
        </p>

        {{-- Contact Info Cards --}}
        <div class="d-flex flex-column gap-4">
          {{-- Telepon --}}
          <div class="contact-info-card d-flex gap-4">
            <div class="contact-info-icon-box">
              <i class="fa-solid fa-phone-volume"></i>
            </div>
            <div>
              <h5 class="fw-bold text-dark mb-1">Telepon & Hotline</h5>
              <p class="text-muted mb-2 small">Layanan Pelaporan Darurat (24 Jam)</p>
              <div class="d-flex flex-column gap-2 mt-1">
                <a href="tel:+622112345678" class="fw-semibold text-primary">
                  <i class="fa-solid fa-phone fs-6"></i> +62 21-1234-5678
                </a>
                <a href="https://wa.me/6281122334455" target="_blank" class="fw-semibold text-success">
                  <i class="fa-brands fa-whatsapp fs-5"></i> +62 811-2233-4455 <span class="small text-muted fw-normal">(WhatsApp)</span>
                </a>
              </div>
            </div>
          </div>

          {{-- Email --}}
          <div class="contact-info-card d-flex gap-4">
            <div class="contact-info-icon-box" style="--accent-clr: #10b981; --accent-bg: rgba(16, 185, 129, 0.08);">
              <i class="fa-solid fa-envelope-open-text"></i>
            </div>
            <div>
              <h5 class="fw-bold text-dark mb-1">E-mail Resmi</h5>
              <p class="text-muted mb-2 small">Kemitraan, Donasi, & Media</p>
              <div class="d-flex flex-column gap-2 mt-1">
                <a href="mailto:support@sigana.or.id" class="fw-semibold text-primary">
                  <i class="fa-regular fa-envelope fs-6"></i> support@sigana.or.id
                </a>
                <a href="mailto:partnership@sigana.or.id" class="fw-semibold text-primary">
                  <i class="fa-regular fa-envelope fs-6"></i> partnership@sigana.or.id
                </a>
              </div>
            </div>
          </div>

          {{-- Alamat --}}
          <div class="contact-info-card d-flex gap-4">
            <div class="contact-info-icon-box" style="--accent-clr: #ef4444; --accent-bg: rgba(239, 68, 68, 0.08);">
              <i class="fa-solid fa-map-location-dot"></i>
            </div>
            <div>
              <h5 class="fw-bold text-dark mb-1">Kantor Pusat Penyelenggara</h5>
              <p class="text-muted mb-2 small">Gedung BNPB, Lantai 8</p>
              <p class="text-dark fw-medium mt-1 mb-2" style="font-size: 0.9rem; line-height: 1.5;">
                Jl. Pramuka No.38, Utan Kayu Utara, Kec. Matraman, Kota Jakarta Timur, D.K.I. Jakarta 13120
              </p>
              <a href="#peta-lokasi" class="fw-semibold text-danger small" onclick="event.preventDefault(); document.querySelector('.map-marker-pulse').scrollIntoView({behavior: 'smooth', block: 'center'});">
                <i class="fa-solid fa-location-arrow"></i> Lihat Peta Interaktif
              </a>
            </div>
          </div>

          {{-- Jam Operasional --}}
          <div class="contact-info-card d-flex gap-4">
            <div class="contact-info-icon-box" style="--accent-clr: #f59e0b; --accent-bg: rgba(245, 158, 11, 0.08);">
              <i class="fa-solid fa-business-time"></i>
            </div>
            <div>
              <h5 class="fw-bold text-dark mb-1">Jam Operasional</h5>
              <p class="text-muted mb-0 small">Siaga Bencana Lapangan</p>
              <span class="badge bg-success-subtle text-success border border-success-subtle mt-2 px-3 py-1.5 fw-semibold" style="border-radius: 50px;">
                <i class="fa-solid fa-circle-check me-1"></i> Senin – Minggu (24 Jam)
              </span>
            </div>
          </div>
        </div>
      </div>

      {{-- Kolom Kanan: Formulir Kontak Interaktif --}}
      <div class="col-lg-7 animate-on-scroll">
        <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm border border-light">
          <h4 class="fw-bold text-dark mb-2"><i class="fa-solid fa-pen-to-square text-primary me-2"></i>Kirim Pesan</h4>
          <p class="text-muted small mb-4">Lengkapi formulir di bawah ini dan perwakilan tim kami akan segera menghubungi Anda kembali.</p>

          {{-- Dynamic Success Alert (Hidden by default) --}}
          <div id="contactSuccessAlert" class="alert alert-success d-none rounded-3 border border-success-subtle p-3 mb-4" role="alert">
            <div class="d-flex gap-3 align-items-center">
              <i class="fa-solid fa-circle-check text-success fs-4"></i>
              <div>
                <strong class="d-block text-success-emphasis">Pesan Berhasil Dikirim!</strong>
                <span class="small text-success-emphasis" style="opacity: 0.9;">Terima kasih. Kami telah menerima pesan Anda dan akan merespons dalam waktu 1x24 jam.</span>
              </div>
            </div>
          </div>

          {{-- Form --}}
          <form id="interactiveContactForm" onsubmit="handleContactSubmit(event)">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="contact_name" class="form-label fw-semibold text-dark small">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control premium-input" id="contact_name" placeholder="Contoh: Budi Santoso" required>
              </div>
              <div class="col-md-6">
                <label for="contact_email" class="form-label fw-semibold text-dark small">Alamat Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control premium-input" id="contact_email" placeholder="Contoh: budi@gmail.com" required>
              </div>
              <div class="col-md-6">
                <label for="contact_phone" class="form-label fw-semibold text-dark small">Nomor Telepon / WA <span class="text-danger">*</span></label>
                <input type="tel" class="form-control premium-input" id="contact_phone" placeholder="Contoh: 08123456789" required>
              </div>
              <div class="col-md-6">
                <label for="contact_category" class="form-label fw-semibold text-dark small">Kategori Kepentingan <span class="text-danger">*</span></label>
                <select class="form-select premium-input" id="contact_category" required>
                  <option value="" disabled selected>Pilih Kategori...</option>
                  <option value="laporan_donasi">Kendala Transaksi Donasi</option>
                  <option value="kemitraan_lembaga">Pengajuan Kemitraan Lembaga / BPBD</option>
                  <option value="relawan">Pendaftaran Relawan SIGANA</option>
                  <option value="media_relations">Media & Humas</option>
                  <option value="pertanyaan_umum">Pertanyaan Umum / FAQ</option>
                </select>
              </div>
              <div class="col-12">
                <label for="contact_subject" class="form-label fw-semibold text-dark small">Subjek Pesan <span class="text-danger">*</span></label>
                <input type="text" class="form-control premium-input" id="contact_subject" placeholder="Tuliskan subjek ringkas pesan Anda" required>
              </div>
              <div class="col-12">
                <label for="contact_message" class="form-label fw-semibold text-dark small">Isi Pesan / Laporan <span class="text-danger">*</span></label>
                <textarea class="form-control premium-input" id="contact_message" rows="5" placeholder="Tuliskan detail pertanyaan atau laporan Anda secara lengkap..." required></textarea>
              </div>
              <div class="col-12 mt-4">
                <button type="submit" id="contactSubmitBtn" class="btn btn-primary w-100 py-3 d-flex align-items-center justify-content-center gap-2" style="border-radius: 12px; font-weight: 700; font-size: 1rem;">
                  <i class="fa-solid fa-paper-plane"></i>
                  <span id="btnText">Kirim Pesan Sekarang</span>
                  <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ========================
     FAQ Accordion Section
     ======================== --}}
<section class="py-5 bg-white border-top border-bottom border-light">
  <div class="container py-3">
    <div class="text-center mb-5">
      <span class="section-tag section-tag-red"><i class="fa-solid fa-question-circle me-1"></i> FAQ</span>
      <h2 class="section-title">Pertanyaan yang Sering Diajukan</h2>
      <p class="section-desc">Punya pertanyaan seputar cara berdonasi atau pelaporan? Temukan jawabannya langsung di sini.</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-9">
        <div class="accordion" id="faqAccordion">
          
          {{-- FAQ 1 --}}
          <div class="accordion-item faq-item border-0 mb-3 shadow-sm rounded-3 overflow-hidden">
            <h2 class="accordion-header" id="headingFaq1">
              <button class="accordion-button faq-btn fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaq1" aria-expanded="false" aria-controls="collapseFaq1">
                Bagaimana cara SIGANA menjamin transparansi donasi?
              </button>
            </h2>
            <div id="collapseFaq1" class="accordion-collapse collapse" aria-labelledby="headingFaq1" data-bs-parent="#faqAccordion">
              <div class="accordion-body text-muted small" style="line-height: 1.7; font-size: 0.9rem;">
                Setiap donasi yang masuk dicatat secara langsung di dashboard transparansi kami. Di halaman detail transparansi kampanye bencana, Anda bisa mengunduh berkas bukti berupa nota pembelian, kuitansi toko, faktur medis, dan melihat galeri dokumentasi penyaluran dana riil di lapangan. Sistem pencatatan ini juga diaudit secara berkala oleh Kantor Akuntan Publik (KAP) independen.
              </div>
            </div>
          </div>

          {{-- FAQ 2 --}}
          <div class="accordion-item faq-item border-0 mb-3 shadow-sm rounded-3 overflow-hidden">
            <h2 class="accordion-header" id="headingFaq2">
              <button class="accordion-button faq-btn fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaq2" aria-expanded="false" aria-controls="collapseFaq2">
                Bagaimana cara mendaftarkan diri sebagai relawan lapangan?
              </button>
            </h2>
            <div id="collapseFaq2" class="accordion-collapse collapse" aria-labelledby="headingFaq2" data-bs-parent="#faqAccordion">
              <div class="accordion-body text-muted small" style="line-height: 1.7; font-size: 0.9rem;">
                Anda dapat memilih kategori kepentingan "Pendaftaran Relawan SIGANA" pada formulir kontak di atas, menyertakan nomor telepon aktif, dan menuliskan profil ringkas Anda. Tim operasional relawan kami akan menghubungi Anda melalui WhatsApp untuk proses orientasi, pelatihan dasar tanggap darurat bencana, dan penempatan posko terdekat.
              </div>
            </div>
          </div>

          {{-- FAQ 3 --}}
          <div class="accordion-item faq-item border-0 mb-3 shadow-sm rounded-3 overflow-hidden">
            <h2 class="accordion-header" id="headingFaq3">
              <button class="accordion-button faq-btn fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaq3" aria-expanded="false" aria-controls="collapseFaq3">
                Apakah ada batas minimal nominal donasi di SIGANA?
              </button>
            </h2>
            <div id="collapseFaq3" class="accordion-collapse collapse" aria-labelledby="headingFaq3" data-bs-parent="#faqAccordion">
              <div class="accordion-body text-muted small" style="line-height: 1.7; font-size: 0.9rem;">
                Tidak ada batas minimal donasi. Setiap rupiah bantuan Anda sangat berharga bagi pemulihan kondisi korban bencana. SIGANA mendukung transfer bank otomatis (Virtual Account), dompet digital (GOPAY, OVO, DANA, LinkAja), dan pembayaran instan QRIS demi kenyamanan transaksi Anda.
              </div>
            </div>
          </div>

          {{-- FAQ 4 --}}
          <div class="accordion-item faq-item border-0 mb-3 shadow-sm rounded-3 overflow-hidden">
            <h2 class="accordion-header" id="headingFaq4">
              <button class="accordion-button faq-btn fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaq4" aria-expanded="false" aria-controls="collapseFaq4">
                Berapa lama laporan bencana masyarakat diproses dan dipublikasikan?
              </button>
            </h2>
            <div id="collapseFaq4" class="accordion-collapse collapse" aria-labelledby="headingFaq4" data-bs-parent="#faqAccordion">
              <div class="accordion-body text-muted small" style="line-height: 1.7; font-size: 0.9rem;">
                Setelah laporan dikirimkan oleh warga, tim kurasi kami segera memverifikasi keaslian dan koordinasi dengan posko BPBD/BNPB setempat. Proses verifikasi berkas laporan, lokasi, dan foto bukti membutuhkan waktu maksimal 3-6 jam. Jika valid, kampanye donasi bencana tersebut akan segera tayang secara nasional di SIGANA.
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

{{-- ========================
     Peta Lokasi Section
======================== --}}
<section class="py-5 bg-light-section">
  <div class="container py-3 text-center">
    <span class="section-tag section-tag-red"><i class="fa-solid fa-map-location me-1"></i> Lokasi</span>
    <h2 class="section-title">Posko Utama Penanggulangan Bencana</h2>
    <p class="section-desc">Sekretariat utama kami berlokasi strategis di pusat koordinasi bencana nasional.</p>
    
    <div class="mt-4 border border-light shadow-sm rounded-4 overflow-hidden animate-on-scroll" style="height: 420px;">
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3770.274932259893!2d106.86605487475026!3d-6.192803593794827!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f4f5aeb78597%3A0x26ba158b7a7b4745!2sGraha%20Badan%20Nasional%20Penanggulangan%20Bencana!5e1!3m2!1sid!2sid!4v1782373505252!5m2!1sid!2sid"
        width="100%" 
        height="100%" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="strict-origin-when-cross-origin">
      </iframe>
    </div>

    <div class="mt-3 d-flex align-items-center justify-content-center gap-2 text-muted small">
      <i class="fa-solid fa-location-dot text-danger"></i>
      <span>Gedung BNPB Lantai 8, Jl. Pramuka No.38, Utan Kayu Utara, Matraman, Jakarta Timur 13120</span>
    </div>
  </div>
</section>

@endsection

@push('styles')
<style>
/* Floating Marker Animation */
@keyframes floatPin {
  0% { transform: translateY(0); }
  50% { transform: translateY(-12px); }
  100% { transform: translateY(0); }
}

.map-marker-pulse {
  position: absolute;
  bottom: 5px;
  left: 50%;
  transform: translateX(-50%) rotateX(60deg);
  width: 30px;
  height: 30px;
  background-color: rgba(220, 38, 38, 0.35);
  border-radius: 50%;
  z-index: -1;
  animation: markerRipple 2.5s ease-out infinite;
}

@keyframes markerRipple {
  0% { width: 10px; height: 10px; opacity: 1; }
  50% { opacity: 0.5; }
  100% { width: 50px; height: 50px; opacity: 0; }
}

/* Contact Info Cards Styling */
.contact-info-card {
  background-color: #ffffff;
  border: 1px solid rgba(15, 23, 42, 0.05);
  border-radius: 16px;
  padding: 24px;
  transition: all 0.3s ease;
  box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.01), 0 2px 4px -2px rgba(15, 23, 42, 0.01);
}

.contact-info-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.05), 0 8px 10px -6px rgba(15, 23, 42, 0.05);
  border-color: rgba(37, 99, 235, 0.12);
}

.contact-info-card a {
  text-decoration: none !important;
  transition: all 0.25s ease;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  width: fit-content;
}

.contact-info-card a:hover {
  transform: translateX(4px);
  opacity: 0.85;
}

.contact-info-icon-box {
  width: 54px;
  height: 54px;
  border-radius: 12px;
  background-color: rgba(37, 99, 235, 0.08);
  color: var(--primary);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.45rem;
  flex-shrink: 0;
}

/* Input Styles */
.premium-input {
  border: 1.5px solid #e2e8f0;
  border-radius: 10px;
  padding: 10px 14px;
  font-size: 0.92rem;
  font-family: var(--font-body);
  transition: all 0.3s ease;
}

.premium-input:focus {
  border-color: var(--primary);
  box-shadow: 0 0 0 3.5px rgba(37, 99, 235, 0.12);
  color: var(--dark);
}

/* Accordion Custom Styling */
.faq-item {
  border: 1px solid rgba(15, 23, 42, 0.05) !important;
}

.faq-btn {
  background-color: #ffffff !important;
  color: var(--dark) !important;
  font-family: var(--font-title);
  padding: 20px 24px;
  border: none !important;
  box-shadow: none !important;
  transition: all 0.3s ease;
}

.faq-btn:not(.collapsed) {
  background-color: rgba(37, 99, 235, 0.03) !important;
  color: var(--primary) !important;
}

.faq-btn::after {
  background-size: 1rem;
  transition: transform 0.2s ease-in-out;
}

.accordion-body {
  background-color: #ffffff;
  padding: 8px 24px 24px 24px;
}
</style>
@endpush

@push('scripts')
<script>
function handleContactSubmit(event) {
  event.preventDefault();
  
  const submitBtn = document.getElementById('contactSubmitBtn');
  const btnText = document.getElementById('btnText');
  const btnSpinner = document.getElementById('btnSpinner');
  const successAlert = document.getElementById('contactSuccessAlert');
  const contactForm = document.getElementById('interactiveContactForm');
  
  // Set Loading State
  submitBtn.disabled = true;
  btnText.textContent = "Sedang Mengirim...";
  btnSpinner.classList.remove('d-none');
  successAlert.classList.add('d-none');
  
  // Simulate API Network Request delay
  setTimeout(() => {
    // Reset Loading State
    submitBtn.disabled = false;
    btnText.textContent = "Kirim Pesan Sekarang";
    btnSpinner.classList.add('d-none');
    
    // Show Success Alert
    successAlert.classList.remove('d-none');
    successAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
    
    // Reset Form fields
    contactForm.reset();
  }, 1800);
}
</script>
@endpush
