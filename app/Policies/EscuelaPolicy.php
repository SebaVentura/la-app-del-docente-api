<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Escuela;

class EscuelaPolicy
{
    public function view(User $user, Escuela $escuela): bool
    {
        return $escuela->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Escuela $escuela): bool
    {
        return $escuela->user_id === $user->id;
    }

    public function delete(User $user, Escuela $escuela): bool
    {
        return $escuela->user_id === $user->id;
    }
}
