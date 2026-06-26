@extends('admin.layouts.app')

@section('title', 'Edit Kampanye')
@section('page_title', 'Edit Kampanye')

@push('styles')
<style>
  .form-section {
    background: #fff;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid #e5e7eb;
  }

  .image-preview {
    max-width: 200px;
    max-height: 200px;
    border-radius: 0.5rem;
    object-fit: cover;
    margin-top: 0.5rem;
  }

  .form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
  }
</style>
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-pen-to-square text-warning me-2"></i>Edit Kampanye</h5>
    <p class="text-muted small mb-0">Perbarui informasi kampanye yang sudah dibuat.</p>
  </div>
  <a href="{{ route('admin.campaigns.show', $campaign) }}" class="btn btn-outline-secondary btn-sm">
    <i class="fa-solid fa-arrow-left me-2"></i>Kembali</a>
</div>

<form action="{{ route('admin.campaigns.update', $campaign) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="form-section">
    <h6><i class="fa-solid fa-info-circle me-2"></i>Informasi Dasar</h6>
    <div class="row g-3">
      <div class="col-md-6">
        <label for="title" class="form-label">Judul Kampanye</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" 
               name="title" value="{{ old('title', $campaign->title) }}" required>
        @error('title')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-md-6">
        <label for="location" class="form-label">Lokasi</label>
        <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" 
               name="location" value="{{ old('location', $campaign->location) }}" required>
        @error('location')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-md-6">
        <label for="category" class="form-label">Kategori Bencana</label>
        <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
          <option value="">-- Pilih Kategori --</option>
          @foreach(['Banjir','Gempa Bumi','Longsor','Kebakaran','Tsunami','Puting Beliung','Lainnya'] as $option)
            <option value="{{ $option }}" {{ old('category', $campaign->category) === $option ? 'selected' : '' }}>{{ $option }}</option>
          @endforeach
        </select>
        @error('category')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-md-6">
        <label for="status" class="form-label">Status Kampanye</label>
        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
          <option value="">-- Pilih Status --</option>
          @foreach(['Aktif','Darurat','Waspada'] as $option)
            <option value="{{ $option }}" {{ old('status', $campaign->status) === $option ? 'selected' : '' }}>{{ $option }}</option>
          @endforeach
        </select>
        @error('status')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>

  <div class="form-section">
    <h6><i class="fa-solid fa-target me-2"></i>Target Donasi & Durasi</h6>
    <div class="row g-3">
      <div class="col-md-6">
        <label for="target_raw" class="form-label">Target Donasi (Rp)</label>
        <input type="number" class="form-control @error('target_raw') is-invalid @enderror" id="target_raw" 
               name="target_raw" value="{{ old('target_raw', $campaign->getRawOriginal('target_raw')) }}" step="0.01" required>
        @error('target_raw')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-md-6">
        <label for="days_left" class="form-label">Durasi Kampanye (Hari)</label>
        <input type="number" class="form-control @error('days_left') is-invalid @enderror" id="days_left" 
               name="days_left" value="{{ old('days_left', $campaign->days_left) }}" min="1" required>
        @error('days_left')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-md-6">
        <label for="date_published" class="form-label">Tanggal Publikasi</label>
        <input type="date" class="form-control @error('date_published') is-invalid @enderror" id="date_published" 
               name="date_published" value="{{ old('date_published', $campaign->getRawOriginal('date_published')) }}" required>
        @error('date_published')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-md-6">
        <label for="victims" class="form-label">Jumlah Korban (Opsional)</label>
        <input type="number" class="form-control @error('victims') is-invalid @enderror" id="victims" 
               name="victims" value="{{ old('victims', $campaign->victims) }}" min="0">
        @error('victims')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>

  <div class="form-section">
    <h6><i class="fa-solid fa-align-left me-2"></i>Deskripsi Kampanye</h6>
    <div class="mb-3">
      <label for="description_short" class="form-label">Deskripsi Singkat</label>
      <textarea class="form-control @error('description_short') is-invalid @enderror" id="description_short" 
                name="description_short" rows="3" required>{{ old('description_short', $campaign->description_short) }}</textarea>
      @error('description_short')
        <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="description_long" class="form-label">Deskripsi Lengkap</label>
      <textarea class="form-control @error('description_long') is-invalid @enderror" id="description_long" 
                name="description_long" rows="6" required>{{ old('description_long', $campaign->description_long) }}</textarea>
      @error('description_long')
        <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    </div>
  </div>

  <div class="form-section">
    <h6><i class="fa-solid fa-image me-2"></i>Gambar & Lokasi</h6>
    <div class="row g-3">
      <div class="col-md-6">
        <label for="image" class="form-label">Foto Kampanye</label>
        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" 
               name="image" accept="image/*">
        <small class="text-muted">Format: JPG, PNG, GIF (Max 2MB)</small>
        <div id="imagePreview">
          <img src="{{ $campaign->image ? asset('storage/' . $campaign->image) : asset('storage/assets/default-campaign.jpg') }}" class="image-preview" alt="Preview"></div>
        @error('image')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-md-3">
        <label for="latitude" class="form-label">Latitude (Opsional)</label>
        <input type="number" class="form-control @error('latitude') is-invalid @enderror" id="latitude" 
               name="latitude" value="{{ old('latitude', $campaign->latitude) }}" step="0.0001">
        @error('latitude')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-md-3">
        <label for="longitude" class="form-label">Longitude (Opsional)</label>
        <input type="number" class="form-control @error('longitude') is-invalid @enderror" id="longitude" 
               name="longitude" value="{{ old('longitude', $campaign->longitude) }}" step="0.0001">
        @error('longitude')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>

  <div class="d-flex gap-2 justify-content-end">
    <a href="{{ route('admin.campaigns.show', $campaign) }}" class="btn btn-outline-secondary">Batal</a>
    <button type="submit" class="btn btn-primary">
      <i class="fa-solid fa-check me-2"></i>Perbarui Kampanye
    </button>
  </div>
</form>
@endsection

@push('scripts')
<script>
  document.getElementById('image').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';

    if (e.target.files && e.target.files[0]) {
      const reader = new FileReader();
      reader.onload = function(event) {
        const img = document.createElement('img');
        img.src = event.target.result;
        img.className = 'image-preview';
        preview.appendChild(img);
      };
      reader.readAsDataURL(e.target.files[0]);
    }
  });
</script>
@endpush