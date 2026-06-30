@extends('relawan.layouts.app')

@section('title', 'Edit Laporan — ' . $coordinatorReport->title)
@section('page_title', 'Edit Laporan')

{{--
  CATATAN UNTUK PAN:
  - Route hapus foto: route('relawan.coordinator-reports.photos.destroy', $photo->id)
  - Route hapus dokumen: route('relawan.coordinator-reports.documents.destroy', $doc->id)
  Sesuaikan nama route di atas kalau penamaan di routes/web.php kamu beda.
--}}

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

  .status-pill {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 5px 14px;
    border-radius: 99px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .status-pending  { background:#fef9c3; color:#854d0e; }
  .status-rejected { background:#fee2e2; color:#991b1b; }

  .rejection-note {
    background: #fef2f2;
    border-left: 4px solid #dc2626;
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 1.25rem;
  }

  .section-card {
    border-radius: 16px;
    border: none;
    margin-bottom: 1.25rem;
  }
  .section-card .card-header {
    background: #fff;
    border-bottom: 1px solid #f1f5f9;
    border-radius: 16px 16px 0 0 !important;
    padding: 16px 20px;
    font-weight: 700;
    font-size: 0.92rem;
    color: #0a2540;
  }
  .section-card .card-body { padding: 20px; }

  .sidebar-card {
    border-radius: 16px;
    border: none;
  }
  .sidebar-card .card-header {
    background: #fff;
    border-bottom: 1px solid #f1f5f9;
    border-radius: 16px 16px 0 0 !important;
    padding: 16px 20px;
    font-weight: 700;
    font-size: 0.92rem;
    color: #0a2540;
  }

  .form-label-sm {
    font-size: 0.82rem;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
  }
  .form-control, .form-select {
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    font-size: 0.88rem;
    padding: 10px 14px;
  }
  .form-control:focus, .form-select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
  }

  .dynamic-row {
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 14px;
    position: relative;
    background: #f8fafc;
  }
  .dynamic-row .row-number {
    font-size: 0.75rem;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: .04em;
    margin-bottom: 10px;
  }
  .btn-remove-row {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 28px; height: 28px;
    border-radius: 50%;
    border: none;
    background: #fee2e2;
    color: #dc2626;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.8rem;
    transition: all .2s;
  }
  .btn-remove-row:hover { background: #dc2626; color: #fff; }

  .btn-add-row {
    background: #eff6ff; color: #2563eb; border: 1.5px dashed #bfdbfe;
    border-radius: 10px; font-size: 0.85rem; font-weight: 600; padding: 10px 16px;
    width: 100%; transition: all .2s;
  }
  .btn-add-row:hover { background: #2563eb; color: #fff; border-style: solid; border-color: #2563eb; }

  .existing-photo-thumb {
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 16px;
    position: relative;
  }
  .existing-photo-thumb img {
    width: 100%;
    height: 140px;
    object-fit: cover;
  }
  .existing-photo-thumb .caption-box {
    background: #0f172a;
    color: #fff;
    font-size: 0.72rem;
    padding: 8px 10px;
  }
  .existing-photo-thumb form {
    position: absolute;
    top: 8px; right: 8px;
  }
  .btn-delete-existing {
    width: 28px; height: 28px;
    border-radius: 50%;
    border: none;
    background: rgba(220,38,38,0.9);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.75rem;
  }
  .btn-delete-existing:hover { background: #991b1b; }

  .doc-item {
    display: flex;
    align-items: center;
    gap: 12px;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px 16px;
    margin-bottom: 10px;
  }
  .doc-icon {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: #fef2f2;
    color: #dc2626;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .btn-delete-doc {
    background: #fee2e2; color: #dc2626; border: 1.5px solid #fecaca;
    border-radius: 8px; font-size: 0.78rem; padding: 5px 12px;
    margin-left: auto; transition: all .2s;
    white-space: nowrap;
  }
  .btn-delete-doc:hover { background: #dc2626; color: #fff; border-color: #dc2626; }

  .submit-card {
    border-radius: 16px;
    border: none;
    padding: 20px;
  }
  .btn-submit-report {
    background: #0a2540; color: #fff; border: none;
    border-radius: 10px; font-weight: 700; font-size: 0.92rem;
    padding: 12px; width: 100%; transition: all .2s;
  }
  .btn-submit-report:hover { background: #15396b; }
  .btn-cancel-edit {
    display: block; text-align: center;
    color: #475569; font-size: 0.88rem; font-weight: 700;
    text-decoration: none; padding: 11px; margin-top: 10px;
    border: 1.5px solid #e2e8f0; border-radius: 10px;
    background: #fff;
    transition: all .2s ease;
  }
  .btn-cancel-edit:hover {
    color: #fff;
    background: #dc2626;
    border-color: #dc2626;
    transform: translateY(-1px);
  }

  .info-note {
    background: #eff6ff;
    border-left: 4px solid #2563eb;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 0.82rem;
    color: #1e3a8a;
    margin-bottom: 16px;
  }
</style>
@endpush

@section('content')

@php
  $existingItems     = old('items', $coordinatorReport->items->map(fn($i) => [
                          'category'    => $i->category,
                          'description' => $i->description,
                          'amount'      => $i->amount,
                       ])->toArray());
  $existingTimelines = old('timelines', $coordinatorReport->timelines->sortBy('date')->map(fn($t) => [
                          'date'        => optional($t->date)->format('Y-m-d') ?? $t->date,
                          'title'       => $t->title,
                          'description' => $t->description,
                       ])->values()->toArray());
@endphp

<div class="mb-3 d-flex justify-content-between align-items-start flex-wrap gap-2">
  <a href="{{ route('relawan.coordinator-reports.show', $coordinatorReport->id) }}" class="back-link">
    <i class="fa-solid fa-arrow-left"></i> Kembali ke Detail Laporan
  </a>
  @if($coordinatorReport->status === 'pending')
    <span class="status-pill status-pending"><i class="fa-solid fa-hourglass-half"></i> Menunggu Verifikasi</span>
  @elseif($coordinatorReport->status === 'rejected')
    <span class="status-pill status-rejected"><i class="fa-solid fa-circle-xmark"></i> Ditolak</span>
  @endif
</div>

@if($coordinatorReport->status === 'rejected' && $coordinatorReport->rejection_note)
  <div class="rejection-note">
    <div class="fw-bold mb-1" style="color:#991b1b;font-size:0.88rem;">
      <i class="fa-solid fa-circle-exclamation me-1"></i>Catatan Penolakan Admin
    </div>
    <div class="small" style="color:#991b1b;">{{ $coordinatorReport->rejection_note }}</div>
  </div>
@endif

@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0 small">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('relawan.coordinator-reports.update', $coordinatorReport->id) }}" enctype="multipart/form-data" id="reportForm">
@csrf
@method('PUT')

<div class="row g-4">
  {{-- ── MAIN COLUMN ── --}}
  <div class="col-lg-8">

    {{-- Informasi Dasar --}}
    <div class="card section-card shadow-sm">
      <div class="card-header"><i class="fa-solid fa-circle-info me-2 text-primary"></i>Informasi Laporan</div>
      <div class="card-body">

        <div class="mb-3">
          <div class="form-label-sm">Kampanye Bencana</div>
          <select name="campaign_id" class="form-select @error('campaign_id') is-invalid @enderror" required>
            <option value="">-- Pilih Kampanye --</option>
            @foreach($campaigns as $campaign)
              <option value="{{ $campaign->id }}" {{ old('campaign_id', $coordinatorReport->campaign_id) == $campaign->id ? 'selected' : '' }}>
                {{ $campaign->title }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <div class="form-label-sm">Judul Laporan</div>
          <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                 value="{{ old('title', $coordinatorReport->title) }}" required maxlength="255">
        </div>

        <div class="mb-3">
          <div class="form-label-sm">Deskripsi Penyaluran Bantuan</div>
          <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $coordinatorReport->description) }}</textarea>
        </div>

        <div class="row g-3">
          <div class="col-md-4">
            <div class="form-label-sm">Tanggal Laporan</div>
            <input type="date" name="reported_at" class="form-control @error('reported_at') is-invalid @enderror"
                   value="{{ old('reported_at', optional($coordinatorReport->reported_at)->format('Y-m-d') ?? $coordinatorReport->reported_at) }}" required>
          </div>
          <div class="col-md-4">
            <div class="form-label-sm">Korban Terbantu (Jiwa)</div>
            <input type="number" min="0" name="victim_helped" class="form-control @error('victim_helped') is-invalid @enderror"
                   value="{{ old('victim_helped', $coordinatorReport->victim_helped) }}" required>
          </div>
          <div class="col-md-4">
            <div class="form-label-sm">Total Dana Disalurkan (Rp)</div>
            <input type="number" min="0" step="0.01" name="total_distribution" class="form-control @error('total_distribution') is-invalid @enderror"
                   value="{{ old('total_distribution', $coordinatorReport->total_distribution) }}" required>
          </div>
        </div>

      </div>
    </div>

    {{-- Foto Dokumentasi --}}
    <div class="card section-card shadow-sm">
      <div class="card-header"><i class="fa-solid fa-images me-2 text-primary"></i>Dokumentasi Foto</div>
      <div class="card-body">

        @if($coordinatorReport->photos->isNotEmpty())
          <div class="form-label-sm">Foto Tersimpan</div>
          <div class="row g-3 mb-3">
            @foreach($coordinatorReport->photos as $photo)
              <div class="col-md-4">
                <div class="existing-photo-thumb">
                  <form action="{{ route('relawan.coordinator-reports.photos.destroy', $photo->id) }}" method="POST"
                        onsubmit="return confirm('Hapus foto ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete-existing"><i class="fa-solid fa-xmark"></i></button>
                  </form>
                  <img src="{{ Storage::url($photo->photo) }}" alt="Foto">
                  <div class="caption-box">{{ $photo->caption ?: 'Tanpa keterangan' }}</div>
                </div>
              </div>
            @endforeach
          </div>
          <hr class="my-3">
        @endif

        <div class="form-label-sm">Tambah Foto Baru</div>
        <div id="photo-rows"></div>
        <button type="button" class="btn-add-row" id="add-photo-row">
          <i class="fa-solid fa-plus me-1"></i>Tambah Foto
        </button>

      </div>
    </div>

    {{-- Rincian Alokasi Belanja --}}
    <div class="card section-card shadow-sm">
      <div class="card-header"><i class="fa-solid fa-chart-pie me-2 text-warning"></i>Rincian Alokasi Belanja</div>
      <div class="card-body">
        <p class="text-muted small mb-3">Rincian dana yang digunakan untuk operasional lapangan. Baris yang dihapus tidak akan disimpan.</p>

        <div id="item-rows">
          @foreach($existingItems as $i => $item)
            <div class="dynamic-row item-row">
              <button type="button" class="btn-remove-row remove-row"><i class="fa-solid fa-xmark"></i></button>
              <div class="row-number">Item #{{ $i + 1 }}</div>
              <div class="row g-2">
                <div class="col-md-4">
                  <div class="form-label-sm">Kategori</div>
                  <input type="text" name="items[{{ $i }}][category]" class="form-control" value="{{ $item['category'] }}" placeholder="cth: Makanan siap saji" required>
                </div>
                <div class="col-md-4">
                  <div class="form-label-sm">Deskripsi</div>
                  <input type="text" name="items[{{ $i }}][description]" class="form-control" value="{{ $item['description'] }}" placeholder="Opsional">
                </div>
                <div class="col-md-4">
                  <div class="form-label-sm">Jumlah (Rp)</div>
                  <input type="number" min="0" step="0.01" name="items[{{ $i }}][amount]" class="form-control" value="{{ $item['amount'] }}" required>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <button type="button" class="btn-add-row" id="add-item-row">
          <i class="fa-solid fa-plus me-1"></i>Tambah Item Alokasi
        </button>

      </div>
    </div>

    {{-- Timeline Kegiatan --}}
    <div class="card section-card shadow-sm">
      <div class="card-header"><i class="fa-solid fa-timeline me-2 text-info"></i>Timeline Kegiatan</div>
      <div class="card-body">
        <p class="text-muted small mb-3">Urutan kegiatan di lapangan. Baris yang dihapus tidak akan disimpan.</p>

        <div id="timeline-rows">
          @foreach($existingTimelines as $i => $tl)
            <div class="dynamic-row timeline-row">
              <button type="button" class="btn-remove-row remove-row"><i class="fa-solid fa-xmark"></i></button>
              <div class="row-number">Kegiatan #{{ $i + 1 }}</div>
              <div class="row g-2">
                <div class="col-md-4">
                  <div class="form-label-sm">Tanggal</div>
                  <input type="date" name="timelines[{{ $i }}][date]" class="form-control" value="{{ $tl['date'] }}" required>
                </div>
                <div class="col-md-3">
                  <div class="form-label-sm">Judul Kegiatan</div>
                  <input type="text" name="timelines[{{ $i }}][title]" class="form-control" value="{{ $tl['title'] }}" required>
                </div>
                <div class="col-md-5">
                  <div class="form-label-sm">Deskripsi</div>
                  <input type="text" name="timelines[{{ $i }}][description]" class="form-control" value="{{ $tl['description'] }}" placeholder="Opsional">
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <button type="button" class="btn-add-row" id="add-timeline-row">
          <i class="fa-solid fa-plus me-1"></i>Tambah Kegiatan
        </button>

      </div>
    </div>

    {{-- Dokumen Pendukung --}}
    <div class="card section-card shadow-sm">
      <div class="card-header"><i class="fa-solid fa-paperclip me-2 text-secondary"></i>Kuitansi &amp; Dokumen Pendukung</div>
      <div class="card-body">

        @if($coordinatorReport->documents->isNotEmpty())
          <div class="form-label-sm">Dokumen Tersimpan</div>
          @foreach($coordinatorReport->documents as $doc)
            <div class="doc-item">
              <div class="doc-icon"><i class="fa-solid fa-file"></i></div>
              <div class="flex-grow-1 min-w-0">
                <div class="fw-semibold" style="font-size:0.83rem;">{{ $doc->name }}</div>
                @if($doc->code)
                  <div class="small text-muted">Kode: {{ $doc->code }}</div>
                @endif
              </div>
              <form action="{{ route('relawan.coordinator-reports.documents.destroy', $doc->id) }}" method="POST"
                    onsubmit="return confirm('Hapus dokumen ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete-doc"><i class="fa-solid fa-trash me-1"></i>Hapus</button>
              </form>
            </div>
          @endforeach
          <hr class="my-3">
        @endif

        <div class="form-label-sm">Tambah Dokumen Baru</div>
        <div id="document-rows"></div>
        <button type="button" class="btn-add-row" id="add-document-row">
          <i class="fa-solid fa-plus me-1"></i>Tambah Dokumen
        </button>

      </div>
    </div>

  </div>

  {{-- ── SIDEBAR ── --}}
  <div class="col-lg-4">
    <div class="card sidebar-card shadow-sm mb-4">
      <div class="card-header"><i class="fa-solid fa-paper-plane me-2 text-primary"></i>Kirim Perubahan</div>
      <div class="submit-card">
        <div class="info-note">
          <i class="fa-solid fa-circle-info me-1"></i>
          Menyimpan perubahan akan mengembalikan status laporan menjadi <strong>Menunggu Verifikasi</strong>.
        </div>
        <button type="submit" class="btn-submit-report">
          <i class="fa-solid fa-paper-plane me-2"></i>Simpan &amp; Kirim Ulang
        </button>
        <a href="{{ route('relawan.coordinator-reports.show', $coordinatorReport->id) }}" class="btn-cancel-edit">Batal</a>
      </div>
    </div>
  </div>
</div>

</form>

{{-- ── TEMPLATES UNTUK BARIS DINAMIS (disembunyikan) ── --}}
<template id="tpl-photo-row">
  <div class="dynamic-row photo-row">
    <button type="button" class="btn-remove-row remove-row"><i class="fa-solid fa-xmark"></i></button>
    <div class="row g-2">
      <div class="col-md-7">
        <div class="form-label-sm">File Foto</div>
        <input type="file" name="photos[]" class="form-control" accept="image/png,image/jpeg,image/jpg,image/webp">
      </div>
      <div class="col-md-5">
        <div class="form-label-sm">Keterangan</div>
        <input type="text" name="photo_captions[]" class="form-control" placeholder="Opsional">
      </div>
    </div>
  </div>
</template>

<template id="tpl-item-row">
  <div class="dynamic-row item-row">
    <button type="button" class="btn-remove-row remove-row"><i class="fa-solid fa-xmark"></i></button>
    <div class="row-number">Item Baru</div>
    <div class="row g-2">
      <div class="col-md-4">
        <div class="form-label-sm">Kategori</div>
        <input type="text" name="items[__INDEX__][category]" class="form-control" placeholder="cth: Makanan siap saji" required>
      </div>
      <div class="col-md-4">
        <div class="form-label-sm">Deskripsi</div>
        <input type="text" name="items[__INDEX__][description]" class="form-control" placeholder="Opsional">
      </div>
      <div class="col-md-4">
        <div class="form-label-sm">Jumlah (Rp)</div>
        <input type="number" min="0" step="0.01" name="items[__INDEX__][amount]" class="form-control" required>
      </div>
    </div>
  </div>
</template>

<template id="tpl-timeline-row">
  <div class="dynamic-row timeline-row">
    <button type="button" class="btn-remove-row remove-row"><i class="fa-solid fa-xmark"></i></button>
    <div class="row-number">Kegiatan Baru</div>
    <div class="row g-2">
      <div class="col-md-4">
        <div class="form-label-sm">Tanggal</div>
        <input type="date" name="timelines[__INDEX__][date]" class="form-control" required>
      </div>
      <div class="col-md-3">
        <div class="form-label-sm">Judul Kegiatan</div>
        <input type="text" name="timelines[__INDEX__][title]" class="form-control" required>
      </div>
      <div class="col-md-5">
        <div class="form-label-sm">Deskripsi</div>
        <input type="text" name="timelines[__INDEX__][description]" class="form-control" placeholder="Opsional">
      </div>
    </div>
  </div>
</template>

<template id="tpl-document-row">
  <div class="dynamic-row document-row">
    <button type="button" class="btn-remove-row remove-row"><i class="fa-solid fa-xmark"></i></button>
    <div class="row g-2">
      <div class="col-md-5">
        <div class="form-label-sm">File Dokumen</div>
        <input type="file" name="documents[]" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip">
      </div>
      <div class="col-md-4">
        <div class="form-label-sm">Nama Dokumen</div>
        <input type="text" name="document_names[]" class="form-control" placeholder="Opsional">
      </div>
      <div class="col-md-3">
        <div class="form-label-sm">Kode</div>
        <input type="text" name="document_codes[]" class="form-control" placeholder="Opsional">
      </div>
    </div>
  </div>
</template>

@endsection

@push('scripts')
<script>
  (function () {
    let itemIndex     = {{ count($existingItems) }};
    let timelineIndex = {{ count($existingTimelines) }};

    function addRow(templateId, containerId, indexPlaceholder, getIndex) {
      const tpl = document.getElementById(templateId);
      const container = document.getElementById(containerId);
      let html = tpl.innerHTML;
      if (indexPlaceholder) {
        html = html.replaceAll(indexPlaceholder, getIndex());
      }
      const wrapper = document.createElement('div');
      wrapper.innerHTML = html.trim();
      container.appendChild(wrapper.firstElementChild);
    }

    document.getElementById('add-photo-row').addEventListener('click', function () {
      addRow('tpl-photo-row', 'photo-rows', null, null);
    });

    document.getElementById('add-item-row').addEventListener('click', function () {
      addRow('tpl-item-row', 'item-rows', '__INDEX__', () => itemIndex++);
    });

    document.getElementById('add-timeline-row').addEventListener('click', function () {
      addRow('tpl-timeline-row', 'timeline-rows', '__INDEX__', () => timelineIndex++);
    });

    document.getElementById('add-document-row').addEventListener('click', function () {
      addRow('tpl-document-row', 'document-rows', null, null);
    });

    document.addEventListener('click', function (e) {
      if (e.target.closest('.remove-row')) {
        const row = e.target.closest('.dynamic-row');
        if (row) row.remove();
      }
    });
  })();
</script>
@endpush