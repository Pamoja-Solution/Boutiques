<?php

namespace App\Policies;

use App\Models\User;

class MedicamentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function create(User $user)
    {
        return $user->isGerant(); // ou une autre condition
    }
}
