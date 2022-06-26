<?php

namespace App\Policies;

use App\User;
use App\Grupo;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservaPolicy
{
    use HandlesAuthorization;

    /**
     * Method to authorize the user do manage "reservas".
     *
     * @return void
     */
    public function gerir(User $user)
        {  
            
         return Grupo::findOrFail($user->grupo_id)->gerirReservas;   
        }

    public function reservar(User $user)
        {  
            
         return Grupo::findOrFail($user->grupo_id)->reservar;   
        }
}
