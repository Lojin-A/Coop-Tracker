<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'placement_id', 'date', 'check_in', 'check_out', 'hours', 'status', 'excuse', 'excuse_file',
    ];
}
