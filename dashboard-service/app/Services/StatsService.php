<?php

namespace App\Services;

class StatsService
{
    public function coordinator()
    {
        return [
            'kpis' => [
                ['label' => 'Active students',     'value' => '48',  'note' => '+6 this term',      'color' => 'accent'],
                ['label' => 'Partner companies',   'value' => '12',  'note' => '3 new',             'color' => 'accent'],
                ['label' => 'Avg hours completed', 'value' => '312', 'note' => 'of 640 required',   'color' => 'muted'],
                ['label' => 'Late reports',        'value' => '7',   'note' => 'needs follow-up',   'color' => 'warn'],
            ],
            'companies'   => $this->companies(),
            'weeks'       => $this->weeks(),
            'line_points' => $this->linePoints(),
            'late' => [
                ['student' => 'Sara Khan',    'company' => 'SABIC',   'week' => 'Week 6', 'days' => '3 days'],
                ['student' => 'Noura Ali',    'company' => 'RCJY',    'week' => 'Week 6', 'days' => '2 days'],
                ['student' => 'Maha Otaibi',  'company' => 'Marafiq', 'week' => 'Week 5', 'days' => '8 days'],
                ['student' => 'Reem Harbi',   'company' => 'Aramco',  'week' => 'Week 6', 'days' => '1 day'],
            ],
        ];
    }

    private function companies()
    {
        $rows = [
            ['SABIC', 9], ['RCJY', 8], ['Aramco', 7],
            ['Marafiq', 6], ['Yanbu Cement', 5], ['Others', 13],
        ];

        $max = 13;
        $out = [];

        foreach ($rows as $row) {
            $out[] = [
                'name'  => $row[0],
                'count' => $row[1],
                'width' => round($row[1] / $max * 100) . '%',
            ];
        }

        return $out;
    }

    private function hours()
    {
        return [32, 35, 34, 38, 36, 39, 37, 40];
    }

    private function weeks()
    {
        $out = [];

        foreach ($this->hours() as $i => $value) {
            $out[] = [
                'x'     => round(60 + $i * (460 / 7)),
                'y'     => round(190 - ($value - 28) / 14 * 150),
                'label' => 'W' . ($i + 1),
            ];
        }

        return $out;
    }

    private function linePoints()
    {
        $points = [];

        foreach ($this->weeks() as $week) {
            $points[] = $week['x'] . ',' . $week['y'];
        }

        return implode(' ', $points);
    }
}