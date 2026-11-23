<?php

namespace App\Http\Controllers;

use App\Services\StatsService;

class DashboardController extends Controller
{
    public function coordinator(StatsService $stats)
    {
        return view('dashboard.coordinator', [
            'stats' => $stats->coordinator(),
        ]);
    }

    public function supervisor(StatsService $stats)
    {
        return view('dashboard.supervisor', [
            'stats' => $stats->supervisor(),
        ]);
    }
}