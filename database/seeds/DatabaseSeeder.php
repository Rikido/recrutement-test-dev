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
        
        // locationデータ登録
        factory(App\Location::class, 10)
            ->create();

        // resourceデータ登録
        // vehicleデータ登録
        $this->call([
            ResourcesTableSeeder::class,
            VehiclesTableSeeder::class,
            ResourceStocksTableSeeder::class,
        ]);
        
        // groupにuserを所属
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
