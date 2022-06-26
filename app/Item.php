<?php

namespace App;

use App\Atributo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Kit;
use Laravel\Scout\Searchable;

class Item extends Model
{
    use Searchable;
    public function searchableAs()
    {
        return "item";
    }
    protected $guarded = ["id"];

    public $timestamps = false;
    public function atributos()
    {
        return $this->hasOne(Atributo::class, "id");
    }
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, "id");
    }

    public function kits()
    {
        return $this->belongsTo(ItemKit::class);
    }

    public function getImageAttribute()
    {
        return $this->fotografia;
    }

    public static function visiveis()
    {
        $items = DB::table('items')
            ->join('atributos', 'items.id_atributos', "=", "atributos.id") 
            ->where("atributos.visivel", "=", 1)
            ->select("items.*") 
            ->get();

        
        return compact('items');
    }
    

    
}
