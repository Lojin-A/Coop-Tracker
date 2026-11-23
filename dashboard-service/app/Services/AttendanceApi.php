<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AttendanceApi
{
    public function stats()
    {
        try {
            $response = Http::timeout(3)
                ->get(config('services.attendance.url') . '/api/stats/attendance');

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            // the attendance service is not running
        }

        return null;
    }
}