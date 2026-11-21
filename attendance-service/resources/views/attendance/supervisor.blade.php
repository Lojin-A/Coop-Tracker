@extends('layouts.app')

@section('title', __('attendance.approvals_title'))

@section('sidebar-links')
    <li class="nav-item"><a class="nav-link" href="#">{{ __('attendance.sidebar_my_students') }}</a></li>
    <li class="nav-item"><a class="nav-link active" href="#">{{ __('attendance.sidebar_attendance') }}</a></li>
    <li class="nav-item"><a class="nav-link" href="#">{{ __('attendance.sidebar_weekly_reports') }}</a></li>
    <li class="nav-item"><a class="nav-link" href="#">{{ __('attendance.sidebar_evaluations') }}</a></li>
@endsection

@section('content')
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ $activeStatus === 'pending' ? 'active' : '' }}" href="/attendance/supervisor?status=pending">{{ __('attendance.tab_pending') }} · {{ $pendingCount ?? 0 }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeStatus === 'approved' ? 'active' : '' }}" href="/attendance/supervisor?status=approved">{{ __('attendance.tab_approved') }} · {{ $approvedCount ?? 0 }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeStatus === 'absent' ? 'active' : '' }}" href="/attendance/supervisor?status=absent">{{ __('attendance.tab_absent') }} · {{ $absentCount ?? 0 }}</a>
        </li>
    </ul>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm">
                        <option>{{ __('attendance.all_my_students') }}</option>
                    </select>
                    <select class="form-select form-select-sm">
                        <option>{{ __('attendance.week_filter') }}</option>
                    </select>
                </div>
            </div>

            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>{{ __('attendance.col_student') }}</th>
                        <th>{{ __('attendance.col_date') }}</th>
                        <th>{{ __('attendance.col_check_in') }}</th>
                        <th>{{ __('attendance.col_check_out') }}</th>
                        <th>{{ __('attendance.col_hours') }}</th>
                        <th>{{ __('attendance.col_decision') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances ?? [] as $attendance)
                        <tr>
                            <td>#{{ $attendance->placement_id }}</td> {{-- TEMPORARY: real student name needs Auth and Placements API, not built yet --}}
                            <td>{{ $attendance->date }}</td>
                            <td>{{ $attendance->check_in }}</td>
                            <td>{{ $attendance->check_out }}</td>
                            <td>{{ $attendance->hours }}</td>
                            <td>
                                @if($attendance->status === 'pending')
                                    <form action="/attendance/{{ $attendance->id }}/status?status={{ $activeStatus }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-sm btn-primary">{{ __('attendance.btn_approve') }}</button>
                                    </form>
                                    <form action="/attendance/{{ $attendance->id }}/status?status={{ $activeStatus }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="absent">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('attendance.btn_mark_absent') }}</button>
                                    </form>
                                @elseif((int) $editId === $attendance->id)
                                    <form action="/attendance/{{ $attendance->id }}/status?status={{ $activeStatus }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-sm btn-primary">{{ __('attendance.btn_approve') }}</button>
                                    </form>
                                    <form action="/attendance/{{ $attendance->id }}/status?status={{ $activeStatus }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="absent">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('attendance.btn_mark_absent') }}</button>
                                    </form>
                                    <a href="/attendance/supervisor?status={{ $activeStatus }}" class="btn btn-sm btn-link">{{ __('attendance.btn_cancel') }}</a>
                                @else
                                    <span class="badge {{ $attendance->status === 'approved' ? 'text-bg-success' : 'text-bg-danger' }}">
                                        {{ __('attendance.status_' . $attendance->status) }}
                                    </span>
                                    <a href="/attendance/supervisor?status={{ $activeStatus }}&edit={{ $attendance->id }}" class="btn btn-sm btn-link">{{ __('attendance.btn_edit') }}</a>
                                @endif

                                @if($attendance->status === 'absent' && $attendance->excuse)
                                    <div class="small text-muted mt-1">
                                        {{ __('attendance.excuse_label') }}: {{ $attendance->excuse }}
                                        @if($attendance->excuse_file)
                                            — <a href="{{ asset('storage/' . $attendance->excuse_file) }}" target="_blank">{{ __('attendance.excuse_file_label') }}</a>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">{{ __('attendance.no_records') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
