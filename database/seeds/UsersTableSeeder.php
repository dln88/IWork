<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert(array(
            'code'     => 'IWADMIN',
            'name'     => 'iWork Admin',
            'email'    => 'admin@i-work.jp',
            'role_id'  => 1, // Admin
            'password' => Hash::make('iwork@2020!'),
        ));
        $staffs = [];
        for ($i=1; $i<= 10; $i++) {
            $staffs[] = [
                'code'     => 'IWS' . $i,
                'name'     => 'Staff ' . $i,
                'email'    => "staff$i@i-work.jp",
                'role_id'  => 2, // Staff
                'password' => Hash::make('iwork'. $i),
            ];
        }

        DB::table('users')->insert($staffs);

    }
}
