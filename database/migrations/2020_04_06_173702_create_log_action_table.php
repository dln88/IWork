<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_action', function (Blueprint $table) {
            $table->bigIncrements('action_log_no');
            $table->string('operation_timestamp');
            $table->string('ip_address', 30)->nullable();
            $table->integer('operator_cd')->nullable();
            $table->string('operator_name', 50)->nullable();
            $table->string('screen_id', 15)->nullable();
            $table->string('screen_name', 30)->nullable();
            $table->string('operation', 30)->nullable();
            $table->string('contents', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_action');
    }
}
