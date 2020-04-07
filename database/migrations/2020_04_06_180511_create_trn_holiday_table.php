<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrnHolidayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trn_holiday', function (Blueprint $table) {
            $table->increments('holiday_cd');
            $table->integer('operator_cd');
            $table->date('acquisition_ymd');
            $table->integer('post_cd');
            $table->integer('holiday_form');
            $table->integer('holiday_class');
            $table->decimal('acquisition_num', 5, 2)->nullable()->default(0.00);
            $table->string('target_ym', 6);
            $table->integer('withdrawal_kbn')->default(0);
            $table->integer('delete_flg')->default(0);
            $table->timestampTz('delete_date')->nullable();
            $table->integer('creater_cd')->default(0);
            $table->timestampTz('create_date');
            $table->integer('updater_cd')->default(0);
            $table->timestampTz('update_date');
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
        Schema::dropIfExists('trn_holiday');
    }
}
