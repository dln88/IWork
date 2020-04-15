<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mst_special_role')->insert([
            'special_role_key' => 'user',
            'special_role_name' => 'user',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '0',
        ]);

        DB::table('mst_special_role')->insert([
            'special_role_key' => 'admin',
            'special_role_name' => 'admin',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '0',
        ]);

        DB::table('mst_post')->insert([
            'post_cd' => '1',
            'post_name' => 'php',
            'post_start_time' => '08:00',
            'post_end_time' => '18:00',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '0',
        ]);

        for ($i=1; $i <= 10; $i++) { 
            DB::table('mst_operator')->insert([
                'operator_cd' => $i,
                'emp_no' => 'no' .$i,
                'operator_last_name' => $i,
                'operator_first_name' => 'user',
                'operator_name_kana' => 'kana' .$i,
                'user_id' => 'user' .$i,
                'password' => 'password' .$i,
                'join_day' => '2020-04-01',
                'post_cd' => 1,
                'admin_div' => 0,
                'create_date' => '2020-04-01',
                'update_date' => '2020-04-01',
                'update_app' => '0',
            ]);
        }

        for ($i=11; $i <= 20; $i++) { 
            DB::table('mst_operator')->insert([
                'operator_cd' => $i,
                'emp_no' => 'no' .$i,
                'operator_last_name' => $i,
                'operator_first_name' => 'user',
                'operator_name_kana' => 'kana' .$i,
                'user_id' => 'admin' .$i,
                'password' => 'password' .$i,
                'join_day' => '2020-04-01',
                'post_cd' => 1,
                'admin_div' => 1,
                'create_date' => '2020-04-01',
                'update_date' => '2020-04-01',
                'update_app' => '0',
            ]);
        }

        for ($i=1; $i <= 10; $i++) { 
            DB::table('mst_operator_special_role')->insert([
                'operator_cd' => $i,
                'special_role_key' => 'user',
                'create_date' => '2020-04-01',
                'update_date' => '2020-04-01',
                'update_app' => '0',
            ]);
        }

        for ($i=11; $i <= 20; $i++) { 
            DB::table('mst_operator_special_role')->insert([
                'operator_cd' => $i,
                'special_role_key' => 'admin',
                'create_date' => '2020-04-01',
                'update_date' => '2020-04-01',
                'update_app' => '0',
            ]);
        }
    }
}
