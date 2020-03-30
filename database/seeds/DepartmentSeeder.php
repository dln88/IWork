<?php

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('departments')->insert(array(
            'name'     => '設計部',
        ));
        DB::table('departments')->insert(array(
            'name'     => '設計部 1',
        ));
        DB::table('departments')->insert(array(
            'name'     => '設計部 2',
        ));
    }
}
