<?php

use Illuminate\Database\Seeder;
use App\Models\Allocate;

class AllocatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Allocate::class, 100)->create();
    }
}
