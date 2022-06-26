<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class CarrinhoCompras extends Model
{
    

    protected $fillable = ["user_id"];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function linhas($carrinho)
    {
        $linhas = DB::table('carrinho_linhas')
        ->select("carrinho_linhas.*") 
        ->where("carrinho_linhas.carrinho_compras_id","=",$carrinho->id)
        ->get();
        return $linhas;

    }
    

    public static function carrinho($user){
        $carrinho = DB::table('carrinho_compras')
        ->select("carrinho_compras.*")
        ->where("carrinho_compras.user_id","=",$user->id)
        ->first();

        return $carrinho;
    }
}
