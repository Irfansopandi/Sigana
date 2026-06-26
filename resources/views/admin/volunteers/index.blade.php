@extends('admin.layouts.app')

@section('title', 'Data Relawan')
@section('page_title', 'Data Relawan')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-shield-halved text-success me-2"></i>Data Relawan</h5>
    <p class="text-muted small mb-0">Verifikasi relawan terdaftar dan pantau status akun.</p>
  </div>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card border-0 shadow-sm">
  <div class="card-body p-3">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Profil</th>
            <th>Verifikasi</th>
            <th>Tindakan</th>
          </tr>
        </thead>
        <tbody>
          @forelse($volunteers as $volunteer)
            <tr>
              <td>{{ $loop->iteration + ($volunteers->currentPage() - 1) * $volunteers->perPage() }}</td>
              <td>{{ $volunteer->name }}</td>
              <td>{{ $volunteer->email }}</td>
              <td>
                @if($volunteer->profile_complete)
                  <span class="badge bg-success">Lengkap</span>
                @else
                  <span class="badge bg-danger">Belum Lengkap</span>
                @endif
              </td>
              <td>
                @if($volunteer->is_verified)
                  <span class="badge bg-success">Terverifikasi</span>
                @else
                  <span class="badge bg-warning text-dark">Belum Diverifikasi</span>
                @endif
              </td>
              <td>
                <div class="btn-group" role="group">
                  <a href="{{ route('admin.volunteers.show', $volunteer) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                  @if($volunteer->is_verified)
                    <button type="button" class="btn btn-sm btn-secondary" disabled>Sudah Diverifikasi</button>
                  @elseif(!$volunteer->profile_complete)
                    <button type="button" class="btn btn-sm btn-warning" disabled>Data Belum Lengkap</button>
                  @else
                    <form action="{{ route('admin.volunteers.verify', $volunteer) }}" method="POST" class="d-inline">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-primary">Verifikasi</button>
                    </form>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted">Belum ada relawan yang terdaftar.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $volunteers->links() }}
    </div>
  </div>
</div>
@endsection
