<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrnExchangeDayHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trn_exchange_day_history', function (Blueprint $table) {
            $table->integer('operator_cd');
            $table->integer('history_no');
            $table->decimal('grant_days', 5, 2)->default(0.00);
            $table->date('target_start');
            $table->date('target_end');
            $table->integer('delete_flg')->default(0);
            $table->string('delete_date')->nullable();
            $table->integer('creater_cd')->default(0);
            $table->string('create_date');
            $table->integer('updater_cd')->default(0);
            $table->string('update_date');
            $table->string('update_app', 10);

            $table->primary(['operator_cd', 'history_no']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trn_exchange_day_history');
    }
}
