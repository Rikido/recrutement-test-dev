<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ResourceStocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('resource_stocks')->insert([
            [
                'location_id' => 1,
                'resource_id' => 1,
                'stock' => 10,
                'weight' => 100,
                'size' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'location_id' => 2,
                'resource_id' => 2,
                'stock' => 15,
                'weight' => 105,
                'size' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'location_id' => 3,
                'resource_id' => 1,
                'stock' => 30,
                'weight' => 200,
                'size' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'location_id' => 3,
                'resource_id' => 3,
                'stock' => 30,
                'weight' => 205,
                'size' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'location_id' => 4,
                'resource_id' => 4,
                'stock' => 30,
                'weight' => 200,
                'size' => 8,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'location_id' => 5,
                'resource_id' => 5,
                'stock' => 20,
                'weight' => 100,
                'size' => 8,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'location_id' => 5,
                'resource_id' => 6,
                'stock' => 30,
                'weight' => 100,
                'size' => 8,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
