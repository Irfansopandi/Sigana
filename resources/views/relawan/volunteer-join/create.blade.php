@extends('layouts.app')

@section('title', 'Gabung Relawan — ' . $campaign->title)
@section('body_class', 'page-dark-hero')

@push('styles')
<style>
  .campaign-header-wrapper {
    max-width: 900px;
    margin: 30px auto 24px;
  }
  .campaign-header-img {
    width: 100%;
    height: 360px;
    object-fit: cover;
    border-radius: 14px;
  }
  .campaign-header-img-wrap { position: relative; }
  .campaign-header-status-badge {
    position: absolute;
    top: 16px; left: 16px;
    padding: 8px 16px;
    border-radius: 999px;
    font-weight: 700;
    font-size: .85rem;
    background: #fbbf24;
    color: #78350f;
  }
  .campaign-header-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 24px;
    margin-top: 18px;
    padding-bottom: 18px;
    border-bottom: 1px solid #e2e8f0;
    font-size: .9rem;
    color: #475569;
  }
  .campaign-header-meta span { display: flex; align-items: center; gap: 6px; }
  .campaign-header-meta strong { color: #0a2540; }
</style>
@endpush

@push('styles')
<style>
  .wizard-steps {
    display: flex;
    align-items: center;
    margin-bottom: 28px;
  }
  .wizard-step {
    display: flex;
    align-items: center;
    gap: 8px;
    flex: 1;
  }
  .wizard-step .circle {
    width: 32px; height: 32px;
    border-radius: 50%;
    background: #e2e8f0;
    color: #64748b;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700;
    font-size: .85rem;
    flex-shrink: 0;
    transition: all .2s;
  }
  .wizard-step.active .circle {
    background: var(--cyan, #38bdf8);
    color: #fff;
  }
  .wizard-step.done .circle {
    background: #22c55e;
    color: #fff;
  }
  .wizard-step .label {
    font-size: .8rem;
    font-weight: 600;
    color: #94a3b8;
  }
  .wizard-step.active .label { color: #0a2540; }
  .wizard-step .line {
    flex: 1;
    height: 2px;
    background: #e2e8f0;
    margin: 0 8px;
  }
  .wizard-step.done .line,
  .wizard-step.active .line { background: var(--cyan, #38bdf8); }

  .form-section {
    border-left: 3px solid var(--cyan, #38bdf8);
    background: #f8fafc;
    border-radius: 8px;
    padding: 18px 20px;
    margin-bottom: 20px;
  }
  .form-section-title {
    font-size: .8rem;
    font-weight: 700;
    color: var(--navy-900, #0a2540);
    text-transform: uppercase;
    letter-spacing: .04em;
    margin-bottom: 14px;
    display: flex; align-items: center; gap: 8px;
  }
  .form-section-title i { color: var(--cyan, #38bdf8); font-size: .9rem; }
  .form-label { font-size: .82rem; font-weight: 600; color: #334155; }
  .form-control, .form-select { font-size: .9rem; }
  .form-control:focus, .form-select:focus {
    border-color: var(--cyan, #38bdf8);
    box-shadow: 0 0 0 3px rgba(56,189,248,.15);
  }

  .koordinator-option {
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 16px;
    cursor: pointer;
    transition: all .2s;
    height: 100%;
  }
  .koordinator-option:hover { border-color: #93c5fd; }
  .koordinator-option.selected {
    border-color: var(--cyan, #38bdf8);
    background: #eff6ff;
  }
  .koordinator-option input { display: none; }

  .keahlian-chip {
    border: 1.5px solid #e2e8f0;
    border-radius: 999px;
    padding: 6px 14px;
    font-size: .82rem;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    transition: all .2s;
    display: inline-block;
    margin: 0 6px 6px 0;
  }
  .keahlian-chip:hover { border-color: #93c5fd; }
  .keahlian-chip.selected {
    background: var(--cyan, #38bdf8);
    border-color: var(--cyan, #38bdf8);
    color: #fff;
  }
  .keahlian-chip input { display: none; }

  .doc-slot-item {
    border: 1.5px dashed #e2e8f0;
    border-radius: 10px;
    padding: 12px;
    background: #f8fafc;
  }

  .wizard-panel { display: none; }
  .wizard-panel.active { display: block; }

  .btn-kirim, .btn-next {
    background: var(--cyan, #38bdf8);
    border: none;
    color: #fff;
    font-weight: 600;
    transition: all .2s;
  }
  .btn-kirim:hover, .btn-next:hover { background: #0ea5e9; color: #fff; }
</style>
@endpush

@section('content')
@section('content')

<section class="disaster-hero-section">
  <div class="disaster-hero-overlay"></div>
  <div class="container position-relative z-2">
    <div class="row align-items-center justify-content-center text-center">
      <div class="col-lg-8 animate-on-scroll animate-fade-in-left">
        <span class="section-tag section-tag-white mb-4">
          <i class="fa-solid fa-hand-holding-heart me-1"></i> Aksi Kemanusiaan
        </span>
        <h1 class="disaster-hero-title">Gabung jadi Relawan: <span>{{ $campaign->title }}</span></h1>
        <div class="about-hero-breadcrumb">
          <a href="{{ route('home') }}" class="breadcrumb-link"><i class="fa-solid fa-house me-1"></i>Beranda</a>
          <i class="fa-solid fa-chevron-right mx-2 text-white-50"></i>
          <a href="{{ route('bencana') }}" class="breadcrumb-link">Bencana</a>
          <i class="fa-solid fa-chevron-right mx-2 text-white-50"></i>
          <span class="text-white">Gabung Relawan</span>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="container">
  <div class="campaign-header-wrapper">
    <div class="campaign-header-img-wrap">
      <span class="campaign-header-status-badge">
        <i class="fa-solid fa-triangle-exclamation me-1"></i> Status: {{ $campaign->status }}
      </span>
      <img src="{{ $campaign->image_url }}" class="campaign-header-img" alt="{{ $campaign->title }}">
    </div>
    <div class="campaign-header-meta">
      <span><i class="fa-solid fa-location-dot text-danger"></i> {{ $campaign->location }}</span>
      <span><i class="fa-regular fa-calendar text-primary"></i> Diterbitkan: <strong>{{ \Carbon\Carbon::parse($campaign->getRawOriginal('date_published'))->translatedFormat('d F Y') }}</strong></span>
      <span><i class="fa-solid fa-tag text-success"></i> Kategori: <strong>{{ $campaign->category }}</strong></span>
    </div>
    @if($campaign->victims)
      <div class="campaign-header-meta" style="border-bottom:none; padding-top:0;">
        <span><i class="fa-solid fa-people-group text-danger"></i> Korban Terdampak: <strong>{{ number_format($campaign->victims, 0, ',', '.') }} Jiwa</strong></span>
      </div>
    @endif
  </div>
</div>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm">
      <div class="card-body p-4">

        <div class="d-flex align-items-center gap-2 mb-1">
          <i class="fa-solid fa-hand-holding-heart text-danger"></i>
          <h5 class="fw-bold mb-0">Gabung jadi Relawan</h5>
        </div>
        <p class="text-muted small mb-4">
          Kampanye: <strong>{{ $campaign->title }}</strong> — {{ $campaign->location }}
        </p>

        {{-- ── WIZARD STEPS INDICATOR ── --}}
        <div class="wizard-steps" id="wizardSteps">
          <div class="wizard-step active" data-step="1">
            <div class="circle">1</div>
            <span class="label">Data Diri</span>
          </div>
          <div class="line"></div>
          <div class="wizard-step" data-step="2">
            <div class="circle">2</div>
            <span class="label">Keahlian & Tugas</span>
          </div>
          <div class="line" id="lineToStep3"></div>
          <div class="wizard-step" data-step="3" id="step3Indicator">
            <div class="circle">3</div>
            <span class="label">Dokumen</span>
          </div>
        </div>

        @if($errors->any())
          <div class="alert alert-danger">
            <strong>Ada kesalahan input:</strong>
            <ul class="mb-0 mt-1">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('relawan.volunteer-join.store', $campaign->id) }}" method="POST" enctype="multipart/form-data" id="volunteerForm">
          @csrf

          {{-- ══════════ FASE 1 — DATA DIRI ══════════ --}}
          <div class="wizard-panel active" data-panel="1">
            <div class="form-section">
              <div class="form-section-title"><i class="fa-solid fa-id-card"></i> Data Diri</div>
              <p class="text-muted small mb-3">Data ini diambil dari profil akun kamu. Bisa diedit ulang kalau ada yang perlu diperbarui.</p>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Nama Lengkap</label>
                  <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">No. HP</label>
                  <input type="text" name="phone" id="phoneInput" class="form-control" inputmode="numeric" pattern="[0-9]*"
                    value="{{ old('phone', auth()->user()->phone) }}" placeholder="08xxxxxxxxxx" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="inp_tgl" class="form-control"
                        value="{{ old('tanggal_lahir', optional(auth()->user()->tanggal_lahir)->format('Y-m-d')) }}" required>
                    <div id="hint_tgl" style="font-size:0.78rem;margin-top:4px;"></div>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Jenis Kelamin</label>
                  <select name="jenis_kelamin" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <option value="laki-laki" {{ old('jenis_kelamin', auth()->user()->jenis_kelamin) === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="perempuan" {{ old('jenis_kelamin', auth()->user()->jenis_kelamin) === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-section mb-3">
              <div class="form-section-title"><i class="fa-solid fa-star"></i> Minat Jadi Koordinator?</div>
              <p class="text-muted small mb-3">Koordinator bertanggung jawab mengkoordinasikan relawan lain di lokasi dan melapor ke admin.</p>
              <input type="hidden" name="minat_koordinator" id="minatKoordinatorInput" value="{{ old('minat_koordinator', 0) }}">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="koordinator-option d-flex align-items-start gap-3" id="optYa">
                    <input type="radio" name="minat_koordinator_radio" value="1" {{ old('minat_koordinator') ? 'checked' : '' }}>
                    <i class="fa-solid fa-user-tie fa-lg text-primary mt-1"></i>
                    <div>
                      <div class="fw-semibold">Ya, saya minat</div>
                      <div class="text-muted small">Lanjut ke 3 fase pendaftaran (termasuk upload dokumen pendukung)</div>
                    </div>
                  </label>
                </div>
                <div class="col-md-6">
                  <label class="koordinator-option d-flex align-items-start gap-3 selected" id="optTidak">
                    <input type="radio" name="minat_koordinator_radio" value="0" {{ !old('minat_koordinator') ? 'checked' : '' }}>
                    <i class="fa-solid fa-user fa-lg text-secondary mt-1"></i>
                    <div>
                      <div class="fw-semibold">Tidak, jadi relawan biasa</div>
                      <div class="text-muted small">Lanjut ke 2 fase pendaftaran saja</div>
                    </div>
                  </label>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
              <a href="{{ route('relawan.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left"></i> Batal
              </a>
              <button type="button" class="btn btn-next px-4" data-next="2">
                Lanjut <i class="fa-solid fa-arrow-right"></i>
              </button>
            </div>
          </div>

          {{-- ══════════ FASE 2 — KEAHLIAN & TUGAS ══════════ --}}
          <div class="wizard-panel" data-panel="2">
            <div class="form-section">
              <div class="form-section-title"><i class="fa-solid fa-screwdriver-wrench"></i> Keahlian</div>
              <p class="text-muted small mb-3">Pilih keahlian yang kamu punya (bisa pilih lebih dari satu).</p>
              <div id="keahlianWrapper">
                @php
                  $opsiKeahlian = ['Medis', 'Logistik', 'Dapur Umum', 'Evakuasi', 'Komunikasi', 'Administrasi', 'Mengemudi', 'Psikososial'];
                  $oldKeahlian = old('keahlian', []);
                @endphp
                @foreach($opsiKeahlian as $k)
                  <label class="keahlian-chip {{ in_array($k, $oldKeahlian) ? 'selected' : '' }}">
                    <input type="checkbox" name="keahlian[]" value="{{ $k }}" {{ in_array($k, $oldKeahlian) ? 'checked' : '' }}>
                    {{ $k }}
                  </label>
                @endforeach
              </div>
            </div>

            <div class="form-section">
              <div class="form-section-title"><i class="fa-solid fa-list-check"></i> Pilih Tugas</div>
              <p class="text-muted small mb-3">Pilih salah satu tugas yang sudah disiapkan admin, atau ajukan minat tugas lain.</p>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Tugas yang Tersedia</label>
                  <select name="campaign_role_id" id="roleSelect" class="form-select">
                    <option value="">-- Pilih Tugas --</option>
                    @foreach($campaign->roles as $role)
                      <option value="{{ $role->id }}" {{ old('campaign_role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->nama }} @if($role->kuota) (Kuota: {{ $role->kuota }}) @endif
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Minat Tugas Lain <span class="text-muted">(opsional)</span></label>
                  <input type="text" name="tugas_lain" id="tugasLainInput" class="form-control"
                    value="{{ old('tugas_lain') }}" placeholder="Contoh: Dokumentasi & media sosial">
                </div>
              </div>
            </div>

            <div class="form-section" id="pengalamanSection">
              <div class="form-section-title"><i class="fa-solid fa-briefcase"></i> Pengalaman Relawan</div>
              <textarea name="pengalaman" class="form-control" rows="3" placeholder="Ceritakan pengalaman kamu sebagai relawan sebelumnya...">{{ old('pengalaman') }}</textarea>
            </div>

            <div class="form-section mb-3">
              <div class="form-section-title"><i class="fa-solid fa-comment-dots"></i> Alasan Ikut Relawan</div>
              <textarea name="alasan" class="form-control" rows="3" placeholder="Ceritakan alasan kamu ingin jadi relawan di kampanye ini..." required>{{ old('alasan') }}</textarea>
            </div>

            <div class="d-flex justify-content-between mt-4">
              <button type="button" class="btn btn-outline-secondary" data-prev="1">
                <i class="fa-solid fa-arrow-left"></i> Kembali
              </button>
              <button type="button" class="btn btn-next px-4" id="btnNextOrSubmit" data-next="3">
                Lanjut <i class="fa-solid fa-arrow-right"></i>
              </button>
            </div>
          </div>

          {{-- ══════════ FASE 3 — DOKUMEN (HANYA JIKA MINAT KOORDINATOR) ══════════ --}}
          <div class="wizard-panel" data-panel="3">
            <div class="form-section mb-3">
              <div class="form-section-title"><i class="fa-solid fa-paperclip"></i> Dokumen / Sertifikat Pendukung</div>
              <p class="text-muted small mb-3">Lampirkan sertifikat pelatihan, pengalaman, atau dokumen pendukung lain (foto/PDF, maks. 2MB per file). Dokumentasi 1 wajib diisi.</p>

              <div class="row g-3">
                @for ($i = 1; $i <= 3; $i++)
                  <div class="col-md-4">
                    <div class="doc-slot-item">
                      <div class="small text-muted mb-2 fw-semibold">
                        Dokumen {{ $i }} @if($i === 1)<span class="text-danger">*</span>@endif
                      </div>
                      <div id="docPreview{{ $i }}">
                        <div class="text-muted small py-3 text-center border rounded">Belum ada file</div>
                      </div>
                      <div class="d-flex gap-2 mt-2">
                        <input type="file" class="form-control form-control-sm doc-single-input"
                          data-slot="{{ $i }}" name="dokumen_{{ $i }}" accept=".pdf,image/*">
                      </div>
                    </div>
                  </div>
                @endfor
              </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
              <button type="button" class="btn btn-outline-secondary" data-prev="2">
                <i class="fa-solid fa-arrow-left"></i> Kembali
              </button>
              <button type="submit" class="btn btn-kirim px-4">
                <i class="fa-solid fa-paper-plane"></i> Kirim Pendaftaran
              </button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // ── Filter input phone biar cuma angka yang bisa diketik ──
  document.getElementById('phoneInput').addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  // ── Pilihan Minat Koordinator ──
  const optYa = document.getElementById('optYa');
  const optTidak = document.getElementById('optTidak');
  const minatInput = document.getElementById('minatKoordinatorInput');
  const step3Indicator = document.getElementById('step3Indicator');
  const lineToStep3 = document.getElementById('lineToStep3');
  const btnNextOrSubmit = document.getElementById('btnNextOrSubmit');

  function setMinatKoordinator(value) {
    minatInput.value = value;
    if (value === '1') {
      optYa.classList.add('selected');
      optTidak.classList.remove('selected');
      step3Indicator.style.display = '';
      lineToStep3.style.display = '';
      btnNextOrSubmit.setAttribute('type', 'button');
      btnNextOrSubmit.setAttribute('data-next', '3');
      btnNextOrSubmit.innerHTML = 'Lanjut <i class="fa-solid fa-arrow-right"></i>';
    } else {
      optTidak.classList.add('selected');
      optYa.classList.remove('selected');
      step3Indicator.style.display = 'none';
      lineToStep3.style.display = 'none';
      btnNextOrSubmit.setAttribute('type', 'submit');
      btnNextOrSubmit.removeAttribute('data-next');
      btnNextOrSubmit.innerHTML = 'Kirim Pendaftaran <i class="fa-solid fa-paper-plane"></i>';
    }
  }

  optYa.addEventListener('click', () => setMinatKoordinator('1'));
  optTidak.addEventListener('click', () => setMinatKoordinator('0'));

  // Set kondisi awal sesuai old() / default
  setMinatKoordinator(minatInput.value === '1' ? '1' : '0');

  // ── Navigasi Wizard ──
  const panels = document.querySelectorAll('.wizard-panel');
  const steps = document.querySelectorAll('.wizard-step');

  function goToStep(stepNumber) {
    panels.forEach(p => p.classList.toggle('active', p.dataset.panel === String(stepNumber)));
    steps.forEach(s => {
      const n = parseInt(s.dataset.step);
      s.classList.toggle('active', n === stepNumber);
      s.classList.toggle('done', n < stepNumber);
    });
    window.scrollTo({ top: document.querySelector('.card').offsetTop - 20, behavior: 'smooth' });
  }

  document.querySelectorAll('[data-next]').forEach(btn => {
    btn.addEventListener('click', function() {
        const currentPanel = this.closest('.wizard-panel');

        // Validasi sederhana sebelum lanjut step
        const requiredInputs = currentPanel.querySelectorAll('[required]');
        for (const input of requiredInputs) {
        if (!input.checkValidity()) {
            input.reportValidity();
            return;
        }
        }

        // Validasi umur minimal 17 tahun khusus di fase 1
        if (currentPanel.dataset.panel === '1' && !checkUmur()) {
        Swal.fire('Tidak Memenuhi Syarat', 'Usia minimal untuk mendaftar relawan adalah 17 tahun.', 'warning');
        return;
        }

        goToStep(parseInt(this.dataset.next));
    });
    });

  document.querySelectorAll('[data-prev]').forEach(btn => {
    btn.addEventListener('click', function() {
      goToStep(parseInt(this.dataset.prev));
    });
  });

  // ── Chip Keahlian ──
  document.querySelectorAll('.keahlian-chip').forEach(chip => {
    chip.addEventListener('click', function() {
      const checkbox = this.querySelector('input');
      checkbox.checked = !checkbox.checked;
      this.classList.toggle('selected', checkbox.checked);
    });
  });

  // ── Preview dokumen per slot ──
  document.querySelectorAll('.doc-single-input').forEach(input => {
    input.addEventListener('change', function() {
      const slot = this.dataset.slot;
      const preview = document.getElementById('docPreview' + slot);

      if (this.files && this.files[0]) {
        const file = this.files[0];

        if (file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = ev => {
            preview.innerHTML = `<img src="${ev.target.result}" style="width:100%;height:80px;object-fit:cover;border-radius:6px;" alt="Preview">`;
          };
          reader.readAsDataURL(file);
        } else {
          preview.innerHTML = `
            <div class="d-flex align-items-center gap-2 py-2">
              <i class="fa-solid fa-file-pdf text-danger fa-lg"></i>
              <span class="small">${file.name}</span>
            </div>`;
        }
      } else {
        preview.innerHTML = '<div class="text-muted small py-3 text-center border rounded">Belum ada file</div>';
      }
    });
  });

  // ── Validasi umur minimal 17 tahun ──
    function checkUmur() {
    const tgl = document.getElementById('inp_tgl').value;
    const hint = document.getElementById('hint_tgl');
    let ageOk = false;

    if (tgl) {
        const age = (new Date() - new Date(tgl)) / (365.25 * 24 * 3600 * 1000);
        ageOk = age >= 17;
        if (!ageOk) {
        hint.innerHTML = '<span style="color:#ef4444;"><i class="fa-solid fa-circle-xmark me-1"></i>Usia minimal 17 tahun.</span>';
        } else {
        hint.innerHTML = '<span style="color:#22c55e;"><i class="fa-solid fa-circle-check me-1"></i>Usia valid.</span>';
        }
    } else {
        hint.innerHTML = '';
    }
    return ageOk;
    }

    document.getElementById('inp_tgl').addEventListener('change', checkUmur);
    document.getElementById('inp_tgl').addEventListener('input', checkUmur);
    checkUmur();

  // ── Konfirmasi sebelum submit ──
  document.getElementById('volunteerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    Swal.fire({
      title: 'Kirim pendaftaran relawan?',
      text: 'Pastikan data yang kamu isi sudah benar sebelum dikirim.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#38bdf8',
      cancelButtonColor: '#64748b',
      confirmButtonText: 'Ya, kirim',
      cancelButtonText: 'Cek lagi'
    }).then((result) => {
      if (result.isConfirmed) form.submit();
    });
  });
</script>
@endpush