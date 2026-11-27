@extends('layouts.app')

@section('eyebrow', __('reports.role_'.session('user.role')) . ' · [Company name]')
@section('title', __('reports.evaluations'))

@section('content')
<div class="card card-body">
  <table class="table align-middle mb-0">
    <thead>
      <tr>
        <th>{{ __('reports.placement') }}</th>
        <th>{{ __('reports.total') }}</th>
        <th>{{ __('reports.status') }}</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($placementIds as $id)
        @php
          $evaluation = $evaluations[$id] ?? null;
          // a student sees the evaluation only after it is submitted
          $visible = $evaluation && (session('user.role') !== 'student' || $evaluation->status == 'submitted');
        @endphp
        <tr>
          <td class="fw-semibold">{{ __('reports.placement') }} #{{ $id }}</td>

          @if($visible)
            <td>{{ $evaluation->total }} / 25</td>
            <td>
              <span class="badge-soft {{ $evaluation->status == 'submitted' ? 'success' : 'secondary' }}">
                {{ __('reports.eval_'.$evaluation->status) }}
              </span>
            </td>
            <td class="text-end">
              <a href="/evaluations/{{ $evaluation->id }}" class="btn btn-sm btn-outline-secondary">{{ __('reports.view') }}</a>
            </td>
          @else
            <td colspan="2" class="text-muted">{{ __('reports.not_evaluated') }}</td>
            <td class="text-end">
              @if(! $evaluation && session('user.role') === 'supervisor')
                <a href="/evaluations/create/{{ $id }}" class="btn btn-sm btn-primary">{{ __('reports.evaluate') }}</a>
              @endif
            </td>
          @endif
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
