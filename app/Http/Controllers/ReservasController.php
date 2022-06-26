<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Reserva;
use App\CarrinhoLinhas;
use App\ReservaLinhas;
use App\Item;
use App\User;
use App\Kit;
use App\Grupo;
use App\Atributo;
use App\ItemKit;
use App\Time;
use PDF;
use App\CarrinhoCompras;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class ReservasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $this->authorize('reservar',Reserva::class);
        $listaReservas = [];
        if(Grupo::findOrFail(auth()->user()->grupo_id)->gerirReservas){
            $reservas=Reserva::all();

            foreach ($reservas as $reserva) {
                $user=User::findOrFail($reserva->user_id);
                $listaReservas[$reserva->id]= [$reserva,$user];
            
            }
       
        } else {
            $reservas=Reserva::findByUser_id(auth()->user()->id);
            foreach ($reservas as $reserva) {
                $user=User::findOrFail($reserva->user_id);
                $listaReservas[$reserva->id]= [$reserva,$user];
            
            }
            
        }
        return view('reservas.index', compact('listaReservas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $this->authorize('reservar',Reserva::class);
        
        $carrinho=CarrinhoCompras::carrinho(auth()->user());
        if(!session('datas')){
            DB::table('carrinho_linhas')->where('carrinho_linhas.carrinho_compras_id', '=' ,$carrinho->id)->delete(); 
        }
        $linhas=CarrinhoLinhas::fetchLinhas($carrinho->id);
        
        
        return view('reservas.create', compact('linhas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('reservar',Reserva::class);
        request()->validate([
            'razao_pedido' => 'required',
            'curso_disciplina'=>'required'
      
        ]);
        
        //Check Dates
        $today = Carbon::now();
        //$inicioCliente = new Carbon(request('dataInicio'));
        //$fimCliente = new Carbon(request('dataFim'));
        if(session('datas')){
            $inicioCliente = new Carbon(session('datas')[0]);
            $fimCliente = new Carbon(session('datas')[1]);
        }else {
            return redirect(('/reservas/create'))->with('message','As datas não estão definidas');
        }
       
        
        $checkDateI = $today->diffInDays($inicioCliente,false);
        $checkDateF = $inicioCliente->diffInDays($fimCliente,false);  

        

        if($checkDateI<0 || $checkDateF<0){
            return redirect(('/reservas/create'))->with('message','As datas inseridas não são válidas');
        }
        //end Check Dates

        //Verificar a quantidade de items para o dia
        $carrinho = CarrinhoCompras::carrinho(auth()->user());
        $linhas= CarrinhoLinhas::fetchLinhas($carrinho->id);

        if(count($linhas)== 0){
            return redirect(('/reservas/create'))->with('message','O seu carrinho está vazio');
        }
        
        //Percorre todas as linhas da Reserva
        foreach ($linhas as $linha) {
            //verificar se a linha é um item ou kit
            if($linha->itemKit instanceof Item){
                    $item=Item::findOrFail($linha->itemKit->id);
                    $atributo=Atributo::findOrFail($item->id_atributos);
                    //Ver se existem reservas para esse item
                    $tempos =Time::fetchByItem($item->id);
                    if(count($tempos)==0){
                        //item pode ser reservado
                    }else {
                        foreach ($tempos as $data) {
                            $inicioData = $data->inicioReserva;
                            $fimData = $data->fimReserva;
                            
                            // testar se data é valida 
                            if($fimCliente->diffInDays($inicioData,false)>0 && $inicioCliente->diffInDays($fimData,false)>0){
                                //item pode ser reservado
                            }else{
                                return  redirect(('/reservas/create'))->with('message',"O item ". $item->name. " não está disponivel para esta data.");
                            }
                           
                        }  
                    }
                   
                    
                }else {
                    $itemKit=ItemKit::all()->where('kit_id',"=",$linha->itemKit->id);
                    $kit = Kit::findOrFail($linha->itemKit->id);
                    foreach ($itemKit as $item) {
                        $itemR=Item::findOrFail($item->item_id);
                        $atributo=Atributo::findOrFail($itemR->id_atributos);
                        //Ver se existem reservas para esse item
                        $tempos =Time::fetchByItem($item->id);
                        if(count($tempos)==0){
                            //item pode ser reservado
                        }else {
                            foreach ($tempos as $data) {
                                $inicioData = $data->inicioReserva;
                                $fimData = $data->fimReserva;
                                
                                // testar se data é valida 
                                if($fimCliente->diffInDays($inicioData,false)>0 && $inicioCliente->diffInDays($fimData,false)>0){
                                    //item pode ser reservado
                                }else{
                                    return  redirect(('/reservas/create'))->with('message',"O kit ". $kit->name. " não está disponivel para esta data, porque um dos seus items já está reservado");
                                }
                               
                            } 
                        }
                    }
                }
            }
                
            
           
        $Reserva = Reserva::create([
            'razao_pedido' => request('razao_pedido'),
            'isConcluido' => 0,
            'emAtraso' => 0,
            'data_inicio'=> $inicioCliente,
            'data_fim'=> $fimCliente,
            'wasVista'=> false,
            'isAceite'=> false,
            'user_id'=> auth()->user()->id,
            'curso_disciplina'=>request('curso_disciplina'),
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);
        $Reserva->save();
        foreach ($linhas as $linha) {
            
            if($linha->itemKit instanceof Item){
                $reservaLinha = ReservaLinhas::create([
                    'reserva_id' => $Reserva->id,
                    'item_id'=> $linha->itemKit->id,
                    'kit_id'=> null,
                    'type'=>'item',
                    
                    ]);

                    $tempos = Time::create([
                        'idItem' => $reservaLinha->item_id,
                        'idKit' => null,
                        'inicioReserva' => $Reserva->data_inicio,
                        'fimReserva' => $Reserva->data_fim,
                    ]);
            }else {
                $reservaLinha = ReservaLinhas::create([
                    'reserva_id' => $Reserva->id,
                    'item_id'=> null,
                    'kit_id'=> $linha->itemKit->id,
                    'type'=>'kit',
                    
                    ]);

                    $tempos = Time::create([
                        'idItem' => null,
                        'idKit' => $reservaLinha->kit_id,
                        'inicioReserva' => $Reserva->data_inicio,
                        'fimReserva' => $Reserva->data_fim,
                    ]);
            }
        }
         
        DB::table('carrinho_linhas')->where('carrinho_linhas.carrinho_compras_id', '=' ,$carrinho->id)->delete();
        return redirect(('/reservas/'));
            
        }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $reserva =Reserva::findOrFail($id);
        $user=User::findOrFail($reserva->user_id);
        $linhas=ReservaLinhas::fetchLinhas($reserva->id);
        
        return view('reservas.show',["reserva"=>$reserva  ,"user"=>$user ,"linhas"=> $linhas]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('gerir',Reserva::Class);
        $reserva=Reserva::findOrFail($id);
        
        return view('reservas.edit',compact('reserva'));
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
        $this->authorize('gerir',Reserva::Class);
        $request->validate([
            'data_entrega' => "required|date",
            'observacoes' => "string",
            'estado_entrega' => "string",  
        ]);

        $reserva= Reserva::findOrFail($id);
        $reserva->update([
            'data_entrega' => request('data_entrega'),
            'observacoes' => request('observacoes'),
            'estado_entrega' => request('estado_entrega'),  
        ]);
       
        $reserva->save();

        
        $user=User::findOrFail($reserva->user_id);
        $linhas=ReservaLinhas::fetchLinhas($reserva->id);
        
        return view('reservas.show',["reserva"=>$reserva  ,"user"=>$user ,"linhas"=> $linhas]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    
    public function downloadPdf($id){
        $this->authorize('gerir',Reserva::class);
        $reserva=Reserva::findOrFail($id);
        $user = User::findOrFail($reserva->user_id);
        $linhas=ReservaLinhas::fetchLinhas($reserva->id);
        
        $pdf = PDF::loadView('.pdf.pdfDownload',['reserva'=>$reserva,'linhas'=>$linhas,'user'=>$user]);
        return $pdf->download('Requisicao.pdf');
    }

    /**
     * Changes the Atribbute isConclida to True.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function isConcluida($id){
        $this->authorize('gerir',Reserva::class);
        $reserva=Reserva::findOrFail($id);
        if(!$reserva->isConcluido && $reserva->wasVista && $reserva->isAceite){
            $reserva->update([
                'isConcluido'=>true
                
            ]);
            $reserva->save();
        } else{
            return redirect(('/reservas/'.$reserva->id))->with('messageConc','Esta reserva não pode ser Concluida');
        }
        return redirect(('/reservas/'.$reserva->id.'/edit'));
        
    }


    /**
     * Changes the Atribbute wasVista to True and isAceite to true.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function acceptReserva($id){
        $this->authorize('gerir',Reserva::class);
        $reserva=Reserva::findOrFail($id);
        if(!$reserva->isConcluido && !$reserva->wasVista){
        $reserva->update([
            'wasVista'=>true,
            'isAceite'=>true
        ]);
        $reserva->save();
        }else {
            return redirect(('/reservas/'.$reserva->id))->with('messageAcei','Esta reserva já foi recusada ou aceite');
        }
        return redirect(('/reservas/' . $reserva->id));

    }

    /**
     * Changes the Atribbute wasVista to True and isAceite to false.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function refuseReserva($id){
        $this->authorize('gerir',Reserva::class);
        $reserva=Reserva::findOrFail($id);
        if(!$reserva->isConcluido && !$reserva->wasVista){
        $reserva->update([
            'wasVista'=>true,
            'isAceite'=>false
        ]);
        $reserva->save();   
        }else {
            return redirect(('/reservas/'.$reserva->id))->with('messageRec','Esta reserva já foi recusada ou aceite');
        }
        
        return redirect(('/reservasPendentes'));
        
    }
}
