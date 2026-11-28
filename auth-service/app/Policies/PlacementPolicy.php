<?php

namespace App\Policies;

use App\Models\Placement;
use App\Models\User;

class PlacementPolicy
{
    // A coordinator can view any placement; a student or supervisor only their own
    public function view(User $user, Placement $placement): bool
    {
        return $user->role === 'coordinator'
            || ($user->role === 'student' && $placement->student_id === $user->id)
            || ($user->role === 'supervisor' && $placement->supervisor_id === $user->id);
    }
}