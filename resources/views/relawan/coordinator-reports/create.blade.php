@extends('relawan.layouts.app')

@section('title', 'Buat Laporan Bencana')
@section('page_title', 'Laporan Bencana')

@push('styles')
<style>
  .form-section {
    border-radius: 16px;
    border: none;
    margin-bottom: 1.25rem;
  }
  .form-section .card-header {
    background: #fff;
    border-bottom: 1px solid #f1f5f9;
    border-radius: 16px 16px 0 0 !important;
    padding: 16px 20px;
    font-weight: 700;
    font-size: 0.92rem;
    color: #0a2540;
  }
  .form-section .card-body { padding: 20px; }

  .form-label { font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 6px; }
  .form-control, .form-select {
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    font-size: 0.88rem;
    padding: 9px 12px;
  }
  .form-control:focus, .form-select:focus {
    border-color: #38bdf8;
    box-shadow: 0 0 0 3px rgba(56,189,248,0.15);
  }

  .repeat-row {
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 14px;
    margin-bottom: 10px;
    position: relative;
  }
  .btn-remove-row {
    background: #fee2e2; color: #b91c1c; border: none;
    width: 28px; height: 28px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.8rem; flex-shrink: 0;
  }
  .btn-remove-row:hover { background: #dc2626; color: #fff; }

  .item-icon-preview {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: #eff6ff;
    color: #2563eb;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.9rem;
    flex-shrink: 0;
    margin-top: 1px;
    transition: background .2s, color .2s;
  }

  .btn-add-row {
    background: #eff6ff; color: #2563eb; border: 1.5px dashed #93c5fd;
    border-radius: 10px; font-size: 0.82rem; font-weight: 600;
    padding: 8px 16px; width: 100%;
  }
  .btn-add-row:hover { background: #2563eb; color: #fff; border-color: #2563eb; }

  .upload-box {
    border: 1.5px dashed #cbd5e1;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    color: #94a3b8;
    cursor: pointer;
    transition: all .2s;
  }
  .upload-box:hover { border-color: #38bdf8; background: #f0f9ff; color: #0ea5e9; }

  .preview-thumb {
    width: 100%; height: 90px; object-fit: cover; border-radius: 10px;
  }

  .btn-submit-report {
    background: #0a2540; color: #fff; border: none;
    border-radius: 10px; padding: 11px 28px; font-weight: 600; font-size: 0.9rem;
  }
  .btn-submit-report:hover { background: #173f66; color: #fff; }

  .btn-cancel {
    background: #fff !important;
    color: #475569 !important;
    border: 1.5px solid #cbd5e1 !important;
    border-radius: 10px;
    padding: 11px 22px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all .2s ease;
  }
  .btn-cancel:hover {
    background: #fee2e2 !important;
    color: #b91c1c !important;
    border-color: #fca5a5 !important;
  }

  .btn-back-report {
    background: #fff; color: #64748b; border: 1.5px solid #e2e8f0;
    border-radius: 8px; padding: 8px 16px; font-size: 0.85rem; font-weight: 600;
    transition: all .2s ease;
  }
  .btn-back-report:hover { background: #0a2540; color: #fff; border-color: #0a2540; transform: translateY(-1px); }
</style>
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-start flex-wrap gap-2">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-file-circle-plus text-warning me-2"></i>Buat Laporan Bencana</h5>
    <p class="text-muted small mb-0">Isi laporan transparansi penyaluran bantuan sebagai koordinator.</p>
  </div>
  <a href="{{ route('relawan.coordinator-reports.index') }}" class="btn btn-sm btn-back-report">
    <i class="fa-solid fa-arrow-left me-1"></i>Kembali ke Laporan Bencana
  </a>
</div>

@if($errors->any())
  <div class="alert border-0 mb-4" style="background:#fef2f2;border-left:4px solid #dc2626 !important;border-radius:10px;">
    <div class="fw-bold mb-1" style="color:#991b1b;font-size:0.88rem;">Periksa kembali isian Anda:</div>
    <ul class="mb-0 small" style="color:#991b1b;">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('relawan.coordinator-reports.store') }}" method="POST" enctype="multipart/form-data" id="reportForm">
  @csrf

  {{-- Info Dasar --}}
  <div class="card shadow-sm form-section">
    <div class="card-header"><i class="fa-solid fa-circle-info me-2 text-primary"></i>Informasi Dasar</div>
    <div class="card-body">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Bencana</label>
          <select name="campaign_id" id="campaignSelect" class="form-select" required>
            <option value="">-- Pilih Bencana --</option>
            @foreach($campaigns as $c)
              <option value="{{ $c->id }}" data-collected-raw="{{ $c->collected_raw ?? 0 }}" data-collected="{{ $c->collected }}"
                {{ (string) $selectedCampaignId === (string) $c->id ? 'selected' : '' }}>
                {{ $c->title }}
              </option>
            @endforeach
          </select>
          <div id="collectedInfo" class="small mt-2 p-2 d-none" style="background:#f0fdf4;border-radius:8px;color:#166534;">
            <i class="fa-solid fa-sack-dollar me-1"></i>Dana Terkumpul untuk bencana ini: <span class="fw-bold" id="collectedAmount">Rp0</span>
          </div>
        </div>
        <div class="col-md-6">
          <label class="form-label">Tanggal Laporan</label>
          <input type="date" name="reported_at" class="form-control" value="{{ old('reported_at', date('Y-m-d')) }}" required>
        </div>
        <div class="col-12">
          <label class="form-label">Judul Laporan</label>
          <input type="text" name="title" class="form-control" placeholder="Contoh: Laporan Penyaluran Bantuan Tahap 1" value="{{ old('title') }}" required>
        </div>
        <div class="col-12">
          <label class="form-label">Deskripsi Laporan</label>
          <textarea name="description" class="form-control" rows="4" placeholder="Jelaskan ringkasan kegiatan, kondisi di lapangan, dan hasil penyaluran bantuan...">{{ old('description') }}</textarea>
        </div>
        <div class="col-md-6">
          <label class="form-label">Jumlah Korban Terbantu</label>
          <input type="number" name="victim_helped" class="form-control" min="0" placeholder="0" value="{{ old('victim_helped') }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Total Dana Disalurkan (Rp)</label>
          <input type="number" name="total_distribution" class="form-control" min="0" placeholder="0" value="{{ old('total_distribution') }}" required>
        </div>
      </div>
    </div>
  </div>

  {{-- Dokumentasi Foto --}}
  <div class="card shadow-sm form-section">
    <div class="card-header"><i class="fa-solid fa-images me-2 text-primary"></i>Dokumentasi Foto</div>
    <div class="card-body">
      <div id="photoRows"></div>
      <button type="button" class="btn-add-row mt-2" id="addPhotoBtn">
        <i class="fa-solid fa-plus me-1"></i>Tambah Foto
      </button>
    </div>
  </div>

  {{-- Rincian Dana --}}
  <div class="card shadow-sm form-section">
    <div class="card-header"><i class="fa-solid fa-sack-dollar me-2 text-primary"></i>Rincian Penggunaan Dana <span class="text-muted fw-normal">(opsional)</span></div>
    <div class="card-body">
      <div id="itemRows"></div>
      <button type="button" class="btn-add-row" id="addItemBtn">
        <i class="fa-solid fa-plus me-1"></i>Tambah Rincian
      </button>
    </div>
  </div>

  {{-- Timeline Kegiatan --}}
  <div class="card shadow-sm form-section">
    <div class="card-header"><i class="fa-solid fa-timeline me-2 text-primary"></i>Timeline Kegiatan <span class="text-muted fw-normal">(opsional)</span></div>
    <div class="card-body">
      <div id="timelineRows"></div>
      <button type="button" class="btn-add-row" id="addTimelineBtn">
        <i class="fa-solid fa-plus me-1"></i>Tambah Timeline
      </button>
    </div>
  </div>

  {{-- Dokumen Pendukung --}}
  <div class="card shadow-sm form-section">
    <div class="card-header"><i class="fa-solid fa-paperclip me-2 text-primary"></i>Dokumen Pendukung <span class="text-muted fw-normal">(opsional)</span></div>
    <div class="card-body">
      <div id="documentRows"></div>
      <button type="button" class="btn-add-row" id="addDocumentBtn">
        <i class="fa-solid fa-plus me-1"></i>Tambah Dokumen
      </button>
      <div class="form-text mt-2" style="font-size:0.75rem;">Format: PDF, DOC, DOCX, XLS, XLSX, ZIP. Maks. 5MB per file.</div>
    </div>
  </div>

  <div class="d-flex gap-2 justify-content-end mb-5">
    <a href="{{ route('relawan.coordinator-reports.index') }}" class="btn btn-cancel">Batal</a>
    <button type="submit" class="btn btn-submit-report">
      <i class="fa-solid fa-paper-plane me-1"></i>Kirim Laporan
    </button>
  </div>
</form>
@endsection

@push('scripts')
<script>
let photoIndex = 0, itemIndex = 0, timelineIndex = 0, documentIndex = 0;

// ── Photo Row ──
function addPhotoRow() {
  const idx = photoIndex++;
  const html = `
    <div class="repeat-row" data-row="photo-${idx}">
      <div class="d-flex justify-content-between align-items-start mb-2">
        <span class="small fw-semibold text-muted">Foto #${idx + 1}</span>
        <button type="button" class="btn-remove-row" onclick="removeRow('photo-${idx}')"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="row g-2">
        <div class="col-md-5">
          <input type="file" name="photos[]" accept="image/*" class="form-control form-control-sm" onchange="previewPhoto(this, 'preview-${idx}')">
          <img id="preview-${idx}" class="preview-thumb mt-2 d-none" alt="preview">
        </div>
        <div class="col-md-7">
          <input type="text" name="photo_captions[]" class="form-control form-control-sm" placeholder="Keterangan foto (opsional)">
        </div>
      </div>
    </div>`;
  document.getElementById('photoRows').insertAdjacentHTML('beforeend', html);
}
function previewPhoto(input, previewId) {
  const img = document.getElementById(previewId);
  if (input.files && input.files[0]) {
    img.src = URL.createObjectURL(input.files[0]);
    img.classList.remove('d-none');
  }
}

// ── Icon preview mapping (sinkron dengan halaman detail) ──
const allocIconMap = {
  'makan': 'fa-bowl-food', 'nasi': 'fa-bowl-food', 'logistik': 'fa-truck-fast',
  'air': 'fa-droplet', 'minum': 'fa-droplet', 'selimut': 'fa-mug-hot',
  'pakaian': 'fa-shirt', 'baju': 'fa-shirt', 'obat': 'fa-kit-medical',
  'medis': 'fa-kit-medical', 'kesehatan': 'fa-kit-medical', 'tenda': 'fa-campground',
  'evakuasi': 'fa-people-carry-box', 'transport': 'fa-truck', 'bensin': 'fa-gas-pump',
  'operasional': 'fa-briefcase', 'listrik': 'fa-bolt', 'penerangan': 'fa-lightbulb',
  'sanitasi': 'fa-pump-soap', 'bayi': 'fa-baby', 'anak': 'fa-child-reaching',
};
function getAllocIcon(text) {
  text = (text || '').toLowerCase();
  for (const keyword in allocIconMap) {
    if (text.includes(keyword)) return allocIconMap[keyword];
  }
  return 'fa-box';
}
function updateItemIcon(idx) {
  const cat = document.querySelector(`[name="items[${idx}][category]"]`)?.value || '';
  const desc = document.querySelector(`[name="items[${idx}][description]"]`)?.value || '';
  const iconEl = document.getElementById(`item-icon-${idx}`);
  if (iconEl) iconEl.className = 'fa-solid ' + getAllocIcon(cat + ' ' + desc);
}

// ── Item Dana Row ──
function addItemRow() {
  const idx = itemIndex++;
  const html = `
    <div class="repeat-row" data-row="item-${idx}">
      <div class="d-flex justify-content-between align-items-start mb-2">
        <span class="small fw-semibold text-muted">Rincian #${idx + 1}</span>
        <button type="button" class="btn-remove-row" onclick="removeRow('item-${idx}')"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="d-flex gap-2 align-items-start">
        <div class="item-icon-preview" title="Icon menyesuaikan otomatis sesuai kategori/deskripsi">
          <i id="item-icon-${idx}" class="fa-solid fa-box"></i>
        </div>
        <div class="row g-2 flex-grow-1">
          <div class="col-md-4">
            <input type="text" name="items[${idx}][category]" class="form-control form-control-sm" placeholder="Kategori (mis. Logistik)" oninput="updateItemIcon(${idx})">
          </div>
          <div class="col-md-5">
            <input type="text" name="items[${idx}][description]" class="form-control form-control-sm" placeholder="Deskripsi (opsional)" oninput="updateItemIcon(${idx})">
          </div>
          <div class="col-md-3">
            <input type="number" name="items[${idx}][amount]" class="form-control form-control-sm" placeholder="Jumlah (Rp)" min="0">
          </div>
        </div>
      </div>
    </div>`;
  document.getElementById('itemRows').insertAdjacentHTML('beforeend', html);
}

// ── Timeline Row ──
function addTimelineRow() {
  const idx = timelineIndex++;
  const html = `
    <div class="repeat-row" data-row="timeline-${idx}">
      <div class="d-flex justify-content-between align-items-start mb-2">
        <span class="small fw-semibold text-muted">Timeline #${idx + 1}</span>
        <button type="button" class="btn-remove-row" onclick="removeRow('timeline-${idx}')"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="row g-2">
        <div class="col-md-3">
          <input type="date" name="timelines[${idx}][date]" class="form-control form-control-sm">
        </div>
        <div class="col-md-4">
          <input type="text" name="timelines[${idx}][title]" class="form-control form-control-sm" placeholder="Judul kegiatan">
        </div>
        <div class="col-md-5">
          <input type="text" name="timelines[${idx}][description]" class="form-control form-control-sm" placeholder="Deskripsi (opsional)">
        </div>
      </div>
    </div>`;
  document.getElementById('timelineRows').insertAdjacentHTML('beforeend', html);
}

// ── Document Row ──
function addDocumentRow() {
  const idx = documentIndex++;
  const html = `
    <div class="repeat-row" data-row="document-${idx}">
      <div class="d-flex justify-content-between align-items-start mb-2">
        <span class="small fw-semibold text-muted">Dokumen #${idx + 1}</span>
        <button type="button" class="btn-remove-row" onclick="removeRow('document-${idx}')"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="row g-2">
        <div class="col-md-5">
          <input type="file" name="documents[]" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip" class="form-control form-control-sm">
        </div>
        <div class="col-md-4">
          <input type="text" name="document_names[]" class="form-control form-control-sm" placeholder="Nama dokumen">
        </div>
        <div class="col-md-3">
          <input type="text" name="document_codes[]" class="form-control form-control-sm" placeholder="Kode (opsional)">
        </div>
      </div>
    </div>`;
  document.getElementById('documentRows').insertAdjacentHTML('beforeend', html);
}

function removeRow(key) {
  const row = document.querySelector(`[data-row="${key}"]`);
  if (row) row.remove();
}

document.getElementById('addPhotoBtn').addEventListener('click', addPhotoRow);
document.getElementById('addItemBtn').addEventListener('click', addItemRow);
document.getElementById('addTimelineBtn').addEventListener('click', addTimelineRow);
document.getElementById('addDocumentBtn').addEventListener('click', addDocumentRow);

// ── Show collected fund info for selected campaign ──
function updateCollectedInfo() {
  const select = document.getElementById('campaignSelect');
  const opt = select.options[select.selectedIndex];
  const box = document.getElementById('collectedInfo');
  const amountEl = document.getElementById('collectedAmount');
  if (opt && opt.value) {
    amountEl.textContent = opt.dataset.collected || 'Rp0';
    box.classList.remove('d-none');
  } else {
    box.classList.add('d-none');
  }
}
document.getElementById('campaignSelect').addEventListener('change', updateCollectedInfo);
updateCollectedInfo();

// Initial rows
addPhotoRow();

// Confirm before submit
document.getElementById('reportForm').addEventListener('submit', function (e) {
  e.preventDefault();
  Swal.fire({
    title: 'Kirim laporan ini?',
    text: 'Laporan akan dikirim ke admin untuk diverifikasi.',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Ya, Kirim',
    confirmButtonColor: '#0a2540',
    cancelButtonText: 'Batal',
    cancelButtonColor: '#6b7280',
  }).then((result) => {
    if (result.isConfirmed) {
      this.submit();
    }
  });
});
</script>
@endpush