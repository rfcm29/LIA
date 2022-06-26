<?php

namespace App\Policies;

use App\Categoria;
use App\User;
use App\Grupo;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoriaPolicy
{
    use HandlesAuthorization;


    public function gerir(User $user)
        {  
        return Grupo::findOrFail($user->grupo_id)->gerirCategorias;   
        }
}
