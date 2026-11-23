@extends('layouts.app')

@section('role', 'Company Supervisor · ' . $stats['company'])
@section('title', 'My trainees')

@section('sidebar')
    @include('partials.sidemenu-supervisor')
@endsection

@section('actions')
    <button type="button" class="btn-quiet px-3">EN | العربية</button>
@endsection

@section('content')
    @if ($stats['live'])
        <p class="mb-3" style="font-size: 13px;">
            <span class="badge-ok">● Live</span>
            <span class="text-muted-2">connected to the attendance service</span>
        </p>
    @else
        <p class="mb-3" style="font-size: 13px;">
            <span class="badge-pending">● Offline</span>
            <span class="text-muted-2">attendance service not reachable — showing sample data</span>
        </p>
    @endif
    {{-- KPI cards --}}
    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3 mb-4">
        @foreach ($stats['kpis'] as $kpi)
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <p class="kpi-label mb-1">{{ $kpi['label'] }}</p>
                        <p class="kpi-value mb-1">{{ $kpi['value'] }}</p>
                        <p class="kpi-note mb-0 {{ $kpi['class'] }}">{{ $kpi['note'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Attendance waiting for approval --}}
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="mb-3">Attendance waiting for approval</h2>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Date</th>
                            <th>Check in</th>
                            <th>Check out</th>
                            <th>Hours</th>
                            <th>Decision</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stats['pending'] as $row)
                            <tr>
                                <td>{{ $row['student'] }}</td>
                                <td>{{ $row['date'] }}</td>
                                <td class="num">{{ $row['in'] }}</td>
                                <td class="num">{{ $row['out'] }}</td>
                                <td class="num">{{ $row['hours'] }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button type="button" class="btn-accent px-3" style="min-height: 36px;">Approve</button>
                                        <button type="button" class="btn-reject px-3" style="min-height: 36px;">Reject</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Bars + reports --}}
    <div class="row g-3">

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="mb-3">Hours completed per student (of 640)</h2>

                    @foreach ($stats['students'] as $student)
                        <div class="d-flex align-items-center gap-2 mb-2" style="font-size: 14px;">
                            <span style="width: 110px;">{{ $student['name'] }}</span>
                            <span class="flex-fill bar-track">
                                <span class="d-block bar-fill" style="width: {{ $student['width'] }};"></span>
                            </span>
                            <span class="num text-end" style="width: 44px;">{{ $student['count'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="mb-3">Weekly reports to review</h2>

                    @foreach ($stats['reports'] as $report)
                        <div class="list-row d-flex justify-content-between align-items-center gap-2 mb-2 {{ $report['is_new'] ? 'is-new' : '' }}">
                            <div class="d-flex align-items-center gap-2">
                                @if ($report['is_new'])
                                    <span class="dot-new"></span>
                                @else
                                    <span style="width: 10px;"></span>
                                @endif
                                <div>
                                    <div class="d-flex align-items-center gap-2 {{ $report['is_new'] ? 'fw-bold' : 'fw-semibold' }}">
                                        {{ $report['student'] }} · {{ $report['week'] }}
                                        @if ($report['is_new'])
                                            <span class="badge-new">New</span>
                                        @endif
                                    </div>
                                    <div class="text-muted-2" style="font-size: 13px;">Submitted {{ $report['date'] }}</div>
                                </div>
                            </div>
                            <a href="#" class="fw-semibold text-decoration-none" style="font-size: 14px;">Review</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

@endsection