@extends('layouts.app')

@section('eyebrow', __('reports.role_'.session('user.role')) . ' · ' . __('reports.placement') . ' #' . $evaluation->placement_id)
@section('title', __('reports.final_evaluation'))

@section('content')
@php
  $criteria = ['technical_skills', 'teamwork', 'communication', 'punctuality', 'initiative'];
@endphp

<div class="row g-3">

  <div class="col-lg-8">
    <div class="card card-body">
      @foreach($criteria as $c)
        <div class="d-flex justify-content-between py-2 border-bottom">
          <span class="fw-semibold">{{ __('reports.'.$c) }}</span>
          <span>{{ $evaluation->$c }} / 5</span>
        </div>
      @endforeach
      <div class="d-flex justify-content-between pt-3">
        <span class="fw-bold">{{ __('reports.total') }}</span>
        <span class="fw-bold">{{ $evaluation->total }} / 25</span>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card card-body">
      <div class="mb-3">
        <span class="badge-soft {{ $evaluation->status == 'submitted' ? 'success' : 'secondary' }}">
          {{ __('reports.eval_'.$evaluation->status) }}
        </span>
      </div>

      @if($evaluation->comments)
        <div class="small text-muted">{{ __('reports.comments') }}</div>
        <p dir="auto">{{ $evaluation->comments }}</p>
      @endif

      @if($evaluation->status == 'draft' && session('user.role') === 'supervisor')
        <a href="/evaluations/{{ $evaluation->id }}/edit" class="btn btn-primary w-100">{{ __('reports.edit') }}</a>
      @endif
    </div>
  </div>

</div>
@endsection

