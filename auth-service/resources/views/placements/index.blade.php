@extends('layouts.panel')

@section('title', __('messages.placements'))

@section('content')
@php
    $isCoordinator = auth()->user()->role === 'coordinator';
    $isStudent = auth()->user()->role === 'student';
@endphp

<div class="d-flex justify-content-between align-items-center">
    <h1 class="page-title">{{ $isStudent ? __('messages.my_placement') : __('messages.placements') }}</h1>
    @if ($isCoordinator)
        <a href="{{ route('placements.create') }}" class="btn btn-accent px-4 d-inline-flex align-items-center">{{ __('messages.new_placement') }}</a>
    @endif
</div>

@if ($isStudent && $placements->isEmpty())
    {{-- A student who has not been assigned yet sees a friendly message instead of an empty table --}}
    <div class="card">
        <div class="card-body text-center py-5">
            <h2 class="card-title mb-2">{{ __('messages.no_placement_yet') }}</h2>
            <p class="text-muted-2 mb-0">{{ __('messages.no_placement_text') }}</p>
        </div>
    </div>
@else
    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('messages.student') }}</th>
                        <th scope="col">{{ __('messages.company') }}</th>
                        <th scope="col">{{ __('messages.supervisor') }}</th>
                        <th scope="col">{{ __('messages.period') }}</th>
                        <th scope="col">{{ __('messages.weeks') }}</th>
                        <th scope="col">{{ __('messages.status') }}</th>
                        <th scope="col">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($placements as $placement)
                        <tr>
                            <td class="num">{{ $placement->id }}</td>
                            <td>{{ $placement->student->name }}</td>
                            <td>{{ $placement->company->name }}</td>
                            <td>{{ $placement->supervisor->name }}</td>
                            {{-- <bdi> keeps each date intact when the page is right-to-left --}}
                            <td><bdi>{{ $placement->start_date }}</bdi> {{ __('messages.to') }} <bdi>{{ $placement->end_date }}</bdi></td>
                            <td class="num">{{ $placement->required_weeks }}</td>
                            <td>
                                {{-- Badge colour depends on the status --}}
                                @if ($placement->status === 'active')
                                    <span class="badge-ok">{{ __('messages.status_active') }}</span>
                                @elseif ($placement->status === 'completed')
                                    <span class="badge-pending">{{ __('messages.status_completed') }}</span>
                                @else
                                    <span class="badge-late">{{ __('messages.status_cancelled') }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    {{-- @can runs PlacementPolicy::view for this record --}}
                                    @can('view', $placement)
                                        <a href="{{ route('placements.show', $placement) }}" class="btn btn-quiet btn-sm d-inline-flex align-items-center">{{ __('messages.view') }}</a>
                                    @endcan

                                    @if ($isCoordinator)
                                        <a href="{{ route('placements.edit', $placement) }}" class="btn btn-quiet btn-sm d-inline-flex align-items-center">{{ __('messages.edit') }}</a>
                                        <form method="POST" action="{{ route('placements.destroy', $placement) }}"
                                              onsubmit="return confirm('{{ __('messages.confirm_delete_placement') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-reject btn-sm">{{ __('messages.delete') }}</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted-2 py-4">{{ __('messages.no_placements') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection