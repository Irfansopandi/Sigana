@extends('admin.layouts.app')

@section('title', 'Tambah Penugasan Relawan')
@section('page_title', 'Tambah Penugasan Relawan')

@section('content')
<div class="mb-4">
  <h5 class="fw-bold mb-1"><i class="fa-solid fa-list-check text-success me-2"></i>Tambah Penugasan Relawan</h5>
  <p class="text-muted small mb-0">Tentukan relawan untuk kampanye bencana yang membutuhkan dukungan lapangan.</p>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <form action="{{ route('admin.assignments.store') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label for="campaign_id" class="form-label">Kampanye</label>
            <select id="campaign_id" name="campaign_id" class="form-select @error('campaign_id') is-invalid @enderror">
              <option value="">Pilih kampanye</option>
              @foreach($campaigns as $campaign)
                <option value="{{ $campaign->id }}" {{ old('campaign_id') == $campaign->id ? 'selected' : '' }}>{{ $campaign->title }} @if($campaign->assignedVolunteer) - (Sudah ditugaskan ke {{ $campaign->assignedVolunteer->name }})@endif</option>
              @endforeach
            </select>
            @error('campaign_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="volunteer_id" class="form-label">Relawan</label>
            <select id="volunteer_id" name="volunteer_id" class="form-select @error('volunteer_id') is-invalid @enderror">
              <option value="">Pilih relawan</option>
              @foreach($volunteers as $volunteer)
                <option value="{{ $volunteer->id }}" {{ old('volunteer_id') == $volunteer->id ? 'selected' : '' }}>{{ $volunteer->name }} ({{ $volunteer->email }})</option>
              @endforeach
            </select>
            @error('volunteer_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary">Simpan Penugasan</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
