<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrnAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trn_attendance', function (Blueprint $table) {
            $table->integer('operator_cd');
            $table->date('regi_date');
            $table->integer('post_cd');
            $table->string('emp_no', 15);
            $table->string('target_ym', 6);
            $table->string('att_time', 0); // 実際の時間
            $table->string('leav_time', 0)->nullable(); // 実際の時間
            $table->string('start_time', 5)->nullable(); // hh:mm
            $table->string('end_time', 5)->nullable(); // hh:mm
            $table->decimal('break_time', 5, 2)->nullable()->default(0.00);
            $table->decimal('working_time', 5, 2)->nullable()->default(0.00);
            $table->decimal('over_time', 5, 2)->nullable()->default(0.00);
            $table->decimal('late_over_time', 5, 2)->nullable()->default(0.00);
            $table->decimal('ex_statutory_wk_time', 5, 2)->nullable()->default(0.00);
            $table->decimal('interval_time', 5, 2)->nullable()->default(0.00);
            $table->string('memo')->nullable();
            $table->integer('delete_flg')->default(0);
            $table->string('delete_date')->nullable();
            $table->integer('creater_cd')->default(0);
            $table->string('create_date');
            $table->integer('updater_cd')->default(0);
            $table->string('update_date');
            $table->string('update_app', 10);

            $table->primary(['operator_cd', 'regi_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trn_attendance');
    }
}
