<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;
use App\Item;
use App\Kit;

class ReservaLinhas extends Model
{
    
    protected $fillable = ['reserva_id','item_id','kit_id','type'];

    public $timestamps = false;
        
    public static function fetchLinhas($id){
        
        $linhas =DB::table('reserva_linhas')->where('reserva_id',$id)->get();
        $items = [];
        $kits = [];
        
        foreach ($linhas as $linha) {
            
            
            if(isset($linha->item_id)){
                $items[]= [Item::findOrFail($linha->item_id)];
            }else if (isset($linha->kit_id)){
                $kits[]= [Kit::findOrFail($linha->kit_id)];
            }
        }
        $linhasReturn = ['items'=> $items, 'kits' => $kits];
        return $linhasReturn;

    }
    
}
