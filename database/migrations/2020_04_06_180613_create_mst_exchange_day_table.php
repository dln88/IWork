<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstExchangeDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_exchange_day', function (Blueprint $table) {
            $table->integer('operator_cd')->primary();
            $table->decimal('grant_days', 5, 2);
            $table->date('target_start');
            $table->date('target_end');
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
        Schema::dropIfExists('mst_exchange_day');
    }
}
