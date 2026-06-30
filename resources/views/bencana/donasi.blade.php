@extends('layouts.app')

@section('title', 'Donasi — ' . $campaign->title . ' — SIGANA')
@section('meta_description', 'Donasikan sebagian rezeki Anda untuk membantu korban ' . $campaign->title . '. Setiap rupiah tersalurkan secara transparan.')
@section('body_class', 'page-dark-hero')

@section('content')

{{-- ========================
     Hero Section Donasi
======================== --}}
<section class="disaster-hero-section" style="padding: 100px 0 80px;">
  <div class="disaster-hero-overlay"></div>
  <div class="container position-relative z-2">
    <div class="text-center">
      <span class="section-tag section-tag-white mb-4 d-inline-block">
        <i class="fa-solid fa-heart-pulse me-1"></i> Form Donasi
      </span>
      <h1 class="disaster-hero-title">Donasi untuk <span>{{ $campaign->title }}</span></h1>
        <div class="about-hero-breadcrumb mt-3">
          <a href="{{ route('home') }}" class="breadcrumb-link"><i class="fa-solid fa-house me-1"></i>Beranda</a>
          <i class="fa-solid fa-chevron-right mx-2 text-white-50"></i>
          <a href="{{ route('bencana') }}" class="breadcrumb-link">Bencana</a>
          <i class="fa-solid fa-chevron-right mx-2 text-white-50"></i>
          <a href="{{ route('bencana.detail', $campaign->slug) }}" class="breadcrumb-link">Detail</a>
          <i class="fa-solid fa-chevron-right mx-2 text-white-50"></i>
          <span class="text-white">Donasi</span>
        </div>
    </div>
  </div>
</section>

{{-- ========================
     Main Donasi Content
======================== --}}
<section class="py-5 bg-light-section">
  <div class="container py-3">
    <div class="row g-5 justify-content-center">

      {{-- Kolom Kiri: Info Kampanye Ringkas --}}
      <div class="col-lg-4">
        <div class="bg-white rounded-4 p-4 shadow-sm border border-light" style="position: sticky; top: 100px;">
          @php
            $imgPath = $campaign->getRawOriginal('image');
            $imgUrl = $imgPath
              ? (str_starts_with($imgPath, 'storage/') ? asset($imgPath) : asset('storage/' . $imgPath))
              : null;
          @endphp
          <div class="rounded-3 overflow-hidden mb-4" style="height: 180px;">
            @if($imgUrl)
              <img src="{{ $imgUrl }}" class="w-100 h-100 object-fit-cover" alt="{{ $campaign->title }}">
            @else
              <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background:#f1f5f9;color:#94a3b8;">
                <i class="fa-solid fa-image fa-2x"></i>
              </div>
            @endif
          </div>
          <span class="badge {{ $campaign->status_class }} px-3 py-2 mb-3 d-inline-block">
            <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $campaign->status }}
          </span>
          <h5 class="fw-bold text-dark mb-2">{{ $campaign->title }}</h5>
          <p class="text-muted small mb-4" style="line-height: 1.6;">{{ $campaign->description_short }}</p>

          <div class="mb-3">
            <div class="d-flex justify-content-between mb-2">
              <span class="text-muted small">Terkumpul</span>
              <span class="text-primary fw-bold small">{{ $campaign->progress }}</span>
            </div>
            <div class="progress mb-2" style="height: 8px; border-radius: 4px;">
              <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $campaign->progress }}; background-color: {{ $campaign->progress_color }} !important;" aria-valuenow="{{ $campaign->progress_raw }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="d-flex justify-content-between text-muted small">
              <span><strong>{{ $campaign->collected }}</strong> terkumpul</span>
              <span>dari <strong>{{ $campaign->target }}</strong></span>
            </div>
          </div>

          <div class="p-3 bg-light rounded-3 border border-light mt-4">
            <div class="d-flex align-items-start">
              <i class="fa-solid fa-shield-heart text-success fs-4 flex-shrink-0 mt-1"></i>
              <div class="ms-3">
                <h6 class="mb-1 fw-bold small text-dark">Donasi 100% Aman & Transparan</h6>
                <p class="mb-0 text-muted" style="font-size: 0.75rem; line-height: 1.4;">Seluruh dana disalurkan terverifikasi oleh BNPB dan dipantau publik secara real-time.</p>
              </div>
            </div>
          </div>

          <a href="{{ route('bencana.detail', $campaign->slug) }}" class="btn btn-outline-primary w-100 mt-3" style="border-radius: 12px;">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Detail
          </a>
        </div>
      </div>

      {{-- Kolom Kanan: Form Donasi Lengkap --}}
      <div class="col-lg-7">
        <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm border border-light">
          <h4 class="fw-bold text-dark mb-1">Form Pembayaran Donasi</h4>
          <p class="text-muted mb-5" style="font-size: 0.9rem;">Lengkapi formulir di bawah untuk menyalurkan donasi Anda. Semua transaksi diproses secara aman.</p>

          {{-- Step 1: Pilih Nominal --}}
          <div class="donasi-step mb-5">
            <div class="d-flex align-items-center gap-3 mb-4">
              <div class="donasi-step-number">1</div>
              <h5 class="fw-bold mb-0 text-dark">Pilih Nominal Donasi</h5>
            </div>
            <div class="donasi-nominal-grid mb-3" id="nominalGrid">
              <button type="button" class="nominal-btn" data-amount="50000">Rp50.000</button>
              <button type="button" class="nominal-btn" data-amount="100000">Rp100.000</button>
              <button type="button" class="nominal-btn" data-amount="250000">Rp250.000</button>
              <button type="button" class="nominal-btn" data-amount="500000">Rp500.000</button>
              <button type="button" class="nominal-btn" data-amount="1000000">Rp1.000.000</button>
              <button type="button" class="nominal-btn" data-amount="2500000">Rp2.500.000</button>
            </div>
            <div>
              <label class="form-label small fw-semibold text-dark" for="nominalKustom">Atau masukkan jumlah lain (Rp) <span class="text-danger">*</span></label>
              <div class="input-group" style="border-radius: 12px; overflow: hidden;">
                <span class="input-group-text fw-bold bg-light border-end-0 text-muted" style="border-radius: 12px 0 0 12px; border: 1px solid rgba(15,23,42,0.1);">Rp</span>
                <input type="number" id="nominalKustom" class="form-control border-start-0" placeholder="Pilih nominal di atas atau ketik minimal donasi Rp.10.000 " min="10000"
                  style="border-radius: 0 12px 12px 0; height: 52px; border: 1px solid rgba(15,23,42,0.1); font-weight: 600;">
              </div>
              <div id="nominalError" class="text-danger small mt-1 d-none">
                <i class="fa-solid fa-circle-exclamation me-1"></i>Pilih atau masukkan nominal donasi (minimal Rp10.000).
              </div>
            </div>
          </div>

          {{-- Divider --}}
          <hr class="my-4 opacity-25">

          {{-- Step 2: Data Donatur --}}
          <div class="donasi-step mb-5">
              <div class="d-flex align-items-center gap-3 mb-4">
                <div class="donasi-step-number">2</div>
                <h5 class="fw-bold mb-0 text-dark">Data Donatur</h5>
              </div>
              <div class="row g-3">
             <div class="col-md-6">
                <label class="form-label small fw-semibold text-dark" for="donaturNama">
                  Nama Lengkap <span class="text-danger">*</span>
                </label>
                <input type="text" id="donaturNama" class="form-control" 
                      placeholder="Masukkan nama Anda"
                      value="{{ Auth::check()? Auth::user()->name : '' }}"
                      style="height: 52px; border-radius: 12px; border: 1px solid rgba(15,23,42,0.1);">
                <div id="namaError" class="text-danger small mt-1 d-none">
                  <i class="fa-solid fa-circle-exclamation me-1"></i>Nama lengkap wajib diisi.
                </div>
              </div>

              {{-- Pesan --}}
              <div class="col-12">
                <label class="form-label small fw-semibold text-dark" for="donaturPesan">
                  Pesan / Doa <span class="text-muted fw-normal">(Opsional)</span>
                </label>
                <textarea id="donaturPesan" class="form-control" rows="3" 
                          placeholder="Tuliskan pesan atau doa untuk para korban..."
                          maxlength="500"
                          style="border-radius: 12px; border: 1px solid rgba(15,23,42,0.1); resize: none;"></textarea>
                <div class="d-flex justify-content-end mt-1">
                  <span id="pesanCounter" class="text-muted" style="font-size: 0.75rem;">0 / 500</span>
                </div>
              </div>

            </div>
          </div>

          {{-- Ringkasan & Tombol Bayar --}}
          <div class="donasi-summary-box p-4 rounded-3 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="text-muted small">Kampanye</span>
              <span class="fw-semibold small text-dark text-end" style="max-width: 220px;">{{ $campaign->title }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="text-muted small">Nominal Donasi</span>
              <span class="fw-bold text-primary" id="summaryNominal">Belum dipilih</span>
            </div>
            <hr class="opacity-25 my-3">
            <div class="d-flex justify-content-between align-items-center">
              <span class="fw-bold text-dark">Total Pembayaran</span>
              <span class="fw-bold text-primary fs-5" id="summaryTotal">Rp0</span>
            </div>
          </div>

          <div class="d-grid">
            <button class="btn btn-green-custom py-3 fw-bold fs-5" id="btnDonasiKirim" style="border-radius: 14px; letter-spacing: 0.3px;">
              <i class="fa-solid fa-lock me-2"></i>Kirim Donasi Sekarang
            </button>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // =====================
  // State & Elements
  // =====================
  let selectedAmount = null;

  const nominalBtns    = document.querySelectorAll('.nominal-btn');
  const nominalKustom  = document.getElementById('nominalKustom');
  const summaryNominal = document.getElementById('summaryNominal');
  const summaryTotal   = document.getElementById('summaryTotal');
  const pesanInput     = document.getElementById('donaturPesan');
  const pesanCounter   = document.getElementById('pesanCounter');
  const btnKirim       = document.getElementById('btnDonasiKirim');

  // =====================
  // Helpers
  // =====================
  function formatRupiah(num) {
    return 'Rp' + parseInt(num).toLocaleString('id-ID');
  }

  function updateSummary() {
    if (selectedAmount && selectedAmount >= 10000) {
      summaryNominal.textContent = formatRupiah(selectedAmount);
      summaryTotal.textContent   = formatRupiah(selectedAmount);
    } else {
      summaryNominal.textContent = 'Belum dipilih';
      summaryTotal.textContent   = 'Rp0';
    }
  }

  function setError(inputEl, errorEl, msg) {
    inputEl.style.borderColor = '#ef4444';
    errorEl.textContent = '⚠ ' + msg;
    errorEl.classList.remove('d-none');
  }

  function clearError(inputEl, errorEl) {
    inputEl.style.borderColor = 'rgba(15,23,42,0.1)';
    errorEl.classList.add('d-none');
  }

  function setNominalError(msg) {
    nominalKustom.style.borderColor = '#ef4444';
    const err = document.getElementById('nominalError');
    err.textContent = '⚠ ' + msg;
    err.classList.remove('d-none');
  }

  function clearNominalError() {
    nominalKustom.style.borderColor = 'rgba(15,23,42,0.1)';
    document.getElementById('nominalError').classList.add('d-none');
  }

  function setBtnLoading() {
    btnKirim.disabled = true;
    btnKirim.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Memproses...';
  }

  function resetBtn() {
    btnKirim.disabled = false;
    btnKirim.innerHTML = '<i class="fa-solid fa-lock me-2"></i>Kirim Donasi Sekarang';
  }

  // =====================
  // Validasi
  // =====================
  function validateNominal() {
    if (!selectedAmount || selectedAmount < 10000) {
      setNominalError('Pilih atau masukkan nominal donasi (minimal Rp10.000).');
      return false;
    }
    clearNominalError();
    return true;
  }

  function validateNama() {
    const namaInput = document.getElementById('donaturNama');
    const namaError = document.getElementById('namaError');
    if (!namaInput.value.trim()) {
      setError(namaInput, namaError, 'Nama lengkap wajib diisi.');
      return false;
    }
    clearError(namaInput, namaError);
    return true;
  }

  // =====================
  // Events: Nominal
  // =====================
  nominalBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      nominalBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      selectedAmount = parseInt(btn.getAttribute('data-amount'));
      nominalKustom.value = selectedAmount;
      clearNominalError();
      updateSummary();
    });
  });

  nominalKustom.addEventListener('input', (e) => {
    const val = parseInt(e.target.value) || 0;
    nominalBtns.forEach(b => {
      b.classList.toggle('active', parseInt(b.getAttribute('data-amount')) === val);
    });
    selectedAmount = val > 0 ? val : null;
    if (selectedAmount) clearNominalError();
    updateSummary();
  });

  // =====================
  // Events: Pesan Counter & Nama Blur
  // =====================
  if (pesanInput && pesanCounter) {
    pesanInput.addEventListener('input', () => {
      pesanCounter.textContent = pesanInput.value.length + ' / 500';
    });
  }

  document.getElementById('donaturNama').addEventListener('blur', validateNama);
  // =====================
  // Submit
  // =====================
  btnKirim.addEventListener('click', async () => {
    const nominalValid = validateNominal();
    const namaValid    = validateNama();

    if (!nominalValid) {
      nominalKustom.focus();
      Swal.fire({
        icon: 'warning',
        title: 'Nominal belum diisi',
        text: 'Silakan pilih atau masukkan nominal donasi minimal Rp10.000.',
        confirmButtonColor: '#16a34a',
      });
      return;
    }

    if (!namaValid) {
      document.getElementById('donaturNama').focus();
      Swal.fire({
        icon: 'warning',
        title: 'Nama belum diisi',
        text: 'Nama lengkap wajib diisi sebelum melanjutkan pembayaran.',
        confirmButtonColor: '#16a34a',
      });
      return;
    }

    setBtnLoading();

    try {
      const response = await fetch('{{ route("bencana.donasi.transaction", $campaign->slug) }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({
          amount:         selectedAmount,
          name:           document.getElementById('donaturNama').value.trim(),
          message:        document.getElementById('donaturPesan').value.trim(),
          payment_method: 'SNAP',
        }),
      });

      const data = await response.json();

      if (data.errors) {
        Swal.fire({
          icon: 'error',
          title: 'Validasi gagal',
          text: Object.values(data.errors)[0][0],
          confirmButtonColor: '#16a34a',
        });
        resetBtn();
        return;
      }

      window.location.href = data.payment_url;

    } catch (error) {
      console.error(error);
      Swal.fire({
        icon: 'error',
        title: 'Terjadi kesalahan',
        text: 'Silakan coba lagi.',
        confirmButtonColor: '#16a34a',
      });
      resetBtn();
    }
  });
});
</script>
@endpush