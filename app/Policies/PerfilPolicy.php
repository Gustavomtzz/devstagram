<?php

namespace App\Policies;

use App\Models\User;

class PerfilPolicy
{
    /**
     * Determine whether the user can update the model.
     *El primer parametro User $user, laravel pasa AUTOMATICAMENTE el USUARIO AUTENTICADO ACTUALMENTE
     */
    public function update(User $user, User $perfilUser): bool
    {
        return $user->id === $perfilUser->id;
    }
}
