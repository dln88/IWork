<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ScreenSeeder::class);
        $this->call(SystemConfigSeeder::class);
        $this->call(PostCDSeeder::class);
        $this->call(ItemNameSeeder::class);
        $this->call(LoginSeeder::class);
        $this->call(CalendarSeeder::class);
        $this->call(PaidVacationSeeder::class);
        $this->call(ExchangeDaySeeder::class);
    }
}
