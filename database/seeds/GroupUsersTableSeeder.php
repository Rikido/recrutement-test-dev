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
            [
                'group_id' => 8,
                'user_id' => 53,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'group_id' => 8,
                'user_id' => 54,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'group_id' => 8,
                'user_id' => 55,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'group_id' => 8,
                'user_id' => 56,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'group_id' => 8,
                'user_id' => 57,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'group_id' => 8,
                'user_id' => 58,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'group_id' => 8,
                'user_id' => 59,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'group_id' => 8,
                'user_id' => 60,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'group_id' => 8,
                'user_id' => 61,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'group_id' => 8,
                'user_id' => 62,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'group_id' => 8,
                'user_id' => 63,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'group_id' => 8,
                'user_id' => 64,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'group_id' => 8,
                'user_id' => 65,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
