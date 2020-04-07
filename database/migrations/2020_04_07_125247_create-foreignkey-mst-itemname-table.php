<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignkeyMstItemnameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_itemname', function(Blueprint $table)
        {
            $table->foreign('item_name_cd')->references('item_name_cd')->on('mst_item')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_itemname', function(Blueprint $table)
        {
            $table->dropForeign('mst_itemname_item_name_cd_foreign');
        });
    }
}
