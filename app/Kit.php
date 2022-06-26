<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Atributo;
use Laravel\Scout\Searchable;


class Kit extends Model
{
    use Searchable;
    public function searchableAs()
    {
        return "kit";
    }

    protected $guarded = [
        "id"
    ];

    protected $primaryKey = "id";

    public $incrementing = false;

    public $timestamps = false;


    public function items()
    {
        return $this->hasMany(ItemKit::class);
    }

    public function atributos()
    {
        return $this->hasOne(Atributo::class);
    }

    public static function kitsVisiveis()
    {
        return DB::table('kits')
            ->join('atributos', 'kits.id_atributos', '=', 'atributos.id')
            ->select('kits.*')
            ->where('atributos.visivel','=',1)
            ->get();
    }

    public static function findItems($kit_id){
        $linhas = DB::table('item_kits')
            ->where('item_kits.kit_id',"=",$kit_id) 
            ->get();
        $items=[];
        foreach($linhas as $linha){
            $items[]=[Item::findOrFail($linha->item_id)];
        }
        return $items;
        
    }

    public static function infoForAddKit($kit_id){
        
        $kit =Kit::findOrFail($kit_id);
        $infoIn= [];
        $infoOut= [];
        $itemsIn = DB::table('item_kits')
            ->where('item_kits.kit_id',"=",$kit_id) 
            ->join('items','item_kits.item_id',"=",'items.id')
            ->select('items.*')
            ->get();

            //dd($itemsIn);
        $itemsOut = Item::all()->filter(function ($item) use ($itemsIn) {
            $res = true;
            foreach ($itemsIn as $itemIn) {
                //dd($itemIn, $item);
                if($itemIn->id == $item->id){
                    $res = false;
                    break;
                }
            }
            return $res;
        });

       

        foreach ($itemsIn as $item) {
            $categoria = Categoria::findOrFail($item->categoria_id);
            $atributos = Atributo::findOrFail($item->id_atributos);
            $infoIn[$item->id]=[$item,$categoria,$atributos];
        }
        foreach ($itemsOut as $item) {
            $categoria = Categoria::findOrFail($item->categoria_id);
            $atributos = Atributo::findOrFail($item->id_atributos);
            $infoOut[$item->id]=[$item,$categoria,$atributos];
        }
        
        $newInfo = [$kit,$infoIn, $infoOut];
        return $newInfo;
    }
}
