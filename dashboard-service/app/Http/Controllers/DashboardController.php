<?php

namespace App\Http\Controllers;

use App\Services\AttendanceApi;
use App\Services\StatsService;

class DashboardController extends Controller
{
    public function coordinator(StatsService $stats)
    {
        return view('dashboard.coordinator', [
            'stats' => $stats->coordinator(),
        ]);
    }

    public function supervisor(StatsService $stats, AttendanceApi $attendance)
    {
        return view('dashboard.supervisor', [
            'stats' => $stats->supervisor($attendance->stats()),
        ]);
    }

    public function student(StatsService $stats)
    {
        return view('dashboard.student', [
            'stats' => $stats->student(),
        ]);
    }
}