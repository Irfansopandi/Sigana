@extends('layouts.app')
@section('title', 'Pembayaran Donasi — SIGANA')
@section('body_class', 'finish-page')

@push('styles')
<style>
  body.finish-page #mainNavbar,
  body.finish-page footer.footer {
    display: none !important;
  }
</style>
@endpush

@section('content')
<section class="py-5 bg-light-section" style="padding-top: 120px;">
  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-5">
        <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm border border-light text-center">

          <div class="mb-4">
            <span class="badge bg-warning bg-opacity-10 text-warning px-4 py-2 rounded-pill fw-bold">
                <i class="fa-solid fa-clock me-2"></i>Menunggu Pembayaran
            </span>
        </div>

          <h4 class="fw-bold text-dark mb-1">Selesaikan Pembayaran</h4>
          <p class="text-muted small mb-4">Order ID: <strong>{{ $donation->order_id }}</strong></p>

          {{-- Ringkasan --}}
          <div class="bg-light rounded-3 p-4 mb-4 text-start">
            <div class="d-flex justify-content-between mb-2">
              <span class="text-muted small">Kampanye</span>
              <span class="fw-semibold small text-dark text-end" style="max-width:200px;">{{ $campaign->title }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
              <span class="text-muted small">Nama Donatur</span>
              <span class="fw-semibold small text-dark">{{ $donation->name }}</span>
            </div>
            <hr class="opacity-25">
            <div class="d-flex justify-content-between align-items-center">
              <span class="fw-bold text-dark">Total Donasi</span>
              <span class="fw-bold text-primary fs-5">Rp {{ number_format($donation->getRawOriginal('amount'), 0, ',', '.') }}</span>
            </div>
          </div>

          <div class="alert alert-light border rounded-3 text-muted small mb-4">
            <i class="fa-solid fa-shield-heart text-success me-2"></i>
            Pembayaran Anda aman dan diproses melalui Midtrans Secure Gateway.
          </div>

          <div class="d-grid">
            <button id="btnBayar" class="btn btn-success py-3 fw-bold fs-5" style="border-radius:14px;">
              <i class="fa-solid fa-lock me-2"></i>Bayar Sekarang
            </button>
          </div>

          <div class="mt-3">
            <a href="{{ route('bencana.donasi', $campaign->slug) }}" 
            class="btn btn-outline-secondary w-100 py-2 fw-semibold" style="border-radius:14px;">
                <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Donasi
            </a>
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
document.getElementById('btnBayar').addEventListener('click', function () {
  window.snap.pay('{{ $donation->snap_token }}', {
    onSuccess: async function () {
      await fetch('{{ route("bencana.donasi.update-status") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ order_id: '{{ $donation->order_id }}' }),
      });
      window.location.href = '{{ route("bencana.donasi.finish", $campaign->slug) }}?order_id={{ $donation->order_id }}';
    },
    onPending: function () {
      Swal.fire({
        icon: 'info',
        title: 'Menunggu Pembayaran',
        text: 'Silakan selesaikan pembayaran sesuai instruksi yang diberikan.',
        confirmButtonColor: '#16a34a',
      });
    },
    onClose: function () {
      Swal.fire({
        icon: 'question',
        title: 'Batalkan Donasi?',
        text: 'Pembayaran belum selesai. Ingin melanjutkan pembayaran?',
        showCancelButton: true,
        confirmButtonText: 'Ya, Batalkan',
        cancelButtonText: 'Lanjutkan Bayar',
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#16a34a',
      }).then((result) => {
        if (!result.isConfirmed) {
          document.getElementById('btnBayar').click();
        }
      });
    },
  });
});

// Timer 15 menit
const createdAt = new Date('{{ $donation->created_at->toIso8601String() }}');
const expiredAt = new Date(createdAt.getTime() + 15 * 60 * 1000);

const timerInterval = setInterval(function () {
    const now = new Date();
    const timeLeft = Math.floor((expiredAt - now) / 1000);

    if (timeLeft <= 0) {
        clearInterval(timerInterval);
        try { window.snap.hide(); } catch (e) {}
        Swal.fire({
            icon: 'error',
            title: 'Waktu Pembayaran Habis',
            text: 'Sesi pembayaran Anda telah berakhir. Silakan donasi kembali.',
            confirmButtonColor: '#ef4444',
            allowOutsideClick: false,
        }).then(() => {
            window.location.href = '{{ route("bencana.donasi", $campaign->slug) }}';
        });
        return;
    }
}, 1000);
</script>
@endpush