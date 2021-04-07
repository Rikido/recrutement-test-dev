<?php

use Illuminate\Database\Seeder;
// 追記
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

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
            [
                'id' => 51,
                'name' => 'ゲストユーザー',
                'email' => 'guest@example.com',
                'email_verified_at' => now(),
                // パスワードをbcryptで暗号化しなければログインできない
                'password' => bcrypt('123456789'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 52,
                'name' => 'ゲストユーザー2',
                'email' => 'guest2@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
