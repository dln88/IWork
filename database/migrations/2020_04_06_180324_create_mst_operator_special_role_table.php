<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstOperatorSpecialRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_operator_special_role', function (Blueprint $table) {
            $table->integer('operator_cd')->unsigned()->unique();
            $table->string('special_role_key', 20);
            $table->integer('delete_flg')->default(0);
            $table->string('delete_date')->nullable();
            $table->integer('creater_cd')->default(0);
            $table->string('create_date');
            $table->integer('updater_cd')->default(0);
            $table->string('update_date');
            $table->string('update_app', 10);

            $table->primary(['operator_cd', 'special_role_key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_operator_special_role');
    }
}
