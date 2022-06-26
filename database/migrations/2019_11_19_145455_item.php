<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Item extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_ipvc')->nullable();
            $table->string('name');
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('id_atributos');
            //$table->decimal('preco');
            $table->string('observacoes')->nullable();
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->foreign('id_atributos')->references('id')->on('atributos');
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
