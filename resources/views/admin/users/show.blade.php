@extends('admin.layouts.app')

@section('title', 'Detail Pengguna')
@section('page_title', 'Detail Pengguna')

@push('styles')
<style>
  .detail-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: #94a3b8;
    margin-bottom: 4px;
  }
  .detail-value {
    font-size: 0.95rem;
    color: #1e293b;
    font-weight: 500;
  }
  .detail-row {
    padding: 14px 0;
    border-bottom: 1px solid #f1f5f9;
  }
  .detail-row:last-child { border-bottom: none; }
  .user-avatar-lg {
    width: 64px; height: 64px;
    border-radius: 16px;
    background: linear-gradient(135deg, #2563eb, #60a5fa);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem; font-weight: 700; color: #fff;
    flex-shrink: 0;
  }
</style>
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-user text-primary me-2"></i>Detail Pengguna</h5>
    <p class="text-muted small mb-0">Informasi lengkap akun pengguna.</p>
  </div>
  <a href="{{ route('admin.users.index') }}" class="btn btn-sm px-4"
    style="border-radius:8px; border:1.5px solid #e2e8f0; color:#64748b; background:#fff;">
    <i class="fa-solid fa-arrow-left me-2"></i>Kembali
  </a>
</div>

<div class="row g-4">
  {{-- Kolom Kiri --}}
  <div class="col-lg-8">
    {{-- Header Profil --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius:1rem;">
      <div class="card-body p-4">
        <div class="d-flex align-items-center gap-4">
          <div class="user-avatar-lg">
            {{ strtoupper(substr($user->name, 0, 1)) }}
          </div>
          <div>
            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
            <div class="text-muted small">{{ $user->email }}</div>
            <div class="mt-2 d-flex gap-2 flex-wrap">
              @php
                $roleStyle = match($user->role) {
                  'relawan' => 'background:#dcfce7; color:#166534;',
                  'admin'   => 'background:#fef9c3; color:#854d0e;',
                  default   => 'background:#eff6ff; color:#1d4ed8;',
                };
              @endphp
              <span class="badge rounded-pill px-3 py-2" style="{{ $roleStyle }} font-size:0.78rem;">
                {{ ucfirst($user->role) }}
              </span>
                @if($user->role === 'relawan')
                    @if($user->email_verified_at)
                        <span class="badge rounded-pill px-3 py-2" style="background:#dcfce7; color:#166534; font-size:0.78rem;">
                        <i class="fa-solid fa-circle-check me-1"></i>Terverifikasi
                        </span>
                    @else
                        <span class="badge rounded-pill px-3 py-2" style="background:#fee2e2; color:#991b1b; font-size:0.78rem;">
                        <i class="fa-solid fa-circle-xmark me-1"></i>Belum Diverifikasi
                        </span>
                    @endif
                @endif
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Informasi Pribadi --}}
    <div class="card border-0 shadow-sm" style="border-radius:1rem;">
      <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
        <h6 class="fw-semibold"><i class="fa-solid fa-id-card me-2 text-primary"></i>Informasi Pribadi</h6>
      </div>
      <div class="card-body px-4 pb-4">
        <div class="row g-0">
          <div class="col-md-6">
            <div class="detail-row pe-4">
              <div class="detail-label">Nama Lengkap</div>
              <div class="detail-value">{{ $user->name }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="detail-row ps-md-4">
              <div class="detail-label">Email</div>
              <div class="detail-value">{{ $user->email }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="detail-row pe-4">
              <div class="detail-label">Nomor Telepon</div>
              <div class="detail-value">{{ $user->phone ?? '-' }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="detail-row ps-md-4">
              <div class="detail-label">Role</div>
              <div class="detail-value">{{ ucfirst($user->role) }}</div>
            </div>
          </div>
          @if($user->role === 'relawan')
          <div class="col-md-6">
            <div class="detail-row pe-4">
              <div class="detail-label">NIK</div>
              <div class="detail-value">{{ $user->nik ?? '-' }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="detail-row ps-md-4">
              <div class="detail-label">Jenis Kelamin</div>
              <div class="detail-value">
                {{ $user->jenis_kelamin === 'L' ? 'Laki-laki' : ($user->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="detail-row pe-4">
              <div class="detail-label">Tanggal Lahir</div>
              <div class="detail-value">{{ $user->tanggal_lahir?->format('d M Y') ?? '-' }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="detail-row ps-md-4">
              <div class="detail-label">Alamat</div>
              <div class="detail-value">{{ $user->alamat ?? '-' }}</div>
            </div>
          </div>
          <div class="col-12">
            <div class="detail-row">
              <div class="detail-label">Keahlian</div>
              <div class="detail-value">
                @php $keahlian = is_array($user->keahlian) ? $user->keahlian : []; @endphp
                @if(!empty($keahlian))
                  <div class="d-flex flex-wrap gap-2 mt-1">
                    @foreach($keahlian as $k)
                      <span class="badge rounded-pill px-3 py-2" style="background:#eff6ff; color:#1d4ed8; font-size:0.78rem;">{{ $k }}</span>
                    @endforeach
                  </div>
                @else
                  -
                @endif
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="detail-row">
              <div class="detail-label">Pengalaman</div>
              <div class="detail-value" style="white-space:pre-line;">{{ $user->pengalaman ?? '-' }}</div>
            </div>
          </div>
          @endif
          <div class="col-md-6">
            <div class="detail-row pe-4">
              <div class="detail-label">Tanggal Daftar</div>
              <div class="detail-value">{{ $user->created_at->format('d M Y, H:i') }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="detail-row ps-md-4">
              <div class="detail-label">Login Terakhir</div>
              <div class="detail-value">{{ $user->updated_at->format('d M Y, H:i') }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Kolom Kanan --}}
  <div class="col-lg-4">
    {{-- Status Akun --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius:1rem;">
      <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
        <h6 class="fw-semibold"><i class="fa-solid fa-shield-halved me-2 text-success"></i>Status Akun</h6>
      </div>
      <div class="card-body px-4 pb-4">
        <div class="mt-2 d-flex gap-2 flex-wrap">
        <span class="badge rounded-pill px-3 py-2" style="{{ $roleStyle }} font-size:0.78rem;">
            {{ ucfirst($user->role) }}
        </span>
        @if($user->role === 'relawan')
            @if($user->email_verified_at)
            <span class="badge rounded-pill px-3 py-2" style="background:#dcfce7; color:#166534; font-size:0.78rem;">
                <i class="fa-solid fa-circle-check me-1"></i>Terverifikasi
            </span>
            @else
            <span class="badge rounded-pill px-3 py-2" style="background:#fee2e2; color:#991b1b; font-size:0.78rem;">
                <i class="fa-solid fa-circle-xmark me-1"></i>Belum Diverifikasi
            </span>
            @endif
        @endif
        </div>
        <div class="detail-row">
          <div class="detail-label">Google Login</div>
          <div class="detail-value mt-1">
            @if($user->google_id)
              <span class="badge rounded-pill px-3 py-2" style="background:#dcfce7; color:#166534;">
                <i class="fa-brands fa-google me-1"></i>Terhubung
              </span>
            @else
              <span class="badge rounded-pill px-3 py-2" style="background:#f1f5f9; color:#64748b;">
                Tidak
              </span>
            @endif
          </div>
        </div>
        <div class="detail-row">
          <div class="detail-label">Terdaftar Sejak</div>
          <div class="detail-value">{{ $user->created_at->format('d M Y') }}</div>
        </div>
      </div>
    </div>

    {{-- Foto KTP (hanya relawan) --}}
    @if($user->role === 'relawan')
    <div class="card border-0 shadow-sm" style="border-radius:1rem;">
      <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
        <h6 class="fw-semibold"><i class="fa-solid fa-id-card me-2 text-warning"></i>Foto KTP</h6>
      </div>
      <div class="card-body px-4 pb-4">
        <div style="border:2px dashed #e2e8f0;border-radius:12px;overflow:hidden;background:#f8fafc;min-height:180px;display:flex;align-items:center;justify-content:center;">
          @if($user->foto_ktp)
            <a href="{{ asset('storage/' . $user->foto_ktp) }}" target="_blank">
              <img src="{{ asset('storage/' . $user->foto_ktp) }}" alt="Foto KTP" style="width:100%;border-radius:10px;object-fit:cover;">
            </a>
          @else
            <div class="text-center text-muted py-4">
              <i class="fa-solid fa-image fa-2x mb-2 d-block opacity-30"></i>
              <span class="small">Foto KTP belum diunggah</span>
            </div>
          @endif
        </div>
        @if($user->foto_ktp)
        <a href="{{ asset('storage/' . $user->foto_ktp) }}" target="_blank"
          class="btn w-100 mt-3 btn-sm"
          style="border-radius:8px; border:1.5px solid #e2e8f0; color:#64748b; background:#fff;">
          <i class="fa-solid fa-arrow-up-right-from-square me-2"></i>Lihat Ukuran Penuh
        </a>
        @endif
      </div>
    </div>
    @endif
  </div>
</div>
@endsection
