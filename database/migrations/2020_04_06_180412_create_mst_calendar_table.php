<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstCalendarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_calendar', function (Blueprint $table) {
            $table->date('calendar_ymd')->primary();
            $table->string('target_ym', 6);
            $table->string('era', 20);
            $table->integer('year_jp');
            $table->integer('legalholiday_flg')->default(0);
            $table->integer('nationalholiday_flg')->default(0);
            $table->string('nationalholiday_name', 20);
            $table->integer('delete_flg')->default(0);
            $table->string('delete_date')->nullable();
            $table->integer('creater_cd')->default(0);
            $table->string('create_date');
            $table->integer('updater_cd')->default(0);
            $table->string('update_date');
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
        Schema::dropIfExists('mst_calendar');
    }
}
