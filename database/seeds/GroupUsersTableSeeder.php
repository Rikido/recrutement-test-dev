<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('group_users')->insert([
            ['group_id' => 7, 'user_id' => 51],
            ['group_id' => 8, 'user_id' => 51],
        ]);
    }
}
