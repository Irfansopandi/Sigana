@extends('admin.layouts.app')

@section('title', 'Penugasan Relawan')
@section('page_title', 'Penugasan Relawan')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-list-check text-success me-2"></i>Penugasan Relawan</h5>
    <p class="text-muted small mb-0">Lihat penugasan relawan dan tambahkan relawan ke kampanye bencana.</p>
  </div>
  <a href="{{ route('admin.assignments.create') }}" class="btn btn-success btn-sm">
    <i class="fa-solid fa-plus me-2"></i>Tambah Penugasan
  </a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card border-0 shadow-sm">
  <div class="card-body p-3">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Kampanye</th>
            <th>Relawan</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($assignments as $campaign)
            <tr>
              <td>{{ $loop->iteration + ($assignments->currentPage() - 1) * $assignments->perPage() }}</td>
              <td>{{ $campaign->title }}</td>
              <td>{{ $campaign->assignedVolunteer?->name ?? '-' }}</td>
              <td>
                @if($campaign->assignedVolunteer)
                  <span class="badge bg-success">Terpasang</span>
                @else
                  <span class="badge bg-secondary">Belum ditugaskan</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center text-muted">Belum ada data penugasan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $assignments->links() }}
    </div>
  </div>
</div>
@endsection
