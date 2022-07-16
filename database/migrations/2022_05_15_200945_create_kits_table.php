<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kits', function (Blueprint $table) {
            $table->id();
            $table->string('ipvc_ref')->nullable();
            $table->string('lia_code')->nullable();
            $table->string('description');
            $table->float('price');
            $table->string('observation')->nullable();
            $table->unsignedBigInteger('kit_id')->nullable();
            $table->unsignedBigInteger('kit_state_id');
            $table->unsignedBigInteger('kit_category_id');
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
        Schema::dropIfExists('kits');
    }
}
