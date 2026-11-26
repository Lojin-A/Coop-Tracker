@extends('layouts.panel')

@section('title', __('messages.placement_details'))

@section('content')
<h1 class="page-title">{{ __('messages.placement_details') }}</h1>

<div class="card">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3 text-muted-2">{{ __('messages.student') }}</dt>
            <dd class="col-sm-9">{{ $placement->student->name }}</dd>

            <dt class="col-sm-3 text-muted-2">{{ __('messages.supervisor') }}</dt>
            <dd class="col-sm-9">{{ $placement->supervisor->name }}</dd>

            <dt class="col-sm-3 text-muted-2">{{ __('messages.company') }}</dt>
            <dd class="col-sm-9">{{ $placement->company->name }}</dd>

            <dt class="col-sm-3 text-muted-2">{{ __('messages.period') }}</dt>
            <dd class="col-sm-9"><bdi>{{ $placement->start_date }}</bdi> {{ __('messages.to') }} <bdi>{{ $placement->end_date }}</bdi></dd>

            <dt class="col-sm-3 text-muted-2">{{ __('messages.required_weeks') }}</dt>
            <dd class="col-sm-9 num">{{ $placement->required_weeks }}</dd>

            <dt class="col-sm-3 text-muted-2">{{ __('messages.status') }}</dt>
            <dd class="col-sm-9">{{ __('messages.status_' . $placement->status) }}</dd>
        </dl>
    </div>
</div>

<a href="{{ route('placements.index') }}" class="btn btn-quiet px-4 mt-3 d-inline-flex align-items-center">{{ __('messages.back') }}</a>
@endsection