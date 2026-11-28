@extends('layouts.app')

@section('eyebrow', __('reports.role_'.session('user.role')) . ' · ' . __('reports.review'))
@section('title', __('reports.week') . ' ' . $report->week_no)

@section('content')
<div class="row g-3">

  {{-- The student's report --}}
  <div class="{{ session('user.role') === 'supervisor' || $report->feedback ? 'col-lg-8' : 'col-12' }}">
    <div class="card card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h6 fw-bold mb-0">{{ __('reports.comments') }}</h2>
        <x-status-badge :status="$report->status" />
      </div>
      <p dir="auto" class="mb-3">{{ $report->content }}</p>

      @if($report->file_path)
        <a href="{{ asset('storage/'.$report->file_path) }}" target="_blank" class="btn btn-outline-secondary align-self-start">
          {{ __('reports.download_pdf') }}
        </a>
      @endif
    </div>
  </div>

  @if (session('user.role') === 'supervisor')
    {{-- Supervisor feedback form (supervisor only) --}}
    <div class="col-lg-4">
      <form action="/reports/{{ $report->id }}" method="POST" class="card card-body">
        @csrf
        @method('PUT')
        <label for="feedback" class="form-label small fw-semibold">{{ __('reports.feedback') }}</label>
        <textarea id="feedback" name="feedback" class="form-control" rows="4">{{ old('feedback', $report->feedback) }}</textarea>
        @error('feedback') <div class="text-danger small mt-1">{{ $message }}</div> @enderror

        <button name="decision" value="reviewed" class="btn btn-primary w-100 mt-3">{{ __('reports.mark_reviewed') }}</button>
        <button name="decision" value="changes_requested" class="btn btn-outline-danger w-100 mt-2">{{ __('reports.request_changes') }}</button>
      </form>
    </div>
  @elseif ($report->feedback)
    {{-- Read-only feedback for student and coordinator --}}
    <div class="col-lg-4">
      <div class="card card-body">
        <h2 class="h6 fw-bold mb-2">{{ __('reports.feedback') }}</h2>
        <p dir="auto" class="mb-0">{{ $report->feedback }}</p>
      </div>
    </div>
  @endif

</div>
@endsection
