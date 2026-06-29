@extends('admin.layouts.app')

@section('title', 'Donasi')
@section('page_title', 'Donasi')

@push('styles')
<style>
  .btn-detail {
    border-radius: 8px;
    border: 1.5px solid #e2e8f0;
    color: #64748b;
    background: #fff;
    transition: all .2s;
  }
  .btn-detail:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
    border-color: #2563eb !important;
    color: #2563eb !important;
    background: #fff !important;
  }

  .stat-card-item {
  transition: transform .2s ease, box-shadow .2s ease;
  }
  .stat-card-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(15, 23, 42, 0.10) !important;
  }
</style>
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-money-bill-transfer text-warning me-2"></i>Donasi</h5>
    <p class="text-muted small mb-0">Pantau transaksi donasi dan status pembayarannya.</p>
  </div>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
  <div class="col-12 col-md-6">
    <div class="card border-0 shadow-sm h-100 stat-card-item" style="border-radius:16px; border-left:4px solid #2563eb !important;">
      <div class="card-body d-flex align-items-center gap-3 p-4">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(37,99,235,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="fa-solid fa-users" style="color:#2563eb;font-size:1.2rem;"></i>
        </div>
        <div>
          <div class="small" style="color:#64748b;">Total Donatur</div>
          <div class="fw-bold" style="font-size:1.4rem;color:#0f172a;">{{ number_format($stats['total_donatur']) }}</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-6">
    <div class="card border-0 shadow-sm h-100 stat-card-item" style="border-radius:16px; border-left:4px solid #059669 !important;">
      <div class="card-body d-flex align-items-center gap-3 p-4">
        <div style="width:48px;height:48px;border-radius:12px;background:rgba(5,150,105,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="fa-solid fa-coins" style="color:#059669;font-size:1.2rem;"></i>
        </div>
        <div>
          <div class="small" style="color:#64748b;">Total Terkumpul</div>
          <div class="fw-bold" style="font-size:1.4rem;color:#0f172a;">Rp {{ number_format($stats['total_nominal'], 0, ',', '.') }}</div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Filter --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius:1rem;">
  <div class="card-body p-3">
    <div class="d-flex flex-wrap gap-2 align-items-center">

      {{-- Per Page --}}
      <span class="text-muted small">Tampilkan</span>
      <select onchange="window.location='{{ route('admin.donations.index') }}?search={{ $search }}&per_page='+this.value"
        class="form-select form-select-sm" style="width:70px;border-radius:8px;">
        @foreach([10, 25, 50] as $n)
          <option value="{{ $n }}" {{ $perPage == $n ? 'selected' : '' }}>{{ $n }}</option>
        @endforeach
      </select>

      {{-- Search --}}
      <form method="GET" action="{{ route('admin.donations.index') }}" class="ms-auto d-flex gap-2">
        <input type="hidden" name="per_page" value="{{ $perPage }}">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama donatur..."
          class="form-control form-control-sm" style="border-radius:8px; min-width:200px;">
        <button type="submit" class="btn btn-sm btn-primary" style="border-radius:8px;">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
        @if($search)
          <a href="{{ route('admin.donations.index', ['per_page' => $perPage]) }}"
            class="btn btn-sm" style="border-radius:8px; border:1.5px solid #e2e8f0; color:#64748b;">
            <i class="fa-solid fa-xmark"></i>
          </a>
        @endif
      </form>
    </div>
  </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm" style="border-radius:1rem;">
  <div class="card-body p-3">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Kampanye</th>
            <th>Jumlah</th>
            <th>Metode</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          @forelse($donations as $donation)
            <tr>
              <td class="text-muted small">{{ $loop->iteration + ($donations->currentPage() - 1) * $donations->perPage() }}</td>
              <td class="fw-semibold">{{ $donation->name }}</td>
              <td class="text-muted small">{{ $donation->campaign->title ?? '-' }}</td>
                <td class="fw-semibold">Rp {{ number_format($donation->getRawOriginal('amount'), 0, ',', '.') }}</td>              
              <td class="text-muted small">{{ $donation->payment_method ?? '-' }}</td>
              <td class="text-muted small">{{ $donation->created_at->format('d M Y') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-4">Belum ada data donasi.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
      <div class="text-muted small">
        Menampilkan {{ $donations->firstItem() }}–{{ $donations->lastItem() }} dari {{ $donations->total() }} donasi
      </div>
      <div>{{ $donations->links() }}</div>
    </div>
  </div>
</div>
@endsection