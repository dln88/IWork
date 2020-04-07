<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstScreenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_screen', function (Blueprint $table) {
            $table->string('screen_id', 15)->primary(); // 機能ID管理票.画面IDで管理
            $table->string('sreen_name');
            $table->integer('child_screen')->default(0); // 1：子画面 (child screen)
            $table->integer('delete_flg')->default(0);
            $table->timestampTz('delete_date')->nullable();
            $table->integer('creater_cd')->default(0);
            $table->timestampTz('create_date');
            $table->integer('updater_cd')->default(0);
            $table->timestampTz('update_date');
            $table->string('update_app', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_screen');
    }
}
