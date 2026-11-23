<?php

namespace App\Services;

class StatsService
{
    public function coordinator()
    {
        return [
            'kpis' => [
                ['label' => 'Active students',     'value' => '48',  'note' => '+6 this term',    'class' => 'text-accent'],
                ['label' => 'Partner companies',   'value' => '12',  'note' => '3 new',           'class' => 'text-accent'],
                ['label' => 'Avg hours completed', 'value' => '312', 'note' => 'of 640 required', 'class' => 'text-muted-2'],
                ['label' => 'Late reports',        'value' => '7',   'note' => 'needs follow-up', 'class' => 'text-warn'],
            ],
            'companies'   => $this->bars([
                ['SABIC', 9], ['RCJY', 8], ['Aramco', 7],
                ['Marafiq', 6], ['Yanbu Cement', 5], ['Others', 13],
            ], 13),
            'weeks'       => $this->weeks(),
            'line_points' => $this->linePoints(),
            'late' => [
                ['student' => 'Sara Khan',   'company' => 'SABIC',   'week' => 'Week 6', 'days' => '3 days'],
                ['student' => 'Noura Ali',   'company' => 'RCJY',    'week' => 'Week 6', 'days' => '2 days'],
                ['student' => 'Maha Otaibi', 'company' => 'Marafiq', 'week' => 'Week 5', 'days' => '8 days'],
                ['student' => 'Reem Harbi',  'company' => 'Aramco',  'week' => 'Week 6', 'days' => '1 day'],
            ],
        ];
    }

    public function supervisor()
    {
        return [
            'company' => 'SABIC',
            'kpis' => [
                ['label' => 'My students',       'value' => '6', 'note' => 'all active',       'class' => 'text-accent'],
                ['label' => 'Pending approvals', 'value' => '9', 'note' => 'attendance days',  'class' => 'text-warn'],
                ['label' => 'Reports to review', 'value' => '4', 'note' => '2 new',            'class' => 'text-danger-2'],
                ['label' => 'Evaluations due',   'value' => '2', 'note' => 'end of training',  'class' => 'text-muted-2'],
            ],
            'pending' => [
                ['student' => 'Sara Khan',   'date' => 'Sun 4 Oct', 'in' => '07:58', 'out' => '15:02', 'hours' => '7.0'],
                ['student' => 'Noura Ali',   'date' => 'Sun 4 Oct', 'in' => '08:10', 'out' => '15:00', 'hours' => '6.8'],
                ['student' => 'Maha Otaibi', 'date' => 'Mon 5 Oct', 'in' => '07:55', 'out' => '14:30', 'hours' => '6.6'],
                ['student' => 'Reem Harbi',  'date' => 'Mon 5 Oct', 'in' => '09:20', 'out' => '15:00', 'hours' => '5.7'],
            ],
            'students' => $this->bars([
                ['Sara Khan', 410], ['Noura Ali', 372], ['Maha Otaibi', 340],
                ['Reem Harbi', 296], ['Lama Zahrani', 255], ['Hind Qahtani', 188],
            ], 640),
            'reports' => [
                ['student' => 'Noura Ali',   'week' => 'Week 7', 'date' => 'today, 09:12', 'is_new' => true],
                ['student' => 'Lama Zahrani','week' => 'Week 7', 'date' => 'today, 08:40', 'is_new' => true],
                ['student' => 'Sara Khan',   'week' => 'Week 7', 'date' => 'Thu 22 Oct',   'is_new' => false],
                ['student' => 'Reem Harbi',  'week' => 'Week 6', 'date' => 'Thu 15 Oct',   'is_new' => false],
            ],
        ];
    }

    private function bars($rows, $max)
    {
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