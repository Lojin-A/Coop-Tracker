@extends('layouts.app')

@section('title', __('attendance.my_attendance_title'))

@section('sidebar-links')
    <li class="nav-item"><a class="nav-link active" href="#">{{ __('attendance.sidebar_my_attendance') }}</a></li>
    <li class="nav-item"><a class="nav-link" href="#">{{ __('attendance.sidebar_weekly_reports') }}</a></li>
    <li class="nav-item"><a class="nav-link" href="#">{{ __('attendance.sidebar_my_evaluation') }}</a></li>
@endsection

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-md-5">
            <div class="card text-bg-dark h-100">
                <div class="card-body">
                    @if(($today->check_out ?? null) === null && ($today->check_in ?? null))
                        <p class="mb-1">{{ __('attendance.not_checked_out') }}</p>
                        <h5>{{ __('attendance.status_in_progress') }}</h5>
                        <button class="btn btn-light w-100 mt-3">{{ __('attendance.check_out_btn') }}</button>
                    @else
                        <p class="mb-0 text-white-50">{{ __('attendance.no_records') }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">{{ __('attendance.approved_hours') }}</p>
                    <h3>{{ $approvedHours ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">{{ __('attendance.waiting_approval') }}</p>
                    <h3>{{ $pendingCount ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">{{ __('attendance.attendance_history') }}</h5>
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>{{ __('attendance.col_date') }}</th>
                        <th>{{ __('attendance.col_check_in') }}</th>
                        <th>{{ __('attendance.col_check_out') }}</th>
                        <th>{{ __('attendance.col_hours') }}</th>
                        <th>{{ __('attendance.col_status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances ?? [] as $attendance)
                        <tr>
                            <td>{{ $attendance->date }}</td>
                            <td>{{ $attendance->check_in }}</td>
                            <td>{{ $attendance->check_out }}</td>
                            <td>{{ $attendance->hours }}</td>
                            <td>{{ __('attendance.status_' . $attendance->status) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">{{ __('attendance.no_records') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
