<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyReport extends Model
{
    protected $fillable = [
        'placement_id', 'week_no', 'content',
        'file_path', 'status', 'feedback',
    ];
}

