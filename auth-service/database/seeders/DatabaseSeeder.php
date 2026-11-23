<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Placement;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Coordinator',
            'email' => 'coord@test.com',
            'password' => 'password',
            'role' => 'coordinator',
        ]);

        $companies = [];
        foreach (['Aramco', 'SABIC', 'Yansab'] as $name) {
            $companies[] = Company::create([
                'name' => $name,
                'city' => 'Yanbu',
                'field' => 'Engineering',
                'seats' => 10,
            ]);
        }

        $supervisors = [];
        foreach ($companies as $i => $company) {
            $supervisors[] = User::create([
                'name' => 'Supervisor ' . ($i + 1),
                'email' => 'sup' . ($i + 1) . '@test.com',
                'password' => 'password',
                'role' => 'supervisor',
            ]);
        }

        for ($i = 1; $i <= 15; $i++) {
            $idx = $i % 3;

            $student = User::create([
                'name' => 'Student ' . $i,
                'email' => 'stu' . $i . '@test.com',
                'password' => 'password',
                'role' => 'student',
            ]);

            Placement::create([
                'student_id' => $student->id,
                'supervisor_id' => $supervisors[$idx]->id,
                'company_id' => $companies[$idx]->id,
                'start_date' => '2026-10-01',
                'end_date' => '2027-03-01',
                'required_weeks' => 24,
                'status' => 'active',
            ]);
        }
    }
}