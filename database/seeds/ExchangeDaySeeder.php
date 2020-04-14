<?php

use Illuminate\Database\Seeder;

class ExchangeDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 20; $i++) { 
            DB::table('mst_exchange_day')->insert([
                'operator_cd' => $i,
                'grant_days' => 12,
                'target_start' => 20200101,
                'target_end' => 20210101,
                'create_date' => '2020-04-01',
                'update_date' => '2020-04-01',
                'update_app' => '0',
            ]);
        }
    }
}
