<?php

use Illuminate\Database\Seeder;
// 追記
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 51,
            'name' => 'ゲストユーザー',
            'email' => 'guest@example.com',
            'password' => '123456789',
        ]);
    }
}
