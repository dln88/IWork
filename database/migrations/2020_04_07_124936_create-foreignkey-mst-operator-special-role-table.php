<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignkeyMstOperatorSpecialRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_operator_special_role', function(Blueprint $table)
        {
            $table->foreign('operator_cd')->references('operator_cd')->on('mst_operator_special_role')->onDelete('cascade');
            $table->foreign('special_role_key')->references('special_role_key')->on('mst_special_role')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_operator_special_role', function(Blueprint $table)
        {
            $table->dropForeign('mst_operator_special_role_operator_cd_foreign');
            $table->dropForeign('mst_operator_special_role_special_role_key_foreign');
        });
    }
}
