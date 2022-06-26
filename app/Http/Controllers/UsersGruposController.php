<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Grupo;


class UsersGruposController extends Controller
{   
    /**
     * Returns a view with all users and group information
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function allUsers(){
        $this->authorize('gerir',User::class);
        $users = User::all();
        $allUsers = [];
        foreach ($users as $user) {
            $allUsers[]=[$user,Grupo::findOrFail($user->grupo_id)];
            
        }
        
        return view('.users.index',compact('allUsers'));
    }

    /**
     * Puts User in a different Group
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function insertUser($user_id,$id)
    {
        $this->authorize('gerir',User::class);
        $user = User::findOrFail($user_id);
        $grupo = Grupo::findOrFail($id);
        
        if(!Grupo::findOrFail($user->grupo_id)->admin===true){
            $user->update([
                'grupo_id'=>$grupo->id
            ]);
            $user->save();

        } else if(Grupo::findOrFail($user->grupo_id)->admin===true) {
           
            return redirect('/grupos/'.$id)->with('message','O Admin não pode ser inserido');
        }

        return;
    }

    /**
     * Returns all Users from a group
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function allFromGroup($id){
        $this->authorize('gerir',User::class);
        $user = User::all();
        foreach($users as $user){
            if (Grupo::findOrFail($user->grupo_id)->id===$id) {
                $usersGroup[]=$user;
                
            }
        }
        return $usersGroup;
    }


    public function edit(Request $request, $id){
        $this->authorize('gerir', User::class);
        $user =User::findOrFail($id);
        $grupos = Grupo::all();

        return view('.users.edit',compact('user','grupos'));        

    }

    public function update(Request $request, $id){
        $this->authorize('gerir', User::class);
        $request->validate([
            'grupo_id' => 'required'
        ]);
        $user = User::findOrFail($id);
        $grupoAntigo= Grupo::findOrFail($user->grupo_id);
        $grupoTecnico = Grupo::findOrFail(auth()->user()->grupo_id);
        $grupoAInserir = Grupo::findOrFail(request('grupo_id'));
        if($grupoTecnico->admin && $grupoAInserir->admin){
            $user->update([
                'grupo_id'=> $grupoAInserir->id
            ]);
            $user->save();
        }else if(!$grupoTecnico->admin && $grupoAInserir->admin){
            return redirect('/users/'.$id)->with('message','Só os administradores podem inserir utilizadores neste grupo');

        }else if(!$grupoTecnico->admin && $grupoAntigo->admin){
            return redirect('/users/'.$id)->with('message','Só os administradores podem editar este utilizador');
        }
        else {
            $user->update([
                'grupo_id'=> $grupoAInserir->id
            ]);
            $user->save();
        }
        


        $users = User::all();
        $allUsers = [];
        foreach ($users as $user) {
            $allUsers[]=[$user,Grupo::findOrFail($user->grupo_id)];
            
        }
        return view('.users.index',compact('allUsers'));  
        

    }
}
