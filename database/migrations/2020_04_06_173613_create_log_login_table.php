<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_login', function (Blueprint $table) {
            $table->bigIncrements('login_log_no');
            $table->timestampTz('operation_timestamp', 0);
            $table->string('ip_address', 30)->nullable();
            $table->string('user_id', 10)->nullable();
            $table->integer('operator_cd')->nullable();
            $table->string('operator_name', 50)->nullable();
            $table->integer('operation_type'); // 1：ログイン (login)、2：ログアウト (logout)
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
        Schema::dropIfExists('log_login');
    }
}
