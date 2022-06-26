<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CentrosCustosLinha extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centros_custos_linhas', function (Blueprint $table) {
            
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('centro_id');
            
            $table->boolean('is_gestor');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('centro_id')->references('id')->on('centros_custos');
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
