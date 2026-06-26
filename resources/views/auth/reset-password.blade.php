@extends('layouts.app')
@section('title', 'Reset Password - SIGANA')
@section('body_class', 'auth-page')

@push('styles')
<style>
body.auth-page #mainNavbar,
body.auth-page footer.footer { display: none !important; }
body.auth-page { overflow: hidden; }
html:has(body.auth-page) { overflow: hidden !important; }

.auth-hero {
  min-height: 100vh;
  position: relative; overflow: hidden;
  background: linear-gradient(135deg, #0a2540 0%, #173f66 45%, #0d2f52 100%);
  display: flex; align-items: center;
}
.auth-hero::before {
  content: ""; position: absolute; inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px);
  background-size: 38px 38px; pointer-events: none; z-index: 1;
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
  color: #fff !important; box-shadow: 0 4px 15px rgba(56,189,248,0.4);
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
.password-toggle {
  background: none; border: none;
  position: absolute !important; top: 0 !important; right: 0.75rem !important;
  height: 38px !important; display: flex !important; align-items: center !important;
  z-index: 5; padding: 0 !important;
}
.password-toggle:hover { color: #0ea5e9 !important; }
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
              <div class="step-dot done"><i class="fa-solid fa-check fa-xs"></i></div>
              <div class="step-line done"></div>
              <div class="step-dot active">3</div>
            </div>

            <h5 class="mb-1">
              <i class="fa-solid fa-lock me-2" style="color:#38bdf8;"></i>Password Baru
            </h5>
            <p class="text-muted small mb-4">Buat password baru yang kuat untuk akun Anda.</p>

            @if($errors->any())
              <div class="alert alert-danger small py-2">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
              @csrf

              <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <div class="position-relative">
                  <input type="password" name="password"
                    class="form-control pe-5 @error('password') is-invalid @enderror"
                    id="newPassword" placeholder="••••••••" required>
                  <button type="button" class="password-toggle text-muted"
                    onclick="togglePassword('newPassword', this)" tabindex="-1">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                </div>
                <div class="form-text small">Minimal 8 karakter.</div>
              </div>

              <div class="mb-4">
                <label class="form-label">Konfirmasi Password Baru</label>
                <div class="position-relative">
                  <input type="password" name="password_confirmation"
                    class="form-control pe-5"
                    id="confirmPassword" placeholder="••••••••" required>
                  <button type="button" class="password-toggle text-muted"
                    onclick="togglePassword('confirmPassword', this)" tabindex="-1">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                </div>
              </div>

              <button type="submit" class="btn btn-masuk w-100 py-2 fw-semibold">
                <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Password Baru
              </button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
function togglePassword(inputId, btn) {
  const input = document.getElementById(inputId);
  const icon = btn.querySelector('i');
  if (input.type === 'password') {
    input.type = 'text';
    icon.classList.replace('fa-eye', 'fa-eye-slash');
  } else {
    input.type = 'password';
    icon.classList.replace('fa-eye-slash', 'fa-eye');
  }
}
</script>
@endpush