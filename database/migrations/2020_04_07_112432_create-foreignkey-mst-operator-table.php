<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignkeyMstOperatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_operator', function(Blueprint $table)
        {
            $table->foreign('post_cd')->references('post_cd')->on('mst_post')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_operator', function(Blueprint $table)
        {
            $table->dropForeign('mst_operator_post_cd_foreign');
        });
    }
}
