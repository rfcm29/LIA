<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Grupo;

class GrupoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function gerir(User $user)
    {
        return Grupo::findOrFail($user->grupo_id)->gerirGrupos;  
    }
}
