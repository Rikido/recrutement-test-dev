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
                // 拠点Aの資材
                'id' => 1,
                'location_id' => 1,
                'resource_id' => 1,
                'stock' => 50,
                'weight' => 200.0,
                'size' => 3.2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'location_id' => 1,
                'resource_id' => 2,
                'stock' => 10,
                'weight' => 1000.5,
                'size' => 6.9,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'location_id' => 1,
                'resource_id' => 3,
                'stock' => 100,
                'weight' => 100.0,
                'size' => 1.1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                // 拠点Bの資材
                'id' => 4,
                'location_id' => 2,
                'resource_id' => 1,
                'stock' => 10,
                'weight' => 200.0,
                'size' => 3.2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'location_id' => 2,
                'resource_id' => 2,
                'stock' => 30,
                'weight' => 1000.5,
                'size' => 6.9,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                // 拠点Cの資材
                'id' => 6,
                'location_id' => 3,
                'resource_id' => 2,
                'stock' => 12,
                'weight' => 1000.5,
                'size' => 6.9,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 7,
                'location_id' => 3,
                'resource_id' => 3,
                'stock' => 2,
                'weight' => 100.0,
                'size' => 1.1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                // 拠点Dの資材
                'id' => 8,
                'location_id' => 4,
                'resource_id' => 3,
                'stock' => 120,
                'weight' => 100.0,
                'size' => 1.1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                // 拠点Eの資材
                'id' => 9,
                'location_id' => 5,
                'resource_id' => 1,
                'stock' => 30,
                'weight' => 200.0,
                'size' => 3.2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 10,
                'location_id' => 5,
                'resource_id' => 2,
                'stock' => 15,
                'weight' => 1000.5,
                'size' => 6.9,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 11,
                'location_id' => 5,
                'resource_id' => 3,
                'stock' => 60,
                'weight' => 100.0,
                'size' => 1.1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
