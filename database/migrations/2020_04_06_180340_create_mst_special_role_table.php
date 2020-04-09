<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstSpecialRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_special_role', function (Blueprint $table) {
            $table->string('special_role_key', 20)->primary();
            $table->string('special_role_name', 100);
            $table->string('explanation', 100)->nullable();
            $table->integer('not_display')->default(0); // 1: 非表示 (Hidden)
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
        Schema::dropIfExists('mst_special_role');
    }
}
