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
            [
                'id' => 53,
                'name' => 'ゲストユーザー3',
                'email' => 'guest3@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password3'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 54,
                'name' => 'ゲストユーザー4',
                'email' => 'guest4@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password4'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 55,
                'name' => 'ゲストユーザー5',
                'email' => 'guest5@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password5'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 56,
                'name' => 'ゲストユーザー6',
                'email' => 'guest6@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password6'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 57,
                'name' => 'ゲストユーザー7',
                'email' => 'guest7@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password7'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 58,
                'name' => 'ゲストユーザー8',
                'email' => 'guest8@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password8'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 59,
                'name' => 'ゲストユーザー9',
                'email' => 'guest9@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password9'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 60,
                'name' => 'ゲストユーザー10',
                'email' => 'guest10@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password10'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
