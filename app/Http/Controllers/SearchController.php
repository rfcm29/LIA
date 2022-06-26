<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Atributo;
use App\Kit;
use App\Categoria;
use App\Grupo;
use App\User;
use App\Reserva;
use App\ItemKit;
use Carbon\Carbon;
use App\Time;
use App\CarrinhoCompras;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Returns the result of the search for items and kits
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function searchItemsKits(Request $request){
        
        $items= Item::search(request('name'))->get();
        $kits= Kit::search(request('name'))->get();
        $itemsAtributos=[];
        $kitsAtributos=[];
        $categorias=Categoria::search(request('name'))->get();
        //dd($items,$kits,$categorias);
        foreach($categorias as $categoria){
            $itemsC = Item::search($categoria->id)->get();
            $kitsC= Kit::search($categoria->id)->get();
            foreach($itemsC as $item){
                $atributo=Atributo::findOrFail($item->id_atributos);
                if($atributo->visivel){
                    $itemsAtributos[$item->id]=[$item,Atributo::findOrFail($item->id_atributos)];
                }else if(session('grupo')->gerirItemsKits) {
                    $itemsAtributos[$item->id]=[$item,Atributo::findOrFail($item->id_atributos)];
                }
    
            }
            foreach($kitsC as $kit){
                $atributo=Atributo::findOrFail($kit->id_atributos);
                if($atributo->visivel){
                    $kitsAtributos[$kit->id]=[$kit,Atributo::findOrFail($kit->id_atributos)];
                }else if(session('grupo')->gerirItemsKits) {
                    $kitsAtributos[$kit->id]=[$kit,Atributo::findOrFail($kit->id_atributos)];
                }
                $kitsAtributos[$kit->id]=[$kit,Atributo::findOrFail($kit->id_atributos)];
    
            }
        }
        
        foreach($items as $item){
            
                $atributo=Atributo::findOrFail($item->id_atributos);
                if($atributo->visivel){
                    $itemsAtributos[$item->id]=[$item,Atributo::findOrFail($item->id_atributos)];
                }else if(session('grupo')->gerirItemsKits) {
                    $itemsAtributos[$item->id]=[$item,Atributo::findOrFail($item->id_atributos)];
                }
        }
        foreach($kits as $kit){
            $atributo=Atributo::findOrFail($kit->id_atributos);
                if($atributo->visivel){
                    $kitsAtributos[$kit->id]=[$kit,Atributo::findOrFail($kit->id_atributos)];
                }else if(session('grupo')->gerirItemsKits) {
                    $kitsAtributos[$kit->id]=[$kit,Atributo::findOrFail($kit->id_atributos)];
                }
                    
        }

        return view('pesquisa.search',compact('itemsAtributos','kitsAtributos'));

    }
    public function searchItemsAndKits(Request $request){
        $items = Item::search(request('name'))->get();
        $kits = Kit::search(request('name'))->get();

        //dd($items);
        $itemsAtributos = [];
        $kitsAtributos = [];

        $hoje = Carbon::now();

        $carrinho = CarrinhoCompras::carrinho(auth()->user());
       if(request('data_entre_inicio') && request('data_entre_fim')){
        DB::table('carrinho_linhas')->where('carrinho_linhas.carrinho_compras_id', '=' ,$carrinho->id)->delete();
        session()->put('datas', [request('data_entre_inicio'),request('data_entre_fim')]);
        $inicioCliente = Carbon::create(request('data_entre_inicio'));
        $fimCliente = Carbon::create(request('data_entre_fim'));
       }else {
        $inicioCliente = Carbon::create(session('datas')[0]);
        $fimCliente = Carbon::create(session('datas')[1]);
       }
        
        foreach ($items as $item) {
            $tempos =Time::fetchByItem($item->id);
            if(count($tempos)==0){
                $itemsAtributos[] = [$item,Atributo::findOrFail($item->id_atributos)];
            }else {
                foreach ($tempos as $data) {
                    $inicioData = $data->inicioReserva;
                    $fimData = $data->fimReserva;
                    
                // dd("testar se data é valida ".$inicioCliente->diffInDays($fimCliente,false)." ".$hoje->diffInDays($inicioCliente,false), "testar com as reservas".$fimCliente->diffInDays($inicioData));
                    if($inicioCliente->diffInDays($fimCliente,false)>0 && $hoje->diffInDays($inicioCliente,false)>0) {
                        if($fimCliente->diffInDays($inicioData,false)>0 && $inicioCliente->diffInDays($fimData,false)>0){
                            $itemsAtributos[] = [$item,Atributo::findOrFail($item->id_atributos)];
                        }
                    }else {
                        return "Data inserida nao valida";
                    }
                }  
            } 
        }
        foreach ($kits as $kit) {
            $tempos =Time::fetchByKit($kit->id);
            if(count($tempos)==0){
                $kitsAtributos[] = [$kit,Atributo::findOrFail($kit->id_atributos)];
            }else {
                foreach ($tempos as $data) {
                    $inicioData = $data->inicioReserva;
                    $fimData = $data->fimReserva;

                    if($inicioCliente->diffInDays($fimCliente,false)>0 && $hoje->diffInDays($inicioCliente,false)<0){
                        if($fimCliente->diffInDays($inicioData,false)<0 && $inicioCliente->diffInDays($fimData,false)>0){
                            $kitsAtributos[] = [$kit,Atributo::findOrFail($kit->atributos_id)];
                        }
                    }else {
                        return "Data inserida nao valida";
                    }
                }
            }
            
        }
       
        return view('pesquisa.search',compact('itemsAtributos','kitsAtributos'));

    }



    /**
     * Returns the result of the search for Categorias
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function searchItemsInKits(Request $request, $id){
        $kit =Kit::findOrFail($id);
        $itemsP = Item::search(request('name'))->get();;
        $itemsIn = ItemKit::search($kit->id)->get();
        $items = Item::all();
        $finalItemsIn = [];
        $finalItemsOut = [];
        foreach ($items as $item) {
            foreach ($itemsIn as $itemIn) {
                foreach($itemsP as $itemP){
                    if($itemP->id === $item->id && $itemP->id===$itemIn->item_id){
                        $categoria = Categoria::findOrFail($item->categoria_id);
                        $atributos = Atributo::findOrFail($item->id_atributos);
                        $finalItemsIn[$item->id]=[$item,$categoria,$atributos,$itemIn->qtd];
                        
                    }else if($itemIn->item_id!==$item->id){
                        $categoria = Categoria::findOrFail($item->categoria_id);
                        $atributos = Atributo::findOrFail($item->id_atributos);
                        $finalItemsOut[$item->id]=[$item,$categoria,$atributos];
                        
                    }
                }
                
            }
        }
        $info=[$kit,$finalItemsIn,$finalItemsOut];
        return view(('.kits.additems'),compact('info'));


    }
    /**
     * Returns the result of the search for Categorias
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function searchItemsOutKits(Request $request,$id){
        $kit =Kit::findOrFail($id);
        $itemsP = Item::search(request('name'))->get();;
        $itemsIn = ItemKit::search($kit->id)->get();
        $items = Item::all();
        $finalItemsIn = [];
        $finalItemsOut = [];
        foreach ($items as $item) {
            foreach ($itemsIn as $itemIn) {
                
            
                foreach($itemsP as $itemP){
                    if($itemP->id === $item->id && $itemP->id!==$itemIn->item_id){
                        $categoria = Categoria::findOrFail($item->categoria_id);
                        $atributos = Atributo::findOrFail($item->id_atributos);
                        $finalItemsOut[$item->id]=[$item,$categoria,$atributos];
                    }else if($itemIn->item_id===$item->id){
                        $categoria = Categoria::findOrFail($item->categoria_id);
                        $atributos = Atributo::findOrFail($item->id_atributos);
                        $finalItemsIn[$item->id]=[$item,$categoria,$atributos,$itemIn->qtd];
                    }
                }
                
            }
        }
        $info=[$kit,$finalItemsIn,$finalItemsOut];
        return view(('.kits.additems'),compact('info'));




    }

    /**
     * Returns the result of the search for Categorias
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function searchCategorias(Request $request){


        $newcategorias = [];
        $categorias= Categoria::search(request('name'))->get();
        foreach ($categorias as $categoria){
            $count =0;
            $items=Item::all()->where('categoria_id','=',$categoria->id);
            foreach($items as $item){
                $count++;
            }
            $kits=Kit::all()->where('categoria_id','=',$categoria->id);
            foreach ($kits as $kit) {
                $count++;
            }          
            $newcategorias[]=['categoria'=>$categoria,'qtd'=>$count];
        }
        return view('categorias.index', compact('newcategorias'));
        
    }
    /**
     * Returns the result of the search for Categorias
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function searchReservas(Request $request){
        
        $listaReservas=[];
         //verifica se foi inserido algum input de texto
        if(request('name')===null){
            $reservas = Reserva::all();
            //percorre as reservas todas e define os valores das margens das datas se necessario
            foreach ($reservas as $reserva) {
                if(request('data_entre_inicio')!==null){
                    request()->validate([
                        'data_entre_inicio' => 'date',
                    ]);
                    $entreInicio = new Carbon(request('data_entre_inicio'));
                }else {
                    $entreInicio = new Carbon($reserva->data_inicio);
                }
                if(request('data_entre_fim')!==null){
                    request()->validate([
                        'data_entre_fim' => 'date',
                    ]);
                    $entreFim = new Carbon(request('data_entre_fim'));
                }else {
                    $entreFim = new Carbon($reserva->data_fim);
                }
                $data_inicio = new Carbon($reserva->data_inicio);
                $data_fim = new Carbon($reserva->data_fim);
                $checkI = $entreInicio->diffInDays($data_inicio,false);  
                $checkF = $data_fim->diffInDays($entreFim,false);
                // verifica se a data da reserva está ou não dentro dos limites
                if($checkF>=0 && $checkI>=0){
                    
                    $this->authorize('reservar',Reserva::class);
                    
                    if(Grupo::findOrFail(auth()->user()->grupo_id)->gerirReservas){
                        $user=User::findOrFail($reserva->user_id);
                        $listaReservas[$reserva->id]=[$reserva,$user];
                    }else if(!Grupo::findOrFail(auth()->user()->grupo_id)->gerirReservas ){
                            if($reserva->user_id===auth()->user()->id){
                                $user=User::findOrFail($reserva->user_id);
                                $listaReservas[$reserva->id]= [$reserva,$user];
                            }
                    }
                    
                }
            }
                return view('reservas.index', compact('listaReservas'));
        }

        
       $users=User::search(request('name'))->get();
       
       $listaReservas=[];
       foreach ($users as $user) {
           $reservas=Reserva::search($user->id)->get();
           
           foreach ($reservas as $reserva) {
                    if(request('data_entre_inicio')!==null){
                        request()->validate([
                            'data_entre_inicio' => 'date',
                        ]);
                        $entreInicio = new Carbon(request('data_entre_inicio'));
                    }else {
                        $entreInicio = new Carbon($reserva->data_inicio);
                    }
                    if(request('data_entre_fim')!==null){
                        request()->validate([
                            'data_entre_fim' => 'date',
                        ]);
                        $entreFim = new Carbon(request('data_entre_fim'));
                    }else {
                        $entreFim = new Carbon($reserva->data_fim);
                    }
                    $data_inicio = new Carbon($reserva->data_inicio);
                    $data_fim = new Carbon($reserva->data_fim);
                    $checkI = $entreInicio->diffInDays($data_inicio,false);  
                    $checkF = $data_fim->diffInDays($entreFim,false);
                    
                    if($checkF>0 && $checkI>0){
                        if(Grupo::findOrFail(auth()->user()->grupo_id)->gerirReservas){
                            $user=User::findOrFail($reserva->user_id);
                            $listaReservas[$reserva->id]= [$reserva,$user];
                            }else {
                                if($reserva->user_id===auth()->user()->id){
                                $user=User::findOrFail($reserva->user_id);
                                $listaReservas[$reserva->id]= [$reserva,$user];
                                }
                            }
                    }
               }
               
            }
          
        $reservas=Reserva::search(request('name'))->get();
        
        foreach ($reservas as $reserva) {
            if(request('data_entre_inicio')!==null){
                $entreInicio = new Carbon(request('data_entre_inicio'));
            }else {
                $entreInicio = new Carbon($reserva->data_inicio);
            }
            if(request('data_entre_fim')!==null){
                $entreFim = new Carbon(request('data_entre_fim'));
            }else {
                $entreFim = new Carbon($reserva->data_fim);
            }
            $data_inicio = new Carbon($reserva->data_inicio);
            $data_fim = new Carbon($reserva->data_fim);
            $checkI = $entreInicio->diffInDays($data_inicio,false);  
            $checkF = $data_fim->diffInDays($entreFim,false);
            
            if($checkF>0 && $checkI>0){
            if(Grupo::findOrFail(auth()->user()->grupo_id)->gerirReservas){
                $user=User::findOrFail($reserva->user_id);
                $listaReservas[$reserva->id]= [$reserva,$user];
                }else {
                    if($reserva->user_id===auth()->user()->id){
                    $user=User::findOrFail($reserva->user_id);
                    $listaReservas[$reserva->id]= [$reserva,$user];
                    }
                }
            }
        }
    
        
        return view('reservas.index', compact('listaReservas'));
    }
    /**
     * Returns the result of the search for Categorias
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function searchGrupos(Request $request){
        $this->authorize('gerir',Grupo::Class);
        $grupos=Grupo::search(request('name'))->get();
        $newgrupos = [];
        foreach($grupos as $grupo){
            $usersCount = User::countUsers($grupo->id);
            $newgrupos[]= ['grupo'=>$grupo,'qtd'=>$usersCount];
        }
        return view('grupos.index', compact('newgrupos'));
    }

    /**
     * Returns the result of the search for Categorias
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function searchUsers(Request $request){
        $this->authorize('gerir',User::Class);
        $users=User::search(request('name'))->get();
        $allUsers = [];
        foreach ($users as $user) {
            $allUsers[]=[$user,Grupo::findOrFail($user->grupo_id)];
            
        }
        return view('.users.index',compact('allUsers'));
    }

    /**
     * Returns the result of the search for Categorias
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function searchInUsers(Request $request, $id){
        $grupo=Grupo::findOrFail($id);
        $usersP = User::search(request('name'))->get();
        $users=User::all(); 
        
        $usersNotGroup = [];
        $usersGroup = [];
        foreach ($users as $u){
        foreach ($usersP as $user) {

                if($user->grupo_id ===$grupo->id && $u->id === $user->id){
                    $usersGroup[$user->id]=$user;
                }else if($u->grupo_id !== $grupo->id){
                    $usersNotGroup[$u->id]=$u;
                }
            
            }
        
        }
        return view('grupos.show', ['grupo' => $grupo,'users' => $usersNotGroup,'usersGroup'=> $usersGroup]);

    }
    /**
     * Returns the result of the search for Categorias
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function searchOutUsers(Request $request, $id){
        $grupo=Grupo::findOrFail($id);
        $usersP = User::search(request('name'))->get();
        $users=User::all(); 
        
        $usersNotGroup = [];
        $usersGroup = [];
        foreach ($users as $u){
            foreach ($usersP as $user) {
    
                    if($u->grupo_id ===$grupo->id){
                        $usersGroup[$u->id]=$u;
                    }else if($user->grupo_id !== $grupo->id  && $u->id === $user->id){
                        $usersNotGroup[$u->id]=$u;
                    }
                
                }
            
            }
        
        
        return view('grupos.show', ['grupo' => $grupo,'users' => $usersNotGroup,'usersGroup'=> $usersGroup]);


    }
    
}

