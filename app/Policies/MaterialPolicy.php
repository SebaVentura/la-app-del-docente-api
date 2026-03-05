<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Material;

class MaterialPolicy
{
    public function view(User $user, Material $material): bool
    {
        return $material->curso && $material->curso->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Material $material): bool
    {
        return $material->curso && $material->curso->user_id === $user->id;
    }

    public function delete(User $user, Material $material): bool
    {
        return $material->curso && $material->curso->user_id === $user->id;
    }
}
