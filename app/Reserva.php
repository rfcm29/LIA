<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;

use Carbon\Carbon;




class Reserva extends Model
{
    
    use Searchable;
    public function searchableAs()
    {
        return "reserva";
    }
    /**
     * Fillable atributes in Class reserva
     *
     * @return string
     */
    protected $fillable = [
        'razao_pedido',
        'user_id',
        'created_at',
        'updated_at',
        'isConcluido',
        'emAtraso',
        'data_inicio',
        'data_fim',
        'wasVista',
        'isAceite',
        'curso_disciplina',
        'data_entrega',
        'estado_entrega',
        'observacoes'
    ];
    
    
    public static function isNotConcluido()
    {
        $reservas= DB::table('reservas')->where('isConcluido',false)->get();
        return $reservas;
    }

    public static function isNowConcluido()
    {
        $reservas=DB::table('reservas')->where('isConcluido',false)->get();
        return $reservas;
    }

    public static function notSeen()
    {
        $reservas=DB::table('reservas')->where('wasVista',false)->get();
        return $reservas;
    }

    public static function emAtraso()
    {
        $reservas=DB::table('reservas')->where('emAtraso',true)->get();
        return $reservas;

    }

    public static function aDecorrer()
    {
        $reservas=DB::table('reservas')
            ->where('isAceite',true)
            ->where('isConcluido',false)
            ->get();
        return $reservas;   
        
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function findByUser_id($id){
        return DB::table('reservas')
            ->where('user_id', $id)
            ->get();

    }

    public static function linhas($id){
        $linhas =DB::table('reserva_linhas')->where('reserva_id',$id)->get();
            
        return $linhas;
    }
    
    public static function checkdates(){

        $reservasNovasForaPrazo = [];
        $reservas = DB::table('reservas')
            ->where('isConcluido', '=', false)
            ->where('wasVista','=',true)
            ->where('isAceite', '=', true)
            ->where('emAtraso', '<>', true)
            ->get();

            $aux ='yes';
        foreach($reservas as $reserva){
            
            $today = Carbon::now();
            
            $dateF = new Carbon($reserva->data_fim);
                
            $checkDateI = $today->diffInDays($dateF,false);
            
            if($checkDateI <0){
                DB::table('reservas')
                    ->where('id','=',$reserva->id)
                    ->update(['emAtraso'=>true]);

                $reservasNovasForaPrazo[]=$reserva;

            }
        }
        return $reservasNovasForaPrazo;
    } 
}
