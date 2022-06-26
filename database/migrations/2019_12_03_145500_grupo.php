<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Grupo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->boolean('admin');
            $table->boolean('gerirReservas');
            $table->boolean('gerirItemsKits');
            $table->boolean('gerirGrupos');
            $table->boolean('gerirCategorias');
            $table->boolean('gerirCentros');
            $table->boolean('gerirUsers');
            $table->boolean('reservar');
            
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
