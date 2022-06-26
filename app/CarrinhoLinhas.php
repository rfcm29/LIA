<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Item;


class CarrinhoLinhas extends Model
{
    
    protected $fillable = ["carrinho_compras_id",'type'];

    public $timestamps = false;

    public function CarrinhoCompras(){
        return $this->belongsTo(CarrinhoCompras::class,"carrinho_compras_id");
    }

    public function items()
    {
        return $this->hasOne(Item::class, "item_id");
    }

    public function kits()
    {
        return $this->hasOne(Kit::class, "kit_id");
    }

    public static function itemPertence(){
        $linha= DB::table('carrinho_linhas')
        ->join('items', 'items.id', "=", "carrinho_linhas.item_id") 
        ->select("carrinho_linhas.*") 
        ->get();
    }

    public static function fetchLinhas($id){
        $linhas = DB::table('carrinho_linhas')->where('carrinho_compras_id',$id)->get();
        
        $linhas = $linhas->map(function($linha, $key) {
            if(isset($linha->item_id)){
                return new class (Item::findOrFail($linha->item_id)){
                    public $itemKit;

                    public function __construct($itemKit) {
                        $this->itemKit = $itemKit;
                    }
                };
            }else if (isset($linha->kit_id)) {
                return new class (Kit::findOrFail($linha->kit_id)){
                    public $itemKit;
                    

                    public function __construct($itemKit) {
                        $this->itemKit = $itemKit;
    
                    }
                };
            }
        });

        
        return $linhas;

    }
    public static function checkLinha($kit,$item,$carrinho){
        if($item){
            return DB::table('carrinho_linhas')
            ->select("carrinho_linhas.*")
            ->where("carrinho_linhas.item_id", "=", $item->id)
            ->where("carrinho_linhas.carrinho_compras_id","=",$carrinho->id)
            ->first();

        }else {
            return DB::table('carrinho_linhas')
            ->select("carrinho_linhas.*")
            ->where("carrinho_linhas.kit_id", "=", $kit->id)
            ->where("carrinho_linhas.carrinho_compras_id","=",$carrinho->id)
            ->first();
        }

    }

    public static function deleteLinha($carrinho,$existingLinha,$item,$kit){
        if($item){
        return DB::table('carrinho_linhas')
            ->where("carrinho_linhas.item_id","=",$item->id)
            ->where("carrinho_linhas.carrinho_compras_id","=",$carrinho->id)
            ->delete();
        }else if ($kit) {
            return DB::table('carrinho_linhas')
            ->where("carrinho_linhas.kit_id","=",$kit->id)
            ->where("carrinho_linhas.carrinho_compras_id","=",$carrinho->id)
            ->delete();

        }
    }

    

    public static function insereItemKit($carrinho,$item,$kit){
        if($item){
            return DB::table('carrinho_linhas')->insert([
                'carrinho_compras_id'=>$carrinho->id,
                'item_id' => $item->id,
                'kit_id'=>null,
                'type'=>'item'
                ]);
            }else if ($kit) {
            return DB::table('carrinho_linhas')->insert([
                'carrinho_compras_id'=>$carrinho->id,
                'item_id' => null,
                'kit_id'=>$kit->id,
                'type'=>'kit'
                ]);
    
            }
    }

    
    
}
