@extends('layouts.app')

@section('role', 'Coordinator')
@section('title', 'Training overview')

@section('sidebar')
    @include('partials.sidemenu')
@endsection

@section('actions')
    <button type="button" class="btn-quiet px-3">EN | العربية</button>
    <button type="button" class="btn-accent px-3">+ New placement</button>
@endsection

@section('content')
    <p class="mb-3 d-flex flex-wrap gap-3" style="font-size: 13px;">
        @foreach ($stats['services'] as $service)
            <span>
                <span class="{{ $service['live'] ? 'badge-ok' : 'badge-pending' }}">
                    ● {{ $service['live'] ? 'Live' : 'Offline' }}
                </span>
                <span class="text-muted-2">{{ $service['name'] }}</span>
            </span>
        @endforeach
    </p>

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

    {{-- Charts --}}
    <div class="row g-3 mb-4">

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="mb-3">Students per company</h2>

                    @foreach ($stats['companies'] as $company)
                        <div class="d-flex align-items-center gap-2 mb-2" style="font-size: 14px;">
                            <span style="width: 120px;">{{ $company['name'] }}</span>
                            <span class="flex-fill bar-track">
                                <span class="d-block bar-fill" style="width: {{ $company['width'] }};"></span>
                            </span>
                            <span class="num text-end" style="width: 32px;">{{ $company['count'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="mb-3">Average hours logged per week</h2>

                    <svg viewBox="0 0 560 220" role="img"
                         aria-label="Average weekly hours rising from 32 to 40 over 8 weeks"
                         style="width: 100%; height: auto;">

                        <line x1="40" y1="190" x2="540" y2="190" stroke="#CBD5E0" stroke-width="1"></line>
                        <line x1="40" y1="115" x2="540" y2="115" stroke="#EDF2F7" stroke-width="1"></line>
                        <line x1="40" y1="40"  x2="540" y2="40"  stroke="#EDF2F7" stroke-width="1"></line>

                        <text x="32" y="194" font-size="12" fill="#718096" text-anchor="end">28</text>
                        <text x="32" y="119" font-size="12" fill="#718096" text-anchor="end">35</text>
                        <text x="32" y="44"  font-size="12" fill="#718096" text-anchor="end">42</text>

                        <polyline points="{{ $stats['line_points'] }}" fill="none"
                                  stroke="#35B8A6" stroke-width="3" stroke-linejoin="round"></polyline>

                        @foreach ($stats['weeks'] as $week)
                            <circle cx="{{ $week['x'] }}" cy="{{ $week['y'] }}" r="4"
                                    fill="#FFFFFF" stroke="#35B8A6" stroke-width="2"></circle>
                            <text x="{{ $week['x'] }}" y="212" font-size="12"
                                  fill="#718096" text-anchor="middle">{{ $week['label'] }}</text>
                        @endforeach
                    </svg>
                </div>
            </div>
        </div>

    </div>

    {{-- Late reports --}}
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">Late weekly reports</h2>
                <a href="#" class="fw-semibold text-decoration-none" style="font-size: 14px;">View all reports</a>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Company</th>
                            <th>Week</th>
                            <th>Days late</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stats['late'] as $row)
                            <tr>
                                <td>{{ $row['student'] }}</td>
                                <td>{{ $row['company'] }}</td>
                                <td>{{ $row['week'] }}</td>
                                <td><span class="badge-late">{{ $row['days'] }}</span></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Send reminder</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted-2">No late reports</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection