<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            [
                'group_id' => 7,
                'user_id' => 51,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'group_id' => 8,
                'user_id' => 51,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'group_id' => 8,
                'user_id' => 52,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'group_id' => 9,
                'user_id' => 52,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
