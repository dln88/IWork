<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostCDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 10; $i++) { 
            DB::table('mst_post')->insert([
                'post_cd' => $i,
                'post_name' => 'Post CD ' . $i,
                'post_start_time' => '09:00:00',
                'post_end_time' => '18:00:00',
                'create_date' => '2020-04-16',
                'update_date' => '2020-04-16',
                'update_app' => '',
            ]);
        }
    }
}
