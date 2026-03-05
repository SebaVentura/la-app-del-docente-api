<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Planificacion;

class PlanificacionPolicy
{
    public function view(User $user, Planificacion $planificacion): bool
    {
        return $planificacion->curso && $planificacion->curso->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Planificacion $planificacion): bool
    {
        return $planificacion->curso && $planificacion->curso->user_id === $user->id;
    }

    public function delete(User $user, Planificacion $planificacion): bool
    {
        return $planificacion->curso && $planificacion->curso->user_id === $user->id;
    }
}
