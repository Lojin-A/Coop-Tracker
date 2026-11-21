@extends('layouts.app')

@section('title', __('attendance.my_attendance_title'))

@section('sidebar-links')
    <li class="nav-item"><a class="nav-link active" href="#">{{ __('attendance.sidebar_my_attendance') }}</a></li>
    <li class="nav-item"><a class="nav-link" href="#">{{ __('attendance.sidebar_weekly_reports') }}</a></li>
    <li class="nav-item"><a class="nav-link" href="#">{{ __('attendance.sidebar_my_evaluation') }}</a></li>
@endsection

@section('content')
    @if(session('excuse_submitted'))
        <div class="alert alert-success" id="excuse-submitted-alert">{{ __('attendance.excuse_submitted_msg') }}</div>
        <script>
            setTimeout(function () {
                document.getElementById('excuse-submitted-alert').style.display = 'none';
            }, 4000);
        </script>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-5">
            <div class="card text-bg-dark h-100">
                <div class="card-body">
                    @if(!$today)
                        <p class="mb-0 text-white-50">{{ __('attendance.no_records') }}</p>
                    @elseif(!$today->check_out)
                        <p class="mb-1">{{ __('attendance.not_checked_out') }}</p>
                        <h5>{{ __('attendance.status_in_progress') }}</h5>
                        <button class="btn btn-light w-100 mt-3">{{ __('attendance.check_out_btn') }}</button>
                    @else
                        <p class="mb-1">{{ __('attendance.today_complete') }}</p>
                        <h5>{{ __('attendance.status_' . $today->status) }}</h5>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">{{ __('attendance.approved_days') }}</p>
                    <h3>{{ $approvedDays ?? 0 }}</h3>
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
                        <th>{{ __('attendance.col_excuse') }}</th>
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
                            <td>
                                @if($attendance->status !== 'absent')
                                    <span class="text-muted">—</span>
                                @elseif((int) $editExcuseId === $attendance->id)
                                    <form action="/attendance/{{ $attendance->id }}/excuse" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <textarea name="excuse" class="form-control form-control-sm mb-2" rows="2" placeholder="{{ __('attendance.excuse_placeholder') }}" required>{{ $attendance->excuse }}</textarea>
                                        <input type="file" name="excuse_file" class="form-control form-control-sm mb-2" accept=".pdf,.jpg,.jpeg,.png">
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-sm btn-primary">{{ __('attendance.submit_excuse_btn') }}</button>
                                            <a href="/attendance/student?placement_id={{ $placementId }}" class="btn btn-sm btn-link">{{ __('attendance.btn_cancel') }}</a>
                                        </div>
                                    </form>
                                @else
                                    @if($attendance->excuse)
                                        <div class="small">{{ $attendance->excuse }}</div>
                                        @if($attendance->excuse_file)
                                            <a href="{{ asset('storage/' . $attendance->excuse_file) }}" target="_blank" class="small d-block">{{ __('attendance.excuse_file_label') }}</a>
                                        @endif
                                    @else
                                        <span class="text-muted small">{{ __('attendance.no_excuse_yet') }}</span>
                                    @endif
                                    <a href="/attendance/student?placement_id={{ $placementId }}&edit_excuse={{ $attendance->id }}" class="btn btn-sm btn-link p-0">
                                        {{ $attendance->excuse ? __('attendance.btn_edit') : __('attendance.submit_excuse_btn') }}
                                    </a>
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
