@extends('admin.layouts.app')

@section('title', 'Detail Laporan Transparansi')
@section('page_title', 'Detail Laporan Transparansi')

@section('content')
<div class="mb-4">
  <h5 class="fw-bold mb-1"><i class="fa-solid fa-file-lines text-info me-2"></i>Detail Laporan Transparansi</h5>
  <p class="text-muted small mb-0">Ubah status laporan transparansi dan tinjau ringkasan penyaluran.</p>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="row g-4">
  <div class="col-lg-7">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div>
            <h5 class="mb-1">{{ $report->campaign->title ?? 'Kampanye tidak tersedia' }}</h5>
            <div class="small text-muted">Tanggal laporan: {{ $report->date }}</div>
          </div>
          <span class="badge {{ $report->status_class }}">{{ $report->status }}</span>
        </div>

        <p class="text-muted">{{ $report->description }}</p>

        <div class="row g-3 mt-4">
          <div class="col-6">
            <div class="text-muted small">Digunakan</div>
            <div class="fw-semibold">{{ $report->used }}</div>
          </div>
          <div class="col-6">
            <div class="text-muted small">Sisa</div>
            <div class="fw-semibold">{{ $report->remaining }}</div>
          </div>
        </div>

        <div class="mt-4">
          <div class="text-muted small mb-2">Progress penyaluran</div>
          <div class="progress" style="height: 10px;">
            <div class="progress-bar" role="progressbar" style="width: {{ $report->progress_raw }}%; background: {{ $report->progress_color }};" aria-valuenow="{{ $report->progress_raw }}" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <div class="small text-muted mt-2">{{ $report->progress }} selesai</div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h6 class="fw-semibold mb-3">Perbarui Status</h6>
        <form action="{{ route('admin.transparency.update', $report) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label for="status" class="form-label">Status Laporan</label>
            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
              @foreach($statusOptions as $value => $label)
                <option value="{{ $value }}" {{ old('status', $report->status) == $value ? 'selected' : '' }}>{{ $label }}</option>
              @endforeach
            </select>
            @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
