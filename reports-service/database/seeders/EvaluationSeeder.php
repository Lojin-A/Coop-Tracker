<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EvaluationSeeder extends Seeder
{
    public function run(): void
    {
        for ($p = 1; $p <= 4; $p++) {          // placements 5 and 6 have no evaluation yet
            $scores = [
                'technical_skills' => rand(3, 5),
                'teamwork'         => rand(3, 5),
                'communication'    => rand(3, 5),
                'punctuality'      => rand(3, 5),
                'initiative'       => rand(3, 5),
            ];

            DB::table('evaluations')->insert(array_merge($scores, [
                'placement_id' => $p,
                'total'        => array_sum($scores),
                'comments'     => 'Test evaluation for placement '.$p,
                'status'       => 'submitted',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ]));
        }
    }
}

