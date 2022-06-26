<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Reserva;
use App\Grupo;
use App\User;

class ReservasPendentesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listaReservas=[];
        foreach (Reserva::notSeen() as $reserva) {
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
        $titulo= "Reservas Pendentes";
        
        return view('reservas.index', compact('listaReservas','titulo'));
    }

    
}
