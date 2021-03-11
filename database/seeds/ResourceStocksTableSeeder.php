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
        // resource_stocksデータ登録

        for ($i = 1; $i <= 10; $i++) {
            $resource_stock = rand( 1, 100);
            DB::table('resource_stocks')->insert([
                'location_id' => $i,
                'resource_id' => 1,
                'stock'       => $resource_stock,
                'weight'      => $resource_stock * 760,
                'size'        => 17,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
