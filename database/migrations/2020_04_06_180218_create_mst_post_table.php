<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_post', function (Blueprint $table) {
            $table->integer('post_cd')->primary();
            $table->string('post_name', 15);
            $table->time('post_start_time'); // 24時間表記 (24-hour notation)
            $table->time('post_end_time'); // 24時間表記 (24-hour notation)
            $table->integer('not_display')->default(0); // 1: 非表示 (Hidden)
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
        Schema::dropIfExists('mst_post');
    }
}
