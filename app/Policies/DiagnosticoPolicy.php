<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Diagnostico;

class DiagnosticoPolicy
{
    public function view(User $user, Diagnostico $diagnostico): bool
    {
        return $diagnostico->curso && $diagnostico->curso->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Diagnostico $diagnostico): bool
    {
        return $diagnostico->curso && $diagnostico->curso->user_id === $user->id;
    }

    public function delete(User $user, Diagnostico $diagnostico): bool
    {
        return $diagnostico->curso && $diagnostico->curso->user_id === $user->id;
    }
}
