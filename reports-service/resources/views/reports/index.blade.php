@extends('layouts.app')

@section('eyebrow', __('reports.role_'.session('user.role')).' · [Company name]')
@section('title', __('reports.weekly_reports'))

@section('content')
<div class="row g-3">

  {{-- Part 1: submit form --}}
  @if (session('user.role') === 'student')

  <div class="col-lg-8">
    <form action="/reports" method="POST" enctype="multipart/form-data" class="card card-body">
      @csrf
      <h2 class="h6 fw-bold mb-3">{{ __('reports.submit_report') }}</h2>

      <div class="mb-3">
        <label for="week_no" class="form-label small fw-semibold">{{ __('reports.week') }}</label>
        <input type="number" id="week_no" name="week_no" class="form-control" value="{{ old('week_no') }}">
        @error('week_no') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
      </div>

      <div class="mb-3">
        <label for="content" class="form-label small fw-semibold">{{ __('reports.comments') }}</label>
        <textarea id="content" name="content" class="form-control" rows="3">{{ old('content') }}</textarea>
        @error('content') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
      </div>

      <div class="mb-3">
        <label for="attachment" class="form-label small fw-semibold">{{ __('reports.attachment') }}</label>
        <input type="file" id="attachment" name="attachment" class="form-control">
        @error('attachment') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
      </div>

      <div class="d-flex justify-content-end gap-2">
        <button name="action" value="draft" class="btn btn-outline-secondary">{{ __('reports.save_draft') }}</button>
        <button name="action" value="submit" class="btn btn-primary">{{ __('reports.submit_report') }}</button>
      </div>
    </form>
  </div>
  @endif

  {{-- Part 2: previous reports from the database --}}
  <div class="{{ session('user.role') === 'student' ? 'col-lg-4' : 'col-12' }}">
    <div class="card card-body">
      <h2 class="h6 fw-bold mb-2">{{ __('reports.previous_reports') }}</h2>

      @foreach($reports as $report)
        <div class="py-2 border-bottom">
          <div class="d-flex justify-content-between align-items-center">
            <a href="/reports/{{ $report->id }}" class="fw-semibold text-decoration-none text-reset">
              {{ __('reports.week') }} {{ $report->week_no }}
              @if (session('user.role') !== 'student')
                <span class="text-muted small fw-normal">· <span dir="ltr">#{{ $report->placement_id }}</span></span>
              @endif
            </a>
            <x-status-badge :status="$report->status" />
          </div>
          @if($report->feedback)
            <p class="small text-muted mt-1 mb-0">{{ $report->feedback }}</p>
          @endif
        </div>
      @endforeach

      <div class="mt-3">{{ $reports->links() }}</div>
    </div>
  </div>

</div>
@endsection
