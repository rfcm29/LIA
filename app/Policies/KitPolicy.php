<?php

namespace App\Policies;

use App\Kit;
use App\User;
use App\Grupo;
use Illuminate\Auth\Access\HandlesAuthorization;

class KitPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any kits.
     *
     * @param  \App\Kit  $kit
     * @return mixed
     */
    public function view(User $user,Kit $kit)
    {
        $atributos=Atributo::findOrFail($kit->id_atributos);
        if($atributos->visivel===1){
            return true;
        }else{
            $grupo=Grupo::findOrFail($user->grupo_id);
            return $grupo->gerirItemsKits===1;
        }
    }
    public function gerir(User $user)
        {  
            
         return Grupo::findOrFail($user->grupo_id)->gerirItemsKits;   
        }
        
}
