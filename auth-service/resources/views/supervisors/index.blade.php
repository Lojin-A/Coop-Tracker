@extends('layouts.panel')

@section('title', __('messages.supervisors'))

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="page-title">{{ __('messages.supervisors') }}</h1>
    <a href="{{ route('supervisors.create') }}" class="btn btn-accent px-4 d-inline-flex align-items-center">{{ __('messages.add_supervisor') }}</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th scope="col">{{ __('messages.name') }}</th>
                    <th scope="col">{{ __('messages.email') }}</th>
                    <th scope="col">{{ __('messages.students') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($supervisors as $supervisor)
                    <tr>
                        <td>{{ $supervisor->name }}</td>
                        <td><bdi>{{ $supervisor->email }}</bdi></td>
                        <td class="num">{{ $supervisor->supervised_placements_count }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-muted-2 py-4">{{ __('messages.no_supervisors') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection