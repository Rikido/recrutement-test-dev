<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VehiclesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // vehicleデータ登録

        $weight_array = [ 1700, 1800, 1900, 2000 ];
        $size_array = [ 14, 16, 18 ];
        
        for ($i = 1; $i <= 25; $i++) {
            $weight_key = array_rand( $weight_array, 1 );
            $size_key = array_rand( $size_array, 1 );
            DB::table('vehicles')->insert([

                'max_weight' => $weight_array[$weight_key],
                'max_size'   => $size_array[$size_key],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                
            ]);
        };
    }
}
