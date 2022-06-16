<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->insert([
            [
                'location_name' => '拠点A',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'location_name' => '拠点B',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'location_name' => '拠点C',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'location_name' => '拠点D',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'location_name' => '拠点E',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}