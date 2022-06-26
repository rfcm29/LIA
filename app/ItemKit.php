<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;


class ItemKit extends Model
{
    use Searchable;
    public function searchableAs()
    {
        return "itemkit";
    }
    
    protected $fillable = [
        "item_id","kit_id","qtd"

    ];
    public function kits()
    {
        return $this->hasOne(Kit::class, 'id');
    }
    public function items()
    {
        return $this->hasOne(Item::class, 'id');
    }

    public static function findIfExists($item_id,$kit_id) {
        return DB::table('item_kits')
            ->where("item_kits.item_id", "=", $item_id)
            ->where("item_kits.kit_id",'=',$kit_id)
            ->first();
            
    }

    /*
    public static function updateLinha($item_id,$kit_id,$existingLinha) {
        return DB::table('item_kits')
            ->where("item_kits.item_id", "=", $item_id)
            ->where("item_kits.kit_id",'=',$kit_id)
            ->update(['qtd' => $existingLinha->qtd+1]);
            
    }

    public static function updateLinhaNega($item_id,$kit_id,$existingLinha) {
        
            return DB::table('item_kits')
            ->where("item_kits.item_id", "=", $item_id)
            ->where("item_kits.kit_id", "=", $kit_id)
            ->update(['qtd' => $existingLinha->qtd-1]);

        
            
            
    }

    */

    

    public static function createLinha($item_id,$kit_id){
        
                $response =DB::table('item_kits')->insert([
                    'item_id' => $item_id,
                    'kit_id'=>$kit_id,
                ]);
                
              return $response;
    }

    public static function deleteLinha($item_id,$kit_id) {
        

            return DB::table('item_kits')
                ->where("item_kits.item_id", "=", $item_id)
                ->where("item_kits.kit_id",'=',$kit_id)
                ->delete();
                
            

        }
    }



