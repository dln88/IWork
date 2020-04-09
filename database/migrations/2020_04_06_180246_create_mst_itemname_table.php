<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstItemnameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_itemname', function (Blueprint $table) {
            $table->integer('item_name_cd');
            $table->integer('item_name_value');
            $table->string('item_name', 60)->nullable();
            $table->decimal('item_num', 5, 2)->nullable()->default(0);
            $table->integer('output_type')->default(0);  // 帳票等へ出力するかどうか
            $table->integer('delete_flg')->default(0);
            $table->string('delete_date')->nullable();
            $table->integer('creater_cd')->default(0);
            $table->string('create_date');
            $table->integer('updater_cd')->default(0);
            $table->string('update_date');
            $table->string('update_app', 10);

            $table->primary(['item_name_cd', 'item_name_value']);	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_itemname');
    }
}
