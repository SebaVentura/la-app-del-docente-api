<?php

namespace App\Policies;

use App\Models\DeclaracionJurada;
use App\Models\User;

class DeclaracionJuradaPolicy
{
    public function view(User $user, DeclaracionJurada $declaracionJurada): bool
    {
        return $declaracionJurada->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, DeclaracionJurada $declaracionJurada): bool
    {
        return $declaracionJurada->user_id === $user->id;
    }

    public function delete(User $user, DeclaracionJurada $declaracionJurada): bool
    {
        return $declaracionJurada->user_id === $user->id;
    }
}
