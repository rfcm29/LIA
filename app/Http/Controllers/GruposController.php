<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Grupo;
use App\User;
use App\Http\Controllers\UsersGruposController;
use Illuminate\Support\Facades\DB;



class GruposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('gerir',Grupo::Class);
        $grupos=Grupo::all();
        $newgrupos = [];
        foreach($grupos as $grupo){
            $usersCount = User::countUsers($grupo->id);
            $newgrupos[]= ['grupo'=>$grupo,'qtd'=>$usersCount];
        }
        return view('grupos.index', compact('newgrupos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $this->authorize('gerir',Grupo::Class);
        return view('grupos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('gerir',Grupo::Class);
        request()->validate([
            "name"=> "unique:grupos|required",
            "gerirReservas"=> 'required',
            "gerirItemsKits"=> 'required',
            "gerirGrupos"=> 'required',
            "gerirCategorias"=> 'required',
            "gerirCentros"=> 'required',
            "gerirUsers"=> 'required',
            "reservar"=> 'required'
        ]);

        $grupo = Grupo::create([
            'name'=> request('name'),
            'admin'=>false,
            "gerirReservas"=> request('gerirReservas'),
            "gerirItemsKits"=> request('gerirItemsKits'),
            "gerirGrupos"=> request('gerirGrupos'),
            "gerirCategorias"=> request('gerirCategorias'),
            "gerirCentros"=> request('gerirCentros'),
            "gerirUsers"=> request('gerirUsers'),
            "reservar"=> request('reservar')
            
        ]);

        $grupo->save();

        return redirect(('/grupos/' . $grupo->id));
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $this->authorize('gerir',Grupo::Class);
        $grupo= Grupo::findOrFail($id);
        
        $usersNotGroup = DB::table("users")
        ->where("grupo_id", "<>", $id)
        ->orWhere("grupo_id","=",null)
        ->get();

        $usersGroup = DB::table("users")
            ->where("grupo_id", "=", $id)
            ->get();
        
        return view('grupos.show', ['grupo' => $grupo,'users' => $usersNotGroup,'usersGroup'=> $usersGroup]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('gerir',Grupo::Class);
        $grupo=Grupo::findOrFail($id);
        
        return view('grupos.edit', compact('grupo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->authorize('gerir',Grupo::Class);
        $grupo = Grupo::findOrFail($id);
        request()->validate([
            'name'=> 'sometimes|required',
            "gerirReservas"=> 'sometimes|required',
            "gerirItemsKits"=> 'sometimes|required',
            "gerirGrupos"=> 'sometimes|required',
            "gerirCategorias"=> 'sometimes|required',
            "gerirCentros"=> 'sometimes|required',
            "gerirUsers"=> 'sometimes|required',
            "reservar"=> 'sometimes|required'
        ]);

        $grupo->update([
            'name'=> request('name'),
            'admin'=>false,
            "gerirReservas"=> request('gerirReservas'),
            "gerirItemsKits"=> request('gerirItemsKits'),
            "gerirGrupos"=> request('gerirGrupos'),
            "gerirCategorias"=> request('gerirCategorias'),
            "gerirCentros"=> request('gerirCentros'),
            "gerirUsers"=> request('gerirUsers'),
            "reservar"=> request('reservar')
            
        ]);
        $grupo->save();
        return redirect(('/grupos/' . $grupo->id));
        
        
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('gerir',Grupo::Class);
        //Grupo::findOrFail($id)->delete();
        return redirect('/grupos');
    }

    public function insertUser($user_id,$id)
    {
        $user = User::findOrFail($user_id);
        $grupo = Grupo::findOrFail($id);
        
        if ($user->grupo_id !==null){
           
            

            if(!Grupo::findOrFail($user->grupo_id)->admin ){
                $user->update([
                    'grupo_id'=>$grupo->id
                ]);
                $user->save();
            } else if(Grupo::findOrFail($user->grupo_id)->admin) {
                
                return redirect('/grupos/'.$id)->with('message','O Admin não pode ser inserido');
            }
        } else {
            $user->update([
                'grupo_id'=>$grupo->id
            ]);
            $user->save();
        }
        return redirect('/grupos/'.$id);
    }

    public function removeUser($user_id, $id)
    {
        $user = User::findOrFail($user_id);
        if(!Grupo::findOrFail($user->grupo_id)->admin===true){
            $user->update([
                'grupo_id'=> 2
            ]);

        } else if(Grupo::findOrFail($user->grupo_id)->admin===true) {
           return redirect('/grupos/'.$id)->with('message','O Admin não pode ser inserido');
        }

        return redirect('/grupos/'.$id);
        
    }

    
}
