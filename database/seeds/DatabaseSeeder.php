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

        // userデータ登録
        factory(App\User::class, 30)
        ->create();

        // 登録したuserデータを全抽出
        $users = App\User::all();

        // groupにuserを所属させる
        factory(App\Group::class, 10)
        ->create()
        ->each(function ($group) use ($users) {
            $group->users()->attach(
                // 5～7個のuserをgroupにランダムに紐づけ
                $users->random(rand(5,7))->pluck('id')->toArray()
                );
        });
    }
}
