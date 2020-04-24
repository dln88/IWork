<?php

use Carbon\Carbon;
use App\Utils\Formula;
use Carbon\CarbonPeriod;
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

        // seed data for March
        $currentTimeTarget = Formula::calculateClosingDate(Carbon::parse('1 March 2020')->format('Ym'));
        $periodMarch = CarbonPeriod::create($currentTimeTarget[0], $currentTimeTarget[1]);
        foreach ($periodMarch as $date) {
            DB::table('mst_calendar')->insert([
                'calendar_ymd' => $date->format('Y-m-d'),
                'target_ym' => '202003',
                'era' => 'era ' . $date->format('d'),
                'year_jp' => Carbon::parse('1 March 2020')->format('Y'),
                'legalholiday_flg' => 0,
                'nationalholiday_flg' => 0,
                'nationalholiday_name' => 'name ' .$date->format('d'),
                'create_date' => $currentTimeTarget[0],
                'update_date' => $currentTimeTarget[1],
                'update_app' => '',
            ]);
        }

        // seed data for April
        $currentTimeTarget = Formula::calculateClosingDate(Carbon::parse('1 April 2020')->format('Ym'));
        $periodApril = CarbonPeriod::create($currentTimeTarget[0], $currentTimeTarget[1]);
        foreach ($periodApril as $date) {
            DB::table('mst_calendar')->insert([
                'calendar_ymd' => $date->format('Y-m-d'),
                'target_ym' => '202004',
                'era' => 'era ' . $date->format('d'),
                'year_jp' => Carbon::parse('1 April 2020')->format('Y'),
                'legalholiday_flg' => 0,
                'nationalholiday_flg' => 0,
                'nationalholiday_name' => 'name ' .$date->format('d'),
                'create_date' => $currentTimeTarget[0],
                'update_date' => $currentTimeTarget[1],
                'update_app' => '',
            ]);
        }

        // seed data for May
        $currentTimeTarget = Formula::calculateClosingDate(Carbon::parse('1 May 2020')->format('Ym'));
        $periodMay = CarbonPeriod::create($currentTimeTarget[0], $currentTimeTarget[1]);
        foreach ($periodMay as $date) {
            DB::table('mst_calendar')->insert([
                'calendar_ymd' => $date->format('Y-m-d'),
                'target_ym' => '202005',
                'era' => 'era ' . $date->format('d'),
                'year_jp' => Carbon::parse('1 May 2020')->format('Y'),
                'legalholiday_flg' => 0,
                'nationalholiday_flg' => 0,
                'nationalholiday_name' => 'name ' .$date->format('d'),
                'create_date' => $currentTimeTarget[0],
                'update_date' => $currentTimeTarget[1],
                'update_app' => '',
            ]);
        }

        // seed data for June.
        $currentTimeTarget = Formula::calculateClosingDate(Carbon::parse('1 June 2020')->format('Ym'));
        $periodJune = CarbonPeriod::create($currentTimeTarget[0], $currentTimeTarget[1]);
        foreach ($periodJune as $date) {
            DB::table('mst_calendar')->insert([
                'calendar_ymd' => $date->format('Y-m-d'),
                'target_ym' => '202006',
                'era' => 'era ' . $date->format('d'),
                'year_jp' => Carbon::parse('1 June 2020')->format('Y'),
                'legalholiday_flg' => 0,
                'nationalholiday_flg' => 0,
                'nationalholiday_name' => 'name ' .$date->format('d'),
                'create_date' => $currentTimeTarget[0],
                'update_date' => $currentTimeTarget[1],
                'update_app' => '',
            ]);
        }
    }
}
