<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'city', 'field', 'seats'];
    public function placements()
    {
        return $this->hasMany(Placement::class);
    }
}
