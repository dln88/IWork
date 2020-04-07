<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstSystemconfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_systemconfig', function (Blueprint $table) {
            $table->integer('systemconf_cd')->primary();
            $table->string('systemconf_name', 20)->unique();
            $table->string('systemconf_value', 100);
            $table->string('memo', 100)->nullable();
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
        Schema::dropIfExists('mst_systemconfig');
    }
}
