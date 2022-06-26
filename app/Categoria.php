<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;

class Categoria extends Model
{
    use Searchable;
    
    public function searchableAs()
    {
        return "categoria";
    }
    protected $guarded = [
        'id'
    ];
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public static function findItemsKits($categoria_id){
        $items = DB::table('items')
        ->where("items.categoria_id", "=", $categoria_id)
        ->get();

        $kits = DB::table('kits')
        ->where("kits.categoria_id", "=", $categoria_id)
        ->get();

        $newItems=[];
        $newKits=[];
        foreach($items as $item){
            $item=Item::findOrFail($item->id);
            $newItems[]=[$item,Atributo::findOrFail($item->id_atributos)];
        }

        foreach($kits as $kit){
            $kit=Kit::findOrFail($kit->id);
            $newKits[]=[$kit,Atributo::findOrFail($kit->id_atributos)];
        }
        $info=[$newKits,$newItems];
        return $info;
    }
}
