<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Alumno;

class AlumnoPolicy
{
    public function view(User $user, Alumno $alumno): bool
    {
        return $alumno->curso && $alumno->curso->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Alumno $alumno): bool
    {
        return $alumno->curso && $alumno->curso->user_id === $user->id;
    }

    public function delete(User $user, Alumno $alumno): bool
    {
        return $alumno->curso && $alumno->curso->user_id === $user->id;
    }
}
