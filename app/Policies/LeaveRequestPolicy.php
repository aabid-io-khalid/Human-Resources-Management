<?php

namespace App\Policies;

use App\Models\User;

class LeaveRequestPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function approve(User $user)
{
    return $user->role === 'manager' || $user->role === 'HR';
}

}
