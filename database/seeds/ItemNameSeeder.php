<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mst_item')->insert([
            'item_name_cd' => 1,
            'item_name' => 'HOLIDAY_FORM',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '',
        ]);
        DB::table('mst_item')->insert([
            'item_name_cd' => 2,
            'item_name' => 'HOLIDAY_CLASS',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '',
        ]);
        
        DB::table('mst_itemname')->insert([
            'item_name_cd' => 1,
            'item_name_value' => 1,
            'item_name' => '有休',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '',
        ]);

        DB::table('mst_itemname')->insert([
            'item_name_cd' => 1,
            'item_name_value' => 2,
            'item_name' => '振休',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '',
        ]);

        DB::table('mst_itemname')->insert([
            'item_name_cd' => 1,
            'item_name_value' => 3,
            'item_name' => '特休',
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '',
        ]);

        DB::table('mst_itemname')->insert([
            'item_name_cd' => 2,
            'item_name_value' => 1,
            'item_name' => '全日休暇',
            'item_num' => 1,
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '',
        ]);

        DB::table('mst_itemname')->insert([
            'item_name_cd' => 2,
            'item_name_value' => 2,
            'item_name' => '午前休暇',
            'item_num' => 0.5,
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '',
        ]);

        DB::table('mst_itemname')->insert([
            'item_name_cd' => 2,
            'item_name_value' => 3,
            'item_name' => '午後休暇',
            'item_num' => 0.5,
            'create_date' => '2020-04-01',
            'update_date' => '2020-04-01',
            'update_app' => '',
        ]);

    }
}
