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

        //user登録
        factory(App\User::class, 30)->create();

        //groupにuserを所属させる
        $users = App\User::all();

        factory(App\Group::class, 5)
          ->create()
          ->each(function ($group) use ($users) {
              //中間テーブルに紐付け
              $group->users()->attach(
                  //3~5個のuserをgroupにランダムに紐付け
                  $users->random(rand(3,5))->pluck('id')->toArray()
              );
          });

          $this->call(ResourcesTableSeeder::class);
    }
}
