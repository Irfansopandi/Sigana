@extends('admin.layouts.app')

@section('title', 'Seleksi Koordinator')
@section('page_title', 'Seleksi Koordinator')

@push('styles')
<style>
  .candidate-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.25rem;
    transition: box-shadow .2s, border-color .2s;
  }
  .candidate-card:hover {
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
    border-color: #cbd5e1;
  }

  .candidate-avatar {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    background: #eff6ff;
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.1rem;
    flex-shrink: 0;
    overflow: hidden;
  }

  .badge-menunggu { background:#fffbeb; color:#d97706; border: 1px solid #fde68a; }
  .badge-diterima { background:#ecfdf5; color:#059669; border: 1px solid #a7f3d0; }
  .badge-ditolak  { background:#fef2f2; color:#dc2626; border: 1px solid #fecaca; }

  .doc-btn {
    font-size: .75rem;
    background: #fff;
    border: 1px solid #cbd5e1;
    color: #475569;
    padding: 6px 12px;
    border-radius: 8px;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .doc-btn:hover {
    background: #f8fafc;
    border-color: #94a3b8;
    color: #1e293b;
  }
</style>
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
  <div>
    <h4 class="fw-bold mb-1 text-dark">
      <i class="fa-solid fa-user-shield text-warning me-2"></i>Seleksi Koordinator Bencana
    </h4>
    <p class="text-muted small mb-0">Seleksi relawan yang mengajukan minat menjadi koordinator lapangan di lokasi bencana.</p>
  </div>
  <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-3 btn-sm">
    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard
  </a>
</div>

@if(session('success'))
<div class="alert alert-success rounded-3 mb-4 shadow-sm border-0 d-flex align-items-center gap-2">
  <i class="fa-solid fa-circle-check text-success"></i>
  <div>{{ session('success') }}</div>
</div>
@endif

<div class="card border-0 shadow-sm rounded-4">
  <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h6 class="fw-bold text-dark mb-0">Daftar Pengaju Koordinator</h6>
    <div class="d-flex align-items-center gap-2">
      <span class="small text-muted">Tampil</span>
      <select class="form-select form-select-sm" style="width:80px;"
              onchange="window.location.href='{{ route('admin.coordinator-selections.index') }}?tab={{ $filterTab }}&per_page='+this.value">
        @foreach([5, 10, 25, 50] as $size)
          <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
            {{ $size }}
          </option>
        @endforeach
      </select>
      <span class="small text-muted">baris</span>
    </div>
  </div>

  <div class="card-body pt-0">
    @php
      $tabs = [
          'semua' => 'Semua',
          'menunggu' => 'Menunggu Verifikasi',
          'diterima' => 'Diterima Koordinator',
          'ditolak' => 'Ditolak',
      ];
    @endphp

    <div class="d-flex gap-2 mb-4 flex-wrap">
      @foreach($tabs as $val => $label)
        <a href="{{ route('admin.coordinator-selections.index', ['tab' => $val]) }}"
           class="btn btn-sm"
           style="border-radius:10px; font-size:0.8rem; padding:6px 14px; transition:all .2s;
             {{ $filterTab === $val
               ? 'background:#fffbeb; color:#d97706; border:1.5px solid #fcd34d; font-weight:600;'
               : 'background:#fff; color:#64748b; border:1.5px solid #e2e8f0;' }}">
          {{ $label }}
          <span class="ms-1 badge rounded-pill"
            style="font-size:.65rem; {{ $filterTab === $val ? 'background:#d97706; color:#fff;' : 'background:#f1f5f9; color:#64748b;' }}">
            @if($val === 'semua')
              {{ \App\Models\CampaignVolunteer::where('minat_koordinator', true)->count() }}
            @elseif($val === 'menunggu')
              {{ $totalMenunggu }}
            @elseif($val === 'diterima')
              {{ $totalDiterima }}
            @elseif($val === 'ditolak')
              {{ $totalDitolak }}
            @endif
          </span>
        </a>
      @endforeach
    </div>

    @forelse($candidates as $cand)
      <div class="candidate-card">
        <div class="d-flex align-items-start gap-3 flex-wrap flex-sm-nowrap">
          <div class="candidate-avatar">
            @if($cand->user->photo)
              <img src="{{ Storage::url($cand->user->photo) }}" style="width:100%;height:100%;object-fit:cover;">
            @else
              {{ strtoupper(substr($cand->user->name, 0, 1)) }}
            @endif
          </div>
          <div class="flex-grow-1">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
              <div>
                <h6 class="fw-bold text-dark mb-1" style="font-size: .95rem;">
                  {{ $cand->user->name }}
                  <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle ms-1" style="font-size:.68rem;">
                    <i class="fa-solid fa-crown me-1"></i>Calon Koordinator
                  </span>
                </h6>
                <div class="text-muted small mb-1">
                  <i class="fa-regular fa-envelope me-1"></i>{{ $cand->user->email }}
                </div>
                <div class="fw-semibold text-primary small">
                  <i class="fa-solid fa-house-chimney-crack me-1"></i>Melamar di: <span class="text-dark">{{ $cand->campaign->title ?? 'Bencana Tidak Diketahui' }}</span>
                </div>
              </div>
              <span class="badge rounded-pill px-2.5 py-1.5 badge-{{ $cand->verifikasi }}" style="font-size:.7rem;">
                @if($cand->verifikasi === 'menunggu')
                  ⏳ Menunggu
                @elseif($cand->verifikasi === 'diterima')
                  ✅ Koordinator Aktif
                @else
                  ❌ Ditolak
                @endif
              </span>
            </div>

            <div class="row g-2 mt-2 pt-2 border-top border-light mb-3" style="font-size: .82rem;">
              <div class="col-sm-4">
                <span class="text-muted d-block small" style="font-size: 0.72rem;">No. Telepon</span>
                <span class="text-dark fw-semibold"><i class="fa-solid fa-phone text-muted me-1"></i>{{ $cand->user->phone ?? '-' }}</span>
              </div>
              <div class="col-sm-4">
                <span class="text-muted d-block small" style="font-size: 0.72rem;">Jenis Kelamin</span>
                <span class="text-dark fw-semibold">
                  <i class="fa-solid fa-venus-mars text-muted me-1"></i>
                  @if($cand->user->jenis_kelamin === 'L' || $cand->user->jenis_kelamin === 'laki-laki' || $cand->user->jenis_kelamin === 'Laki-laki')
                    Laki-laki
                  @elseif($cand->user->jenis_kelamin === 'P' || $cand->user->jenis_kelamin === 'perempuan' || $cand->user->jenis_kelamin === 'Perempuan')
                    Perempuan
                  @else
                    -
                  @endif
                </span>
              </div>
              <div class="col-sm-4">
                <span class="text-muted d-block small" style="font-size: 0.72rem;">Tanggal Lahir / Usia</span>
                <span class="text-dark fw-semibold">
                  <i class="fa-solid fa-cake-candles text-muted me-1"></i>
                  @if($cand->user->tanggal_lahir)
                    {{ \Carbon\Carbon::parse($cand->user->tanggal_lahir)->translatedFormat('d M Y') }} ({{ \Carbon\Carbon::parse($cand->user->tanggal_lahir)->age }} tahun)
                  @else
                    -
                  @endif
                </span>
              </div>
            </div>

            @if($cand->alasan)
              <div class="p-2.5 bg-light rounded-3 mb-2" style="font-size:.78rem; color:#334155;">
                <strong>Alasan Gabung & Mengkoordinir:</strong> {{ $cand->alasan }}
              </div>
            @endif

            @if($cand->pengalaman)
              <div class="p-2.5 bg-light rounded-3 mb-3" style="font-size:.78rem; color:#334155;">
                <strong>Pengalaman Lapangan:</strong> {{ $cand->pengalaman }}
              </div>
            @endif

            @if($cand->catatan_admin)
              <div class="p-2.5 rounded-3 mb-3" style="font-size:.78rem; background:#fff7ed; color:#92400e;">
                <strong>Catatan Penolakan:</strong> {{ $cand->catatan_admin }}
              </div>
            @endif

            {{-- Dokumen Sertifikat / Bukti --}}
            @if($cand->dokumen_1 || $cand->dokumen_2 || $cand->dokumen_3)
              <div class="p-3 border rounded-3 bg-light bg-opacity-50 mb-3">
                <div class="fw-bold text-dark mb-2" style="font-size: 0.78rem;">
                  <i class="fa-solid fa-file-pdf text-danger me-1"></i>Berkas & Dokumen Kualifikasi:
                </div>
                <div class="d-flex gap-2 flex-wrap">
                  @if($cand->dokumen_1)
                    <a href="{{ Storage::url($cand->dokumen_1) }}" target="_blank" class="doc-btn">
                      <i class="fa-solid fa-download text-primary"></i> Dokumen 1
                    </a>
                  @endif
                  @if($cand->dokumen_2)
                    <a href="{{ Storage::url($cand->dokumen_2) }}" target="_blank" class="doc-btn">
                      <i class="fa-solid fa-download text-primary"></i> Dokumen 2
                    </a>
                  @endif
                  @if($cand->dokumen_3)
                    <a href="{{ Storage::url($cand->dokumen_3) }}" target="_blank" class="doc-btn">
                      <i class="fa-solid fa-download text-primary"></i> Dokumen 3
                    </a>
                  @endif
                </div>
              </div>
            @endif

            <div class="d-flex gap-2 flex-wrap">
              @if($cand->verifikasi === 'menunggu')
                {{-- Form Setujui --}}
                <form action="{{ route('admin.coordinator-selections.verifikasi', $cand) }}" method="POST" class="d-inline terima-koordinator-form">
                  @csrf
                  <input type="hidden" name="verifikasi" value="diterima">
                  <button type="submit" class="btn btn-sm btn-success rounded-3 px-3 py-2" style="font-size:.78rem;">
                    <i class="fa-solid fa-check me-1"></i>Setujui jadi Koordinator
                  </button>
                </form>

                {{-- Tombol Tolak --}}
                <button type="button" class="btn btn-sm btn-danger rounded-3 px-3 py-2" style="font-size:.78rem;"
                        data-bs-toggle="modal" data-bs-target="#tolakKoordinatorModal{{ $cand->id }}">
                  <i class="fa-solid fa-xmark me-1"></i>Tolak Pengajuan
                </button>
              @endif
            </div>

          </div>
        </div>
      </div>

      {{-- Modal Tolak Koordinator --}}
      <div class="modal fade" id="tolakKoordinatorModal{{ $cand->id }}" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content border-0 rounded-4 shadow">
            <form action="{{ route('admin.coordinator-selections.verifikasi', $cand) }}" method="POST">
              @csrf
              <input type="hidden" name="verifikasi" value="ditolak">
              <div class="modal-header border-0">
                <h6 class="modal-title fw-bold text-danger">
                  <i class="fa-solid fa-circle-xmark me-2"></i>Tolak Koordinator: {{ $cand->user->name }}
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="mb-0">
                  <label class="form-label small fw-medium">Alasan Penolakan Koordinator <span class="text-danger">*</span></label>
                  <textarea name="catatan_admin" rows="3" class="form-control" required
                    placeholder="Berikan alasan mengapa pengajuan koordinator ini ditolak..."></textarea>
                </div>
              </div>
              <div class="modal-footer border-0">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger btn-sm rounded-3">Ya, Tolak Pengajuan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    @empty
      <div class="text-center py-5 text-muted">
        <i class="fa-solid fa-user-shield fa-3x mb-3 d-block opacity-25"></i>
        Tidak ada pengaju koordinator pada tab ini.
      </div>
    @endforelse

    <div class="mt-4">
      {{ $candidates->links() }}
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.terima-koordinator-form').forEach(form => {
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Setujui jadi Koordinator?',
      text: 'Relawan akan disetujui bergabung dan ditugaskan sebagai koordinator aktif di lokasi bencana ini.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#22c55e',
      cancelButtonColor: '#64748b',
      confirmButtonText: 'Ya, Setujui',
      cancelButtonText: 'Batal'
    }).then(result => {
      if (result.isConfirmed) form.submit();
    });
  });
});
</script>
@endpush
