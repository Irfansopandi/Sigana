@extends('admin.layouts.app')

@section('title', 'Donasi')
@section('page_title', 'Donasi')

@section('content')
<div class="mb-4">
  <h5 class="fw-bold mb-1"><i class="fa-solid fa-money-bill-transfer text-warning me-2"></i>Donasi</h5>
  <p class="text-muted small mb-0">Pantau transaksi donasi dan status pembayarannya.</p>
</div>

<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Metode</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          @forelse($donations as $donation)
            <tr>
              <td>{{ $loop->iteration + ($donations->currentPage() - 1) * $donations->perPage() }}</td>
              <td>{{ $donation->name }}</td>
              <td>{{ $donation->amount }}</td>
              <td>{{ ucfirst($donation->payment_status) }}</td>
              <td>{{ $donation->payment_method }}</td>
              <td>{{ $donation->created_at->format('d M Y') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted">Belum ada data donasi.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="p-3">{{ $donations->links() }}</div>
  </div>
</div>
@endsection
