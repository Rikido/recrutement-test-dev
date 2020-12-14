<?php

use Illuminate\Database\Seeder;

class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 3; $i++) {
            for ($n = 1; $n <= 10; $n++) {
                DB::table('purchases')->insert([
                    [
                        'item_id' => $i, 
                        'num' => rand(1, 10) * 10,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],    
                ]);
            }
        }
        for ($i = 4; $i <= 15; $i++) {
            for ($n = 1; $n <= 5; $n++) {
                DB::table('purchases')->insert([
                    [
                        'item_id' => $i, 
                        'num' => rand(10, 15) * 15,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],    
                ]);
            }
        }
    }
}
