<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mst_systemconfig')->insert([
            'systemconf_name' => 'ALERT_OVER_TIME',
            'systemconf_value' => 80,
            'memo' => '警告する残業時間規定値',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '0',
        ]);

        DB::table('mst_systemconfig')->insert([
            'systemconf_name' => 'HOLIDAY_ROWS',
            'systemconf_value' => 20,
            'memo' => '休暇登録の最大行数',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '0',
        ]);

        DB::table('mst_systemconfig')->insert([
            'systemconf_name' => 'WORK_ADMIN_ROWS',
            'systemconf_value' => 30,
            'memo' => '管理者勤怠一覧の最大行数',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '0',
        ]);

        DB::table('mst_systemconfig')->insert([
            'systemconf_name' => 'CLOSING_DATE',
            'systemconf_value' => 15,
            'memo' => '会社としての勤怠締日　※1/10/15/20/25/末日（99）の選択制を前提とする。',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '0',
        ]);

        DB::table('mst_systemconfig')->insert([
            'systemconf_name' => 'MAX_LEAVE_TIME',
            'systemconf_value' => 34,
            'memo' => '退勤時間登録最大値　※翌日9時を最大値とする。（飯田商事様要望）',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '0',
        ]);

        DB::table('mst_systemconfig')->insert([
            'systemconf_name' => 'HOLIDAY_PAST_MM',
            'systemconf_value' => 34,
            'memo' => '退勤時間登録最大値　※翌日9時を最大値とする。（飯田商事様要望）',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '0',
        ]);

        DB::table('mst_systemconfig')->insert([
            'systemconf_name' => 'HOLIDAY_APP_PAST_MM',
            'systemconf_value' => 1,
            'memo' => '休暇申請可能最大過去月',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '0',
        ]);

        DB::table('mst_systemconfig')->insert([
            'systemconf_name' => 'HOLIDAY_APP_FU_MM',
            'systemconf_value' => 3,
            'memo' => '休暇申請可能最大未来月',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '0',
        ]);
    }
}
