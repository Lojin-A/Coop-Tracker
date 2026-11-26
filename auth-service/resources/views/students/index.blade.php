@extends('layouts.panel')

@section('title', __('messages.students'))

@section('content')
<h1 class="page-title">{{ __('messages.students') }}</h1>

@php $placedCount = $students->filter(fn ($s) => $s->placement)->count(); @endphp

{{-- Summary cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card"><div class="card-body">
            <div class="kpi-label">{{ __('messages.all_students') }}</div>
            <div class="kpi-value">{{ $students->count() }}</div>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card"><div class="card-body">
            <div class="kpi-label">{{ __('messages.with_placement') }}</div>
            <div class="kpi-value">{{ $placedCount }}</div>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card"><div class="card-body">
            <div class="kpi-label">{{ __('messages.not_placed_yet') }}</div>
            <div class="kpi-value text-warn">{{ $students->count() - $placedCount }}</div>
        </div></div>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th scope="col">{{ __('messages.name') }}</th>
                    <th scope="col">{{ __('messages.email') }}</th>
                    <th scope="col">{{ __('messages.company') }}</th>
                    <th scope="col">{{ __('messages.supervisor') }}</th>
                    <th scope="col">{{ __('messages.status') }}</th>
                    <th scope="col">{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td><bdi>{{ $student->email }}</bdi></td>
                        <td>{{ $student->placement?->company->name ?? '-' }}</td>
                        <td>{{ $student->placement?->supervisor->name ?? '-' }}</td>
                        <td>
                            @if ($student->placement)
                                <span class="badge-ok">{{ __('messages.placed') }}</span>
                            @else
                                <span class="badge-late">{{ __('messages.not_placed') }}</span>
                            @endif
                        </td>
                        <td>
                            @if ($student->placement)
                                <a href="{{ route('placements.show', $student->placement) }}" class="btn btn-quiet btn-sm d-inline-flex align-items-center">{{ __('messages.view') }}</a>
                            @else
                                {{-- Opens the new placement form with this student already selected --}}
                                <a href="{{ route('placements.create', ['student_id' => $student->id]) }}" class="btn btn-accent btn-sm d-inline-flex align-items-center">{{ __('messages.assign_placement') }}</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted-2 py-4">{{ __('messages.no_students') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection