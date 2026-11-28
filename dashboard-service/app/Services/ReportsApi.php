<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ReportsApi
{
    public function late()
    {
        try {
            $response = Http::timeout(3)
                ->get(config('services.reports.url') . '/api/reports/late');

            if ($response->successful()) {
                return $response->json('data', []);
            }
        } catch (\Exception $e) {
            // the reports service is not running
        }

        return null;
    }
}