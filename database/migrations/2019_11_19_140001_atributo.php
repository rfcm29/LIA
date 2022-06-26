<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Atributo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atributos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('marca');
            $table->string('modelo');
            $table->bigInteger('serial_number');
            $table->boolean('visivel');
            $table->string('fotografia_caminho');
            $table->longText('descricao');
            $table->boolean('is_item');
            $table->boolean('is_operacional');
            $table->date('date_abate')->nullable();
            $table->timestamps();
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
