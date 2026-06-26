@extends('layouts.app')
@section('title', 'Lupa Sandi - SIGANA')
@section('body_class', 'auth-page')

@push('styles')
<style>
body.auth-page #mainNavbar,
body.auth-page footer.footer {
  display: none !important;
}
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
  position: absolute;
  inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px);
  background-size: 38px 38px;
  pointer-events: none;
  z-index: 1;
}

.auth-card {
  border-radius: 18px;
  background: rgba(255,255,255,0.98);
}

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
  color: #ffffff;
  border: none;
  transition: all 0.2s ease;
}
.btn-masuk:hover {
  background: linear-gradient(135deg, #38bdf8, #7dd3fc) !important;
  color: #ffffff !important;
  box-shadow: 0 4px 15px rgba(56,189,248,0.4);
}

.step-indicator {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0;
  margin-bottom: 24px;
}
.step-dot {
  width: 32px; height: 32px;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 0.8rem; font-weight: 600;
  background: #e2e8f0; color: #94a3b8;
}
.step-dot.active {
  background: #38bdf8; color: #fff;
}
.step-dot.done {
  background: #0ea5e9; color: #fff;
}
.step-line {
  width: 48px; height: 2px;
  background: #e2e8f0;
}
.step-line.done { background: #0ea5e9; }
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
              <div class="step-dot active">1</div>
              <div class="step-line"></div>
              <div class="step-dot">2</div>
              <div class="step-line"></div>
              <div class="step-dot">3</div>
            </div>

            <h5 class="mb-1">
              <i class="fa-solid fa-envelope me-2" style="color:#38bdf8;"></i>Lupa Kata Sandi
            </h5>
            <p class="text-muted small mb-4">Masukkan email Anda, kami akan kirimkan kode OTP.</p>

            @if(session('success'))
              <div class="alert alert-success small py-2">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('password.send-otp') }}">
              @csrf
              <div class="mb-3">
                <label class="form-label">Alamat Email</label>
                <input type="email" name="email"
                  class="form-control @error('email') is-invalid @enderror"
                  placeholder="nama@email.com"
                  value="{{ old('email') }}" required autofocus>
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <button type="submit" class="btn btn-masuk w-100 py-2 fw-semibold">
                <i class="fa-solid fa-paper-plane me-2"></i>Kirim Kode OTP
              </button>
            </form>

            <div class="text-center mt-3 small text-muted">
              Ingat sandi? <a href="{{ route('login') }}" class="text-decoration-none">Masuk Sekarang</a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection