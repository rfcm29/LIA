<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Reserva extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->longText('razao_pedido');
            $table->boolean('isAceite');
            $table->boolean('wasVista');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->date('data_entrega')->nullable();
            $table->string('estado_entrega')->nullable();
            $table->string('observacoes')->nullable();
            $table->string('curso_disciplina');
            $table->timestamps();
            $table->boolean('isConcluido');
            $table->boolean('emAtraso');
            
            $table->foreign('user_id')->references('id')->on('users');
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
