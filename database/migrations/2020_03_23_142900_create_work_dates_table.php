<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_dates', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('user_id');
            $table->date('work_date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->time('break_time')->default('0:00');
            $table->time('working_time')->default('0:00');
            $table->time('over_time')->nullable();
            $table->time('over_night')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_dates');
    }
}
