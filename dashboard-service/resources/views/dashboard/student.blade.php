@extends('layouts.app')

@section('role', 'Student · ' . $stats['company'])
@section('title', 'Welcome back, ' . $stats['name'])

@section('sidebar')
    @include('partials.sidemenu-student')
@endsection

@section('actions')
    <button type="button" class="btn-quiet px-3">EN | العربية</button>
@endsection

@section('content')

    {{-- Progress + today --}}
    <div class="row g-3 mb-4">

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="mb-3">Training progress</h2>

                    <div class="d-flex align-items-baseline gap-2 mb-3">
                        <span class="num fw-bold" style="font-size: 44px;">{{ $stats['hours'] }}</span>
                        <span class="text-muted-2" style="font-size: 16px;">of {{ $stats['required'] }} hours</span>
                    </div>

                    <div class="progress-track mb-2">
                        <div class="progress-fill" style="width: {{ $stats['percent'] }}%;"></div>
                    </div>

                    <div class="d-flex justify-content-between text-muted-2" style="font-size: 14px;">
                        <span>{{ $stats['percent'] }}% complete</span>
                        <span>Ends {{ $stats['end_date'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card-navy h-100">
                <div class="card-body d-flex flex-column justify-content-between h-100">
                    <div class="mb-3">
                        <h2 class="mb-1">Today</h2>
                        <p class="sub mb-0">{{ $stats['today'] }}</p>
                    </div>
                    <button type="button" class="btn-on-navy">Check out</button>
                </div>
            </div>
        </div>

    </div>

    {{-- Chart + reports --}}
    <div class="row g-3">

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="mb-3">Approved hours per week</h2>

                    <div class="chart-cols">
                        @foreach ($stats['weeks'] as $week)
                            <div class="chart-col">
                                <span class="num" style="font-size: 12px;">{{ $week['value'] }}</span>
                                <div class="chart-bar" style="height: {{ $week['height'] }};"></div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex gap-2 px-1 mt-1">
                        @foreach ($stats['weeks'] as $week)
                            <div class="flex-fill text-center text-muted-2" style="font-size: 12px;">{{ $week['label'] }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="mb-0">My weekly reports</h2>
                        <a href="#" class="fw-semibold text-decoration-none" style="font-size: 14px;">+ Submit week {{ $stats['next_week'] }}</a>
                    </div>

                    @foreach ($stats['reports'] as $report)
                        <div class="list-row d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">{{ $report['week'] }}</span>
                            <span class="{{ $report['pill'] }}">{{ $report['status'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

@endsection