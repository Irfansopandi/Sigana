@extends('layouts.app')
@section('title', 'Status Donasi — SIGANA')
@section('body_class', 'finish-page')
@section('content')

@push('styles')
<style>

  body.finish-page #mainNavbar,
  body.finish-page footer.footer {
  display: none !important;
}
.finish-icon-wrap {
  width: 90px; height: 90px;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 2.8rem;
}
.finish-success {
  background: rgba(22,163,74,0.1);
  color: #16a34a;
  animation: popIn 0.5s ease;
}
.finish-pending {
  background: rgba(245,158,11,0.1);
  color: #f59e0b;
}
@keyframes popIn {
  0% { transform: scale(0.5); opacity: 0; }
  70% { transform: scale(1.1); }
  100% { transform: scale(1); opacity: 1; }
}
.finish-detail-box {
  background: #f8fafc;
  border: 1px solid rgba(15,23,42,0.07);
}
.finish-pesan-box {
  background: rgba(59,130,246,0.05);
  border: 1px dashed rgba(59,130,246,0.25);
}
.finish-stat-card {
  background: #f8fafc;
  border: 1px solid rgba(15,23,42,0.07);
  text-align: center;
}
</style>
@endpush

{{-- Main Content --}}
<section class="py-5 bg-light-section" style="padding-top: 120px;">
  <div class="container py-4">
    <div class="row g-4 justify-content-center">

      @if($donation && $donation->getRawOriginal('payment_status') === 'success')

      {{-- Kartu Sukses Utama --}}
      <div class="col-lg-7">
        <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm border border-light text-center">

          {{-- Animated checkmark --}}
          <div class="finish-icon-wrap finish-success mx-auto mb-4">
            <i class="fa-solid fa-circle-check"></i>
          </div>

          <h3 class="fw-bold text-dark mb-1">Donasi Berhasil Diterima!</h3>
          <p class="text-muted mb-4" style="font-size:0.95rem; line-height:1.7;">
            Jazākallāhu khairan, <strong>{{ $donation->name }}</strong>. 
            Donasi Anda sebesar <strong class="text-success">{{ $donation->amount }}</strong> 
            untuk kampanye <em>{{ $campaign->title }}</em> telah kami terima dan akan segera disalurkan kepada yang membutuhkan.
          </p>

          {{-- Detail Transaksi --}}
          <div class="finish-detail-box rounded-3 p-4 mb-4 text-start">
            <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
              <i class="fa-solid fa-receipt text-primary"></i> Detail Transaksi
            </h6>
            <div class="row g-2">
              <div class="col-6">
                <p class="text-muted small mb-1">Order ID</p>
                <p class="fw-semibold text-dark small mb-0" style="word-break:break-all;">{{ $donation->order_id }}</p>
              </div>
              <div class="col-6">
                <p class="text-muted small mb-1">Nominal</p>
                <p class="fw-bold text-success mb-0">{{ $donation->amount }}</p>
              </div>
              <div class="col-6">
                <p class="text-muted small mb-1">Kampanye</p>
                <p class="fw-semibold text-dark small mb-0">{{ $campaign->title }}</p>
              </div>
              <div class="col-6">
                <p class="text-muted small mb-1">Status</p>
                <span class="badge bg-success px-3 py-1">
                  <i class="fa-solid fa-check me-1"></i>Berhasil
                </span>
              </div>
            </div>
          </div>

          @if($donation->message)
          <div class="finish-pesan-box rounded-3 p-3 mb-4 text-start">
            <p class="text-muted small mb-1"><i class="fa-solid fa-quote-left me-1"></i> Pesan Anda</p>
            <p class="fst-italic text-dark mb-0" style="font-size:0.9rem;">"{{ $donation->message }}"</p>
          </div>
          @endif

          {{-- Impact Numbers --}}
          <div class="row g-3 mb-4">
            <div class="col-4">
              <div class="finish-stat-card rounded-3 p-3">
                <i class="fa-solid fa-hand-holding-heart text-danger fs-4 mb-2 d-block"></i>
                <p class="fw-bold text-dark mb-0">{{ $donation->amount }}</p>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Donasi Anda</p>
              </div>
            </div>
            <div class="col-4">
              <div class="finish-stat-card rounded-3 p-3">
                <i class="fa-solid fa-people-group text-primary fs-4 mb-2 d-block"></i>
                <p class="fw-bold text-dark mb-0">{{ $campaign->donors_count ?? '—' }}</p>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Total Donatur</p>
              </div>
            </div>
            <div class="col-4">
              <div class="finish-stat-card rounded-3 p-3">
                <i class="fa-solid fa-chart-line text-success fs-4 mb-2 d-block"></i>
                <p class="fw-bold text-dark mb-0">{{ $campaign->progress }}</p>
                <p class="text-muted mb-0" style="font-size:0.75rem;">Terkumpul</p>
              </div>
            </div>
          </div>

          <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('bencana.detail', $campaign->slug) }}" 
               class="btn btn-primary px-4 py-2 fw-bold" style="border-radius:12px;">
              <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Detail
            </a>
            <a href="{{ route('bencana') }}" 
               class="btn btn-outline-primary px-4 py-2 fw-bold" style="border-radius:12px;">
              <i class="fa-solid fa-heart me-2"></i>Kampanye Lainnya
            </a>
          </div>
        </div>
      </div>

      {{-- Sidebar Kampanye --}}
      <div class="col-lg-4">
          @php
            $imgPath = $campaign->getRawOriginal('image');
            $imgUrl = $imgPath
              ? (str_starts_with($imgPath, 'storage/') ? asset($imgPath) : asset('storage/' . $imgPath))
              : null;
          @endphp
          <div class="rounded-3 overflow-hidden mb-3" style="height:160px;">
            @if($imgUrl)
              <img src="{{ $imgUrl }}" class="w-100 h-100 object-fit-cover" alt="{{ $campaign->title }}">
            @else
              <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background:#f1f5f9;color:#94a3b8;">
                <i class="fa-solid fa-image fa-2x"></i>
              </div>
            @endif
          </div>
          <span class="badge {{ $campaign->status_class }} px-3 py-2 mb-2 d-inline-block">
            <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $campaign->status }}
          </span>
          <h5 class="fw-bold text-dark mb-2">{{ $campaign->title }}</h5>
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
              <span class="text-muted small">Terkumpul</span>
              <span class="text-primary fw-bold small">{{ $campaign->progress }}</span>
            </div>
            <div class="progress mb-2" style="height:8px; border-radius:4px;">
              <div class="progress-bar progress-bar-striped progress-bar-animated"
                   style="width:{{ $campaign->progress }}; background-color:{{ $campaign->progress_color }} !important;"></div>
            </div>
            <div class="d-flex justify-content-between text-muted small">
              <span><strong>{{ $campaign->collected }}</strong> terkumpul</span>
              <span>dari <strong>{{ $campaign->target }}</strong></span>
            </div>
          </div>

          <div class="p-3 bg-light rounded-3 border">
            <div class="d-flex align-items-start gap-2">
              <i class="fa-solid fa-shield-heart text-success fs-5 mt-1"></i>
              <p class="mb-0 text-muted" style="font-size:0.78rem; line-height:1.5;">
                Dana disalurkan terverifikasi oleh BNPB dan dipantau publik secara real-time.
              </p>
            </div>
          </div>
        </div>
      </div>

      @else

      {{-- State non-success (jaga-jaga) --}}
      <div class="col-lg-6">
        <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm border border-light text-center">
          <div class="finish-icon-wrap finish-pending mx-auto mb-4">
            <i class="fa-solid fa-clock"></i>
          </div>
          <h3 class="fw-bold text-dark mb-2">Menunggu Konfirmasi</h3>
          <p class="text-muted mb-4">
            Donasi Anda sedang dalam proses verifikasi. Selesaikan pembayaran sesuai instruksi yang telah dikirim.
          </p>
          <div class="d-flex gap-3 justify-content-center flex-wrap">
            <button id="btnCekStatus" class="btn btn-success px-4 py-2 fw-bold" style="border-radius:12px;">
              <i class="fa-solid fa-rotate me-2"></i>Saya Sudah Bayar
            </button>
            <a href="{{ route('bencana.detail', $campaign->slug) }}" 
              class="btn btn-outline-secondary px-4 py-2 fw-bold" style="border-radius:12px;">
              <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Detail
            </a>
          </div>
        </div>
      </div>

      @endif

    </div>
  </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const btnCek = document.getElementById('btnCekStatus');
if (btnCek) {
  btnCek.addEventListener('click', async function () {
    this.disabled = true;
    this.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Mengecek...';

    try {
      const response = await fetch('{{ route("bencana.donasi.update-status") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ order_id: '{{ $donation->order_id ?? "" }}' }),
      });

      const data = await response.json();

      if (data.status === 'success' || data.status === 'already_success') {
        window.location.reload();
      } else {
        Swal.fire({
          icon: 'info',
          title: 'Pembayaran Belum Terdeteksi',
          text: 'Pembayaran Anda belum kami terima. Pastikan transfer sudah dilakukan.',
          confirmButtonColor: '#16a34a',
        });
        this.disabled = false;
        this.innerHTML = '<i class="fa-solid fa-rotate me-2"></i>Saya Sudah Bayar';
      }
    } catch (e) {
      Swal.fire({ icon: 'error', title: 'Terjadi kesalahan', text: 'Silakan coba lagi.' });
      this.disabled = false;
      this.innerHTML = '<i class="fa-solid fa-rotate me-2"></i>Saya Sudah Bayar';
    }
  });
}
</script>
@endpush
@endsection