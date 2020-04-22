<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create calendar for three months: three month, four month, five month.
        for ($i=1; $i <= 30; $i++) { 
            DB::table('mst_calendar')->insert([
                'calendar_ymd' => "2020-04-$i",
                'era' => 'era' .$i,
                'year_jp' => 2020,
                'legalholiday_flg' => 0,
                'nationalholiday_flg' => 0,
                'nationalholiday_name' => 'name ' .$i,
                'create_date' => '2020-04-01',
                'update_date' => '2020-04-01',
                'update_app' => '',
            ]);
        }
        for ($i=1; $i <= 30; $i++) { 
            DB::table('mst_calendar')->insert([
                'calendar_ymd' => "2020-03-$i",
                'era' => 'era' .$i,
                'year_jp' => 2020,
                'legalholiday_flg' => 0,
                'nationalholiday_flg' => 0,
                'nationalholiday_name' => 'name ' .$i,
                'create_date' => '2020-04-01',
                'update_date' => '2020-04-01',
                'update_app' => '',
            ]);
        }
        for ($i=1; $i <= 30; $i++) { 
            DB::table('mst_calendar')->insert([
                'calendar_ymd' => "2020-05-$i",
                'era' => 'era' .$i,
                'year_jp' => 2020,
                'legalholiday_flg' => 0,
                'nationalholiday_flg' => 0,
                'nationalholiday_name' => 'name ' .$i,
                'create_date' => '2020-04-01',
                'update_date' => '2020-04-01',
                'update_app' => '',
            ]);
        }
    }
}
