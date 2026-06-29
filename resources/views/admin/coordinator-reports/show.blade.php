@extends('admin.layouts.app')

@section('title', 'Detail Laporan Koordinator')
@section('page_title', 'Detail Laporan Koordinator')

@push('styles')
<style>
  .section-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
    margin-bottom: 20px;
    overflow: hidden;
  }
  .section-header {
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
    font-weight: 600;
    font-size: .88rem;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .section-body { padding: 20px; }

  .info-row { display: flex; gap: 8px; margin-bottom: 12px; font-size: .875rem; }
  .info-label { color: #64748b; min-width: 160px; flex-shrink: 0; }
  .info-value { color: #0f172a; font-weight: 500; }

  .photo-thumb {
    width: 100%; aspect-ratio: 4/3;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    transition: opacity .2s;
  }
  .photo-thumb:hover { opacity: .85; }

  .timeline-item {
    position: relative;
    padding-left: 28px;
    padding-bottom: 20px;
  }
  .timeline-item::before {
    content: '';
    position: absolute;
    left: 7px; top: 6px;
    width: 2px;
    height: 100%;
    background: #e2e8f0;
  }
  .timeline-item:last-child::before { display: none; }
  .timeline-dot {
    position: absolute;
    left: 0; top: 4px;
    width: 16px; height: 16px;
    border-radius: 50%;
    background: #3b82f6;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #bfdbfe;
  }
  .timeline-date { font-size: .72rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; }
  .timeline-title { font-size: .875rem; font-weight: 600; color: #0f172a; }
  .timeline-desc { font-size: .8rem; color: #64748b; margin-top: 2px; }

  .item-table th { background: #f8fafc; font-size: .75rem; color: #64748b; text-transform: uppercase; letter-spacing: .04em; }

  .status-banner {
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 20px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
  }
  .status-banner.pending  { background: #fef3c7; border-left: 4px solid #f59e0b; }
  .status-banner.approved { background: #dcfce7; border-left: 4px solid #22c55e; }
  .status-banner.rejected { background: #fee2e2; border-left: 4px solid #ef4444; }
</style>
@endpush

@section('content')

{{-- BACK BUTTON --}}
<div class="mb-3">
  <a href="{{ route('admin.coordinator-reports.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px">
    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
  </a>
</div>

{{-- STATUS BANNER --}}
@if($coordinatorReport->status === 'pending')
  <div class="status-banner pending">
    <i class="fa-solid fa-clock mt-1" style="color:#f59e0b"></i>
    <div>
      <div class="fw-semibold small" style="color:#92400e">Menunggu Verifikasi</div>
      <div class="small" style="color:#a16207">Laporan ini belum diproses. Silakan review dan lakukan tindakan di bawah.</div>
    </div>
  </div>
@elseif($coordinatorReport->status === 'approved')
  <div class="status-banner approved">
    <i class="fa-solid fa-circle-check mt-1" style="color:#22c55e"></i>
    <div>
      <div class="fw-semibold small" style="color:#166534">Laporan Disetujui</div>
      <div class="small" style="color:#15803d">
        Diverifikasi oleh <strong>{{ $coordinatorReport->verifiedBy->name ?? '-' }}</strong>
        pada {{ $coordinatorReport->verified_at?->format('d M Y, H:i') }}
      </div>
    </div>
  </div>
@elseif($coordinatorReport->status === 'rejected')
  <div class="status-banner rejected">
    <i class="fa-solid fa-circle-xmark mt-1" style="color:#ef4444"></i>
    <div>
      <div class="fw-semibold small" style="color:#991b1b">Laporan Ditolak</div>
      <div class="small" style="color:#b91c1c">
        <strong>Catatan:</strong> {{ $coordinatorReport->rejection_note }}
      </div>
      <div class="small mt-1" style="color:#b91c1c">
        Oleh <strong>{{ $coordinatorReport->verifiedBy->name ?? '-' }}</strong>
        pada {{ $coordinatorReport->verified_at?->format('d M Y, H:i') }}
      </div>
    </div>
  </div>
@endif

<div class="row g-3">
  {{-- KOLOM KIRI --}}
  <div class="col-lg-8">

    {{-- INFO UTAMA --}}
    <div class="section-card">
      <div class="section-header">
        <i class="fa-solid fa-file-lines text-primary"></i>
        Informasi Laporan
      </div>
      <div class="section-body">
        <div class="info-row">
          <span class="info-label">Judul Laporan</span>
          <span class="info-value">{{ $coordinatorReport->title }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Kampanye</span>
          <span class="info-value">{{ $coordinatorReport->campaign->title ?? '-' }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Koordinator</span>
          <span class="info-value">{{ $coordinatorReport->user->name ?? '-' }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Tanggal Laporan</span>
          <span class="info-value">{{ $coordinatorReport->reported_at->translatedFormat('d F Y') }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Korban Terbantu</span>
          <span class="info-value">{{ number_format($coordinatorReport->victim_helped) }} orang</span>
        </div>
        <div class="info-row">
          <span class="info-label">Total Dana Disalurkan</span>
          <span class="info-value fw-bold text-success">Rp {{ number_format($coordinatorReport->total_distribution, 0, ',', '.') }}</span>
        </div>
        <hr class="my-3">
        <div class="small text-muted mb-1 fw-semibold">Deskripsi Laporan</div>
        <p class="small mb-0" style="line-height:1.7; color:#334155">{{ $coordinatorReport->description }}</p>
      </div>
    </div>

    {{-- FOTO --}}
    @if($coordinatorReport->photos->count())
    <div class="section-card">
      <div class="section-header">
        <i class="fa-solid fa-images text-warning"></i>
        Foto Dokumentasi ({{ $coordinatorReport->photos->count() }})
      </div>
      <div class="section-body">
        <div class="row g-3">
          @foreach($coordinatorReport->photos as $photo)
          <div class="col-6 col-md-4">
            <a href="{{ Storage::url($photo->photo) }}" target="_blank">
              <img src="{{ Storage::url($photo->photo) }}" alt="{{ $photo->caption }}" class="photo-thumb">
            </a>
            @if($photo->caption)
              <div class="text-muted mt-1" style="font-size:.72rem">{{ $photo->caption }}</div>
            @endif
          </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif

    {{-- RINCIAN BELANJA --}}
    @if($coordinatorReport->items->count())
    <div class="section-card">
      <div class="section-header">
        <i class="fa-solid fa-receipt text-success"></i>
        Rincian Penggunaan Dana
      </div>
      <div class="section-body p-0">
        <table class="table item-table mb-0">
          <thead>
            <tr>
              <th class="px-4 py-3">#</th>
              <th class="py-3">Kategori</th>
              <th class="py-3">Keterangan</th>
              <th class="py-3 text-end pe-4">Jumlah</th>
            </tr>
          </thead>
          <tbody>
            @php $total = 0; @endphp
            @foreach($coordinatorReport->items as $i => $item)
            <tr>
              <td class="px-4 small text-muted">{{ $i + 1 }}</td>
              <td class="small fw-semibold">{{ $item->category }}</td>
              <td class="small text-muted">{{ $item->description ?? '-' }}</td>
              <td class="small text-end pe-4 fw-semibold">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
            </tr>
            @php $total += $item->amount; @endphp
            @endforeach
          </tbody>
          <tfoot>
            <tr style="background:#f8fafc">
              <td colspan="3" class="px-4 py-3 fw-bold small text-end">Total</td>
              <td class="pe-4 py-3 fw-bold small text-end text-success">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    @endif

    {{-- TIMELINE --}}
    @if($coordinatorReport->timelines->count())
    <div class="section-card">
      <div class="section-header">
        <i class="fa-solid fa-timeline text-info"></i>
        Timeline Kegiatan
      </div>
      <div class="section-body">
        @foreach($coordinatorReport->timelines as $timeline)
        <div class="timeline-item">
          <div class="timeline-dot"></div>
          <div class="timeline-date">{{ $timeline->date->translatedFormat('d F Y') }}</div>
          <div class="timeline-title">{{ $timeline->title }}</div>
          @if($timeline->description)
            <div class="timeline-desc">{{ $timeline->description }}</div>
          @endif
        </div>
        @endforeach
      </div>
    </div>
    @endif

    {{-- DOKUMEN --}}
    @if($coordinatorReport->documents->count())
    <div class="section-card">
      <div class="section-header">
        <i class="fa-solid fa-paperclip text-secondary"></i>
        Dokumen Pendukung
      </div>
      <div class="section-body">
        <div class="row g-2">
          @foreach($coordinatorReport->documents as $doc)
          <div class="col-12 col-md-6">
            <a href="{{ Storage::url($doc->file) }}" target="_blank"
               class="d-flex align-items-center gap-3 p-3 rounded border text-decoration-none"
               style="background:#f8fafc; transition:background .15s"
               onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
              <i class="fa-solid fa-file-pdf fa-lg text-danger"></i>
              <div>
                <div class="small fw-semibold text-dark">{{ $doc->name }}</div>
                @if($doc->code)
                  <div class="text-muted" style="font-size:.7rem">Kode: {{ $doc->code }}</div>
                @endif
              </div>
              <i class="fa-solid fa-arrow-down-to-line ms-auto text-muted small"></i>
            </a>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif

  </div>

  {{-- KOLOM KANAN — AKSI VERIFIKASI --}}
  <div class="col-lg-4">
    @if($coordinatorReport->status === 'pending')
    <div class="section-card">
      <div class="section-header">
        <i class="fa-solid fa-shield-check text-primary"></i>
        Verifikasi Laporan
      </div>
      <div class="section-body">

        {{-- APPROVE --}}
        <form method="POST" action="{{ route('admin.coordinator-reports.approve', $coordinatorReport) }}" id="form-approve">
          @csrf
          <button type="button" class="btn btn-success w-100 mb-3" onclick="confirmApprove()"
                  style="border-radius:10px; font-weight:600">
            <i class="fa-solid fa-circle-check me-2"></i> Setujui & Publikasikan
          </button>
        </form>

        <hr class="my-3">
        <div class="small fw-semibold text-muted mb-2">Tolak Laporan</div>

        {{-- REJECT --}}
        <form method="POST" action="{{ route('admin.coordinator-reports.reject', $coordinatorReport) }}" id="form-reject">
          @csrf
          <div class="mb-3">
            <textarea name="rejection_note" class="form-control @error('rejection_note') is-invalid @enderror"
                      rows="4" placeholder="Tuliskan alasan penolakan..." style="font-size:.875rem; border-radius:10px">{{ old('rejection_note') }}</textarea>
            @error('rejection_note')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <button type="button" class="btn btn-danger w-100" onclick="confirmReject()"
                  style="border-radius:10px; font-weight:600">
            <i class="fa-solid fa-circle-xmark me-2"></i> Tolak Laporan
          </button>
        </form>

      </div>
    </div>
    @endif

    {{-- INFO SINGKAT --}}
    <div class="section-card">
      <div class="section-header">
        <i class="fa-solid fa-circle-info text-muted"></i>
        Ringkasan
      </div>
      <div class="section-body">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
          <span class="small text-muted">Foto</span>
          <span class="small fw-semibold">{{ $coordinatorReport->photos->count() }} foto</span>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
          <span class="small text-muted">Item Belanja</span>
          <span class="small fw-semibold">{{ $coordinatorReport->items->count() }} item</span>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
          <span class="small text-muted">Timeline</span>
          <span class="small fw-semibold">{{ $coordinatorReport->timelines->count() }} kegiatan</span>
        </div>
        <div class="d-flex justify-content-between align-items-center">
          <span class="small text-muted">Dokumen</span>
          <span class="small fw-semibold">{{ $coordinatorReport->documents->count() }} file</span>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection

@push('scripts')
<script>
function confirmApprove() {
    Swal.fire({
        title: 'Setujui Laporan?',
        html: 'Laporan ini akan dipublikasikan ke halaman <strong>Transparansi</strong> dan dapat dilihat publik.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-circle-check me-1"></i> Ya, Setujui',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#22c55e',
        cancelButtonColor: '#6b7280',
        customClass: { popup: 'rounded-3' }
    }).then(result => {
        if (result.isConfirmed) {
            document.getElementById('form-approve').submit();
        }
    });
}

function confirmReject() {
    const note = document.querySelector('textarea[name="rejection_note"]').value.trim();
    if (!note) {
        Swal.fire({
            icon: 'warning',
            title: 'Catatan kosong',
            text: 'Mohon isi alasan penolakan terlebih dahulu.',
            confirmButtonColor: '#f59e0b',
        });
        return;
    }
    Swal.fire({
        title: 'Tolak Laporan?',
        text: 'Koordinator akan mendapat notifikasi penolakan beserta catatan yang kamu tulis.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-circle-xmark me-1"></i> Ya, Tolak',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        customClass: { popup: 'rounded-3' }
    }).then(result => {
        if (result.isConfirmed) {
            document.getElementById('form-reject').submit();
        }
    });
}
</script>
@endpush