<?php

use Illuminate\Database\Seeder;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $group = new \App\Group([
            'group_name' => 'グループA'
        ]);
        $group->save();

        $group = new \App\Group([
            'group_name' => 'グループB'
        ]);
        $group->save();

        $group = new \App\Group([
            'group_name' => 'グループC'
        ]);
        $group->save();

        $group = new \App\Group([
            'group_name' => 'グループD'
        ]);
        $group->save();

        $group = new \App\Group([
            'group_name' => 'グループE'
        ]);
        $group->save();
    }
}
