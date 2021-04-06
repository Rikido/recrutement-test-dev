<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            [
                'id' => 7,
                'group_name' => 'テストグループ1',
            ],
            [
                'id' => 8,
                'group_name' => 'テストグループ2',
            ],
        ]);
    }
}
