@extends('layouts.app')
@section('title', 'Verifikasi OTP - SIGANA')
@section('body_class', 'auth-page')

@push('styles')
<style>
body.auth-page #mainNavbar,
body.auth-page footer.footer { display: none !important; }
body.auth-page { overflow: hidden; }
html:has(body.auth-page) { overflow: hidden !important; }

.auth-hero {
  min-height: 100vh;
  position: relative;
  overflow: hidden;
  background: linear-gradient(135deg, #0a2540 0%, #173f66 45%, #0d2f52 100%);
  display: flex;
  align-items: center;
}
.auth-hero::before {
  content: "";
  position: absolute; inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px);
  background-size: 38px 38px;
  pointer-events: none; z-index: 1;
}
.auth-card { border-radius: 18px; background: rgba(255,255,255,0.98); }
.bubbles { position: absolute; inset: 0; z-index: 1; overflow: hidden; pointer-events: none; }
.bubbles span {
  position: absolute; bottom: -60px; display: block; border-radius: 50%;
  background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.18);
  animation: bubble-rise linear infinite;
}
@keyframes bubble-rise {
  0%   { transform: translateY(0) translateX(0) scale(1); opacity: 0; }
  10%  { opacity: 0.7; }
  50%  { transform: translateY(-50vh) translateX(15px) scale(1.05); }
  90%  { opacity: 0.5; }
  100% { transform: translateY(-105vh) translateX(-10px) scale(0.95); opacity: 0; }
}
.btn-masuk {
  background: linear-gradient(135deg, #17a8ec, #38bdf8);
  color: #fff; border: none; transition: all 0.2s ease;
}
.btn-masuk:hover {
  background: linear-gradient(135deg, #38bdf8, #7dd3fc) !important;
  color: #fff !important;
  box-shadow: 0 4px 15px rgba(56,189,248,0.4);
}
.step-indicator { display: flex; align-items: center; justify-content: center; margin-bottom: 24px; }
.step-dot {
  width: 32px; height: 32px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 0.8rem; font-weight: 600;
  background: #e2e8f0; color: #94a3b8;
}
.step-dot.active { background: #38bdf8; color: #fff; }
.step-dot.done { background: #0ea5e9; color: #fff; }
.step-line { width: 48px; height: 2px; background: #e2e8f0; }
.step-line.done { background: #0ea5e9; }

/* OTP Input boxes */
.otp-inputs { display: flex; gap: 10px; justify-content: center; margin-bottom: 8px; }
.otp-inputs input {
  width: 42px; height: 50px;
  text-align: center; font-size: 1.4rem; font-weight: 700;
  border: 2px solid #e2e8f0; border-radius: 10px;
  outline: none; transition: border-color 0.2s;
}
.otp-inputs input:focus { border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,0.15); }

.auth-hero .col-lg-5:first-child {
  display: block !important;
}

@media (max-width: 767.98px) {
  .auth-hero {
    min-height: 100vh !important;
    height: 100vh !important;
    align-items: center !important;
    padding: 16px 0 !important;
  }
  .auth-card {
    max-width: 280px !important;
    margin: 0 auto !important;
  }
  .card-body {
    padding: 1rem !important;
  }
  .step-indicator { margin-bottom: 16px !important; }
  .step-dot {
    width: 26px !important;
    height: 26px !important;
    font-size: 0.7rem !important;
  }
  .step-line { width: 36px !important; }
  h5 { font-size: 1rem !important; }
  .otp-inputs input {
    width: 38px !important;
    height: 46px !important;
    font-size: 1.1rem !important;
  }
  .otp-inputs { gap: 6px !important; }
}
</style>

@endpush

@section('content')
<section class="auth-hero">
  <div class="bubbles">
    <span style="left:6%;width:22px;height:22px;animation-duration:14s;animation-delay:0s;"></span>
    <span style="left:14%;width:14px;height:14px;animation-duration:10s;animation-delay:2s;"></span>
    <span style="left:22%;width:30px;height:30px;animation-duration:18s;animation-delay:1s;"></span>
    <span style="left:45%;width:24px;height:24px;animation-duration:16s;animation-delay:0.5s;"></span>
    <span style="left:64%;width:28px;height:28px;animation-duration:17s;animation-delay:2.5s;"></span>
    <span style="left:82%;width:26px;height:26px;animation-duration:15s;animation-delay:0s;"></span>
    <span style="left:90%;width:15px;height:15px;animation-duration:13s;animation-delay:3.5s;"></span>
  </div>

  <div class="container position-relative" style="z-index:2;">
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-7 col-sm-11 py-5" data-aos="fade-up">
        <div class="card border-0 shadow-lg auth-card mx-auto" style="max-width:460px;">
          <div class="card-body p-4 p-md-5">

            {{-- Step Indicator --}}
            <div class="step-indicator">
              <div class="step-dot done"><i class="fa-solid fa-check fa-xs"></i></div>
              <div class="step-line done"></div>
              <div class="step-dot active">2</div>
              <div class="step-line"></div>
              <div class="step-dot">3</div>
            </div>

            <h5 class="mb-1">
              <i class="fa-solid fa-shield-halved me-2" style="color:#38bdf8;"></i>Verifikasi OTP
            </h5>
            <p class="text-muted small mb-4">
              Kode OTP telah dikirim ke <strong>{{ session('otp_email') }}</strong>. Berlaku 10 menit.
            </p>
            {{-- Countdown Timer --}}
            <div class="text-center mb-3">
                <span id="timerBadge" class="badge rounded-pill px-3 py-2"
                    style="background:#e0f2fe; color:#0369a1; font-size:0.85rem;">
                    <i class="fa-solid fa-clock me-1"></i>
                    <span id="timerText">10:00</span>
                </span>
            </div>

            @if($errors->any())
              <div class="alert alert-danger small py-2">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('password.verify-otp') }}" id="otpForm">
              @csrf
              {{-- Hidden input yang dikirim ke server --}}
              <input type="hidden" name="otp" id="otpHidden">

              {{-- 6 kotak OTP --}}
              <div class="otp-inputs mb-3">
                @for($i = 0; $i < 6; $i++)
                  <input type="text" maxlength="1" inputmode="numeric"
                    class="otp-box" data-index="{{ $i }}">
                @endfor
              </div>

              <button type="submit" class="btn btn-masuk w-100 py-2 fw-semibold">
                <i class="fa-solid fa-circle-check me-2"></i>Verifikasi OTP
              </button>
            </form>

            <div class="text-center mt-3 small text-muted">
              Tidak menerima kode?
              <a href="{{ route('password.request') }}" class="text-decoration-none">Kirim Ulang</a>
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
const boxes = document.querySelectorAll('.otp-box');

boxes.forEach((box, i) => {
  box.addEventListener('input', () => {
    box.value = box.value.replace(/\D/g, ''); // angka saja
    if (box.value && i < boxes.length - 1) {
      boxes[i + 1].focus();
    }
    syncHidden();
  });

  box.addEventListener('keydown', (e) => {
    if (e.key === 'Backspace' && !box.value && i > 0) {
      boxes[i - 1].focus();
    }
  });

  // Handle paste
  box.addEventListener('paste', (e) => {
    e.preventDefault();
    const paste = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
    paste.split('').forEach((char, idx) => {
      if (boxes[idx]) boxes[idx].value = char;
    });
    boxes[Math.min(paste.length, 5)].focus();
    syncHidden();
  });
});

function syncHidden() {
  document.getElementById('otpHidden').value =
    [...boxes].map(b => b.value).join('');
}

document.getElementById('otpForm').addEventListener('submit', (e) => {
  syncHidden();
  const otp = document.getElementById('otpHidden').value;
  if (otp.length < 6) {
    e.preventDefault();
    alert('Masukkan 6 digit kode OTP.');
  }
});

// Countdown Timer
const sentAt   = {{ session('otp_sent_at', 0) }};
const expireAt = sentAt + (10 * 60); // 10 menit

function updateTimer() {
    const now       = Math.floor(Date.now() / 1000);
    const remaining = expireAt - now;
    const badge     = document.getElementById('timerBadge');
    const text      = document.getElementById('timerText');

    if (remaining <= 0) {
        text.textContent = '00:00';
        badge.style.background = '#fee2e2';
        badge.style.color      = '#dc2626';
        // Auto-disable tombol & input
        document.querySelector('.btn-masuk').disabled = true;
        document.querySelectorAll('.otp-box').forEach(b => b.disabled = true);
        clearInterval(timerInterval);
        return;
    }

    // Warning saat < 2 menit
    if (remaining < 120) {
        badge.style.background = '#fff7ed';
        badge.style.color      = '#ea580c';
    }

    const m = String(Math.floor(remaining / 60)).padStart(2, '0');
    const s = String(remaining % 60).padStart(2, '0');
    text.textContent = `${m}:${s}`;
}

updateTimer();
const timerInterval = setInterval(updateTimer, 1000);
</script>
@endpush