<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CarrinhoLinhas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrinho_linhas', function ($table) {
            $table->bigInteger('carrinho_compras_id');
            $table->unsignedInteger('item_id')->nullable();
            $table->unsignedInteger('kit_id')->nullable();
            $table->string('type');
           
        });
            
            
           
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
