<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstOperatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_operator', function (Blueprint $table) {
            $table->increments('operator_cd'); // 'シーケンス　SEQ(OPERATOR_CD)を使用
            $table->string('emp_no', 15)->nullable();
            $table->string('operator_last_name', 15);
            $table->string('operator_first_name', 15);
            $table->string('operator_name_kana', 30); // 並び替え用 (for sorting)
            $table->string('user_id', 10)->unique()->nullable();
            $table->string('password')->nullable();
            $table->date('join_day')->nullable();
            $table->date('resigned_day')->nullable();
            $table->integer('post_cd')->unsigned();
            $table->text('operator_memo')->nullable();
            $table->integer('admin_div')->default(0); // 1: 管理者 (Admin)
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
        Schema::dropIfExists('mst_operator');
    }
}
