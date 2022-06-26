<?php

namespace App\Policies;

use App\User;
use App\item;
use App\Atributo;
use App\Grupo;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any items.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the item.
     *
     * @param  \App\User  $user
     * @param  \App\item  $item
     * @return mixed
     */
    public function view(User $user, item $item)
    {
        $atributos=Atributo::findOrFail($item->id_atributos);
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

  

