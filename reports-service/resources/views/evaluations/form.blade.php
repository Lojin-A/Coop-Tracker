@extends('layouts.app')

@section('eyebrow', 'Supervisor · ' . __('reports.placement') . ' #' . $placementId)
@section('title', __('reports.final_evaluation'))

@section('content')
@php
  $criteria = ['technical_skills', 'teamwork', 'communication', 'punctuality', 'initiative'];
@endphp

<form action="{{ $evaluation ? '/evaluations/'.$evaluation->id : '/evaluations' }}" method="POST">
  @csrf
  @if($evaluation) @method('PUT') @endif
  <input type="hidden" name="placement_id" value="{{ $placementId }}">

  @error('placement_id') <div class="alert alert-danger">{{ $message }}</div> @enderror

  <div class="row g-3">

    {{-- Criteria: 1 to 5 each --}}
    <div class="col-lg-8">
      <div class="card card-body">
        @foreach($criteria as $c)
          <div class="py-2 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
              <span class="fw-semibold">{{ __('reports.'.$c) }}</span>
              <div>
                @for($i = 1; $i <= 5; $i++)
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="{{ $c }}" id="{{ $c }}_{{ $i }}" value="{{ $i }}"
                           {{ old($c, $evaluation->$c ?? null) == $i ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ $c }}_{{ $i }}">{{ $i }}</label>
                  </div>
                @endfor
              </div>
            </div>
            @error($c) <div class="text-danger small mt-1">{{ $message }}</div> @enderror
          </div>
        @endforeach
      </div>
    </div>

    {{-- Hours, comments, buttons --}}
    <div class="col-lg-4">
      <div class="card card-body">
        <div class="small text-muted">{{ __('reports.approved_hours') }}</div>
        <div class="h4 fw-bold mb-3">120</div> {{-- temporary; Phase 7 gets it from Lojin's service --}}

        <label for="comments" class="form-label small fw-semibold">{{ __('reports.comments') }}</label>
        <textarea id="comments" name="comments" class="form-control mb-3" rows="4">{{ old('comments', $evaluation->comments ?? '') }}</textarea>

        <button name="action" value="draft" class="btn btn-outline-secondary w-100 mb-2">{{ __('reports.save_draft') }}</button>
        <button name="action" value="submit" class="btn btn-primary w-100">{{ __('reports.submit_evaluation') }}</button>
      </div>
    </div>

  </div>
</form>
@endsection
