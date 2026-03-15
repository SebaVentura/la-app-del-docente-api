<?php

namespace App\Policies;

use App\Models\Trayectoria;
use App\Models\User;

class TrayectoriaPolicy
{
    public function view(User $user, Trayectoria $trayectoria): bool
    {
        return $trayectoria->curso && $trayectoria->curso->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Trayectoria $trayectoria): bool
    {
        return $trayectoria->curso && $trayectoria->curso->user_id === $user->id;
    }

    public function delete(User $user, Trayectoria $trayectoria): bool
    {
        return $trayectoria->curso && $trayectoria->curso->user_id === $user->id;
    }
}
