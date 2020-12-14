<?php

use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    
    public function run()
    {       
        
        for ($i = 1; $i <= 30; $i++) {
            DB::table('items')->insert([
                [
                    'item_name' => '部材' . $i, 
                    'created_at' => now(),
                    'updated_at' => now(),
                ],    
            ]);
        }
    }
}

