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
        // $this->call(UsersTableSeeder::class);

        // userデータを50件登録
        factory(App\User::class, 50)
        ->create();

        // 登録したuserデータを全抽出
        $users = App\User::all();

        // groupにuserを所属させる
        // groupを6件登録
        factory(App\Group::class, 6)
        ->create()
        ->each(function ($group) use ($users) {
            $group->users()->attach(
                // group1件ごとに、userデータを5〜6個ランダムでattach()する
                $users->random(rand(5,6))->pluck('id')->toArray()
                );
        });
    }
}
