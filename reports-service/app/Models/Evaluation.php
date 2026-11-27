<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'placement_id', 'technical_skills', 'teamwork', 'communication',
        'punctuality', 'initiative', 'total', 'comments', 'status',
    ];
}
