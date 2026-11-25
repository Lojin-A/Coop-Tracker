<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class WeeklyReportSeeder extends Seeder
{
    public function run(): void
    {
        for ($p = 1; $p <= 6; $p++) {          // 6 test placements
            for ($w = 1; $w <= 4; $w++) {      // 4 weeks each
                DB::table('weekly_reports')->insert([
                    'placement_id' => $p,
                    'week_no'      => $w,
                    'content'      => 'Week '.$w.' report: '.Str::random(20),
                    'status'       => $w < 4 ? 'reviewed' : 'submitted',
                    'feedback'     => $w < 4 ? 'Good work, keep going.' : null,
                    'created_at'   => Carbon::now(),
                    'updated_at'   => Carbon::now(),
                ]);
            }
        }
    }
}
