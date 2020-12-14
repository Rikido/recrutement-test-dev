<?php

use Illuminate\Database\Seeder;

class ReceiptsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 3; $i++) {
            for ($n = 1; $n <= 5; $n++) {
                DB::table('receipts')->insert([
                    [
                        'item_id' => $i, 
                        'num' => rand(5, 10) * 10,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],    
                ]);
            }
        }
        for ($i = 4; $i <= 15; $i++) {
            for ($n = 1; $n <= 3; $n++) {
                DB::table('receipts')->insert([
                    [
                        'item_id' => $i, 
                        'num' => rand(5, 10) * 15,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],    
                ]);
            }
        }
    }
}
