<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScreenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mst_screen')->insert([
            'screen_id' => 'H000001',
            'screen_name' => '休暇登録',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '',
        ]);

        DB::table('mst_screen')->insert([
            'screen_id' => 'Z000001',
            'screen_name' => 'ログイン',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '',
        ]);

        DB::table('mst_screen')->insert([
            'screen_id' => 'W000001',
            'screen_name' => '勤怠一覧',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '',
        ]);

        DB::table('mst_screen')->insert([
            'screen_id' => 'W000002',
            'screen_name' => '勤怠集計_管理',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '',
        ]);

        DB::table('mst_screen')->insert([
            'screen_id' => 'W000003',
            'screen_name' => '勤怠一覧_管理',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '',
        ]);
    }
}
