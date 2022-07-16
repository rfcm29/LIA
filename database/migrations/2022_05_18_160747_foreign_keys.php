<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->foreign('user_type_id')->references('id')->on('user_types');
            $table->foreign('user_status_id')->references('id')->on('user_statuses');
        });
        Schema::table('items', function(Blueprint $table) {
            $table->foreign('kit_id')->references('id')->on('kits');
        });
        Schema::table('reserves', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('cost_center_id')->references('id')->on('cost_centers');
            $table->foreign('reserve_state_id')->references('id')->on('reserve_states');
        });
        Schema::table('space_items', function(Blueprint $table) {
            $table->foreign('lia_space_id')->references('id')->on('lia_spaces');
        });
        Schema::table('kit_reserve', function(Blueprint $table) {
            $table->foreign('reserve_id')->references('id')->on('reserves');
            $table->foreign('kit_id')->references('id')->on('kits');
        });
        Schema::table('cost_center_user', function(Blueprint $table) {
            $table->foreign('cost_center_id')->references('id')->on('cost_centers');
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::table('lia_space_space_reserve', function(Blueprint $table) {
            $table->foreign('lia_space_id')->references('id')->on('lia_spaces');
            $table->foreign('space_reserve_id')->references('id')->on('space_reserves');
        });
        Schema::table('space_reserve_user', function(Blueprint $table) {
            $table->foreign('space_reserve_id')->references('id')->on('space_reserves');
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::table('kits', function(Blueprint $table){
            $table->foreign('kit_id')->references('id')->on('kits');
            $table->foreign('kit_state_id')->references('id')->on('kit_states');
            $table->foreign('kit_category_id')->references('id')->on('kit_categories');
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
