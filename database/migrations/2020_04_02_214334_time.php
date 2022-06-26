<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Time extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('times', function (Blueprint $table) {
        $table->unsignedBigInteger('idKit')->nullable();
        $table->unsignedBigInteger('idItem')->nullable();
        $table->date('inicioReserva');
        $table->date('fimReserva');
        $table->foreign('iditem')->references('id')->on('items');
        $table->foreign('idKit')->references('id')->on('kits');
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
