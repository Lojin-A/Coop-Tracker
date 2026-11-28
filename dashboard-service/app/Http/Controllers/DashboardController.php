<?php

namespace App\Http\Controllers;

use App\Services\AttendanceApi;
use App\Services\StatsService;
use App\Services\ReportsApi;
use App\Services\AuthApi;

class DashboardController extends Controller
{
       public function coordinator(StatsService $stats, ReportsApi $reports, AuthApi $auth)
    {
        return view('dashboard.coordinator', [
            'stats' => $stats->coordinator($reports->late(), $auth->stats()),
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