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
        // userデータ登録
        factory(App\User::class, 60)
            ->create();

        // 登録した商品データを全抽出
        $users = App\User::all();

        factory(App\Group::class, 10)
            ->create()
            ->each(function ($group) use ($users) {
                $group->users()->attach(
                    $users->random(rand(4,6))->pluck('id')->toArray() // 4～6個のuserをorderにランダムに紐づけ
                );
            });
    }
}
