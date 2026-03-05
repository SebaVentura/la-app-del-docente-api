<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Clase;

class ClasePolicy
{
    public function view(User $user, Clase $clase): bool
    {
        return $clase->curso && $clase->curso->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Clase $clase): bool
    {
        return $clase->curso && $clase->curso->user_id === $user->id;
    }

    public function delete(User $user, Clase $clase): bool
    {
        return $clase->curso && $clase->curso->user_id === $user->id;
    }
}
