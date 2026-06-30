@extends('relawan.layouts.app')

@section('title', 'Sertifikat — ' . $campaign->title)
@section('page_title', 'Sertifikat Relawan')

@push('styles')
<style>
  .back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    color: #64748b;
    text-decoration: none;
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    padding: 8px 16px;
    transition: all .2s ease;
  }
  .back-link:hover {
    color: #fff;
    background: #0a2540;
    border-color: #0a2540;
    transform: translateY(-1px);
  }

  .cert-card {
    border-radius: 16px;
    border: none;
    overflow: hidden;
  }
  .cert-header {
    background: linear-gradient(135deg, #0a2540, #15396b);
    color: #fff;
    padding: 28px;
    text-align: center;
  }
  .cert-header .badge-icon {
    width: 56px; height: 56px;
    border-radius: 50%;
    background: rgba(255,255,255,0.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    margin: 0 auto 12px;
  }
  .cert-header h5 { font-weight: 700; margin-bottom: 4px; }
  .cert-header .sub { font-size: 0.85rem; opacity: 0.85; }

  .cert-preview {
    background: #f8fafc;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 320px;
  }
  .cert-preview img {
    max-width: 100%;
    max-height: 520px;
    border-radius: 10px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.12);
  }
  .cert-preview iframe {
    width: 100%;
    height: 600px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    background: #fff;
  }

  .info-card {
    border-radius: 16px;
    border: none;
  }
  .info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 20px;
    border-bottom: 1px solid #f8fafc;
    font-size: 0.85rem;
  }
  .info-row:last-child { border-bottom: none; }
  .info-label { color: #64748b; }
  .info-value { font-weight: 700; color: #0f172a; text-align: right; }

  .btn-download-cert {
    background: #0a2540; color: #fff; border: none;
    border-radius: 10px; font-weight: 700; font-size: 0.92rem;
    padding: 12px; width: 100%; text-decoration: none;
    display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    transition: all .2s;
  }
  .btn-download-cert:hover { background: #15396b; color: #fff; }

  .notes-box {
    background: #fffbeb;
    border-left: 4px solid #f59e0b;
    border-radius: 10px;
    padding: 14px 18px;
    font-size: 0.85rem;
    color: #92400e;
  }
  .empty-state {
    border-radius: 16px;
    border: none;
    padding: 60px 30px;
    text-align: center;
  }
  .empty-state .icon-wrap {
    width: 72px; height: 72px;
    border-radius: 50%;
    background: #fef9c3;
    color: #b45309;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.8rem;
    margin: 0 auto 18px;
  }
  .empty-state h6 { font-weight: 700; color: #0f172a; margin-bottom: 8px; }
  .empty-state p { color: #64748b; font-size: 0.88rem; max-width: 380px; margin: 0 auto; }
</style>
@endpush

@section('content')

<div class="mb-3">
  <a href="{{ route('relawan.bencana-diikuti') }}" class="back-link">
    <i class="fa-solid fa-arrow-left"></i> Kembali ke Bencana Diikuti
  </a>
</div>

@if(!$certificate)

  <div class="card empty-state shadow-sm">
    <div class="icon-wrap"><i class="fa-solid fa-hourglass-half"></i></div>
    <h6>Sertifikat Belum Diterbitkan</h6>
    <p>
      Sertifikat untuk kampanye <strong>{{ $campaign->title }}</strong> belum diterbitkan oleh admin.
      Sertifikat akan tersedia di sini setelah admin menyelesaikan proses verifikasi.
    </p>
  </div>

@else

<div class="row g-4">
  <div class="col-lg-8">
    <div class="card cert-card shadow-sm">
      <div class="cert-header">
        <div class="badge-icon"><i class="fa-solid fa-certificate"></i></div>
        <h5>{{ $certificate->title }}</h5>
        <div class="sub">{{ $campaign->title }}</div>
      </div>

      <div class="cert-preview">
        @php
          $ext = strtolower(pathinfo($certificate->getRawOriginal('file') ?? $certificate->file, PATHINFO_EXTENSION));
          $fileUrl = Storage::url($certificate->getRawOriginal('file') ?? $certificate->file);
        @endphp

        @if(in_array($ext, ['jpg', 'jpeg', 'png']))
          <img src="{{ $fileUrl }}" alt="{{ $certificate->title }}">
        @elseif($ext === 'pdf')
          <iframe src="{{ $fileUrl }}"></iframe>
        @else
          <div class="text-center text-muted">
            <i class="fa-solid fa-file fa-2x mb-2 d-block"></i>
            Pratinjau tidak tersedia untuk tipe file ini.
          </div>
        @endif
      </div>
    </div>

    @if($certificate->notes)
      <div class="notes-box mt-3">
        <i class="fa-solid fa-circle-info me-1"></i>
        <strong>Catatan:</strong> {{ $certificate->notes }}
      </div>
    @endif
  </div>

  <div class="col-lg-4">
    <div class="card info-card shadow-sm mb-3">
      <div class="card-body p-0">
        <div class="info-row">
          <span class="info-label">Judul Sertifikat</span>
          <span class="info-value">{{ $certificate->title }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Kampanye</span>
          <span class="info-value">{{ $campaign->title }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Tanggal Terbit</span>
          <span class="info-value">{{ $certificate->issued_at }}</span>
        </div>
      </div>
    </div>

    <a href="{{ $fileUrl }}" download class="btn-download-cert">
      <i class="fa-solid fa-download"></i> Unduh Sertifikat
    </a>
  </div>
</div>

@endif

@endsection