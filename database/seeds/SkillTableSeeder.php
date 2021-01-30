<?php

use Illuminate\Database\Seeder;

class SkillTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skill = new \App\Skill([
            'skill_name' => '野球'
        ]);
        $skill->save();

        $skill = new \App\Skill([
            'skill_name' => 'サッカー'
        ]);
        $skill->save();

        $skill = new \App\Skill([
            'skill_name' => 'バレー'
        ]);
        $skill->save();

        $skill = new \App\Skill([
            'skill_name' => 'バスケ'
        ]);
        $skill->save();

        $skill = new \App\Skill([
            'skill_name' => 'テニス'
        ]);
        $skill->save();

        $skill = new \App\Skill([
            'skill_name' => 'ゴルフ'
        ]);
        $skill->save();

        $skill = new \App\Skill([
            'skill_name' => '空手'
        ]);
        $skill->save();

        $skill = new \App\Skill([
            'skill_name' => '運転手'
        ]);
        $skill->save();

        $skill = new \App\Skill([
            'skill_name' => 'バドミントン'
        ]);
        $skill->save();

        $skill = new \App\Skill([
            'skill_name' => 'ハンド'
        ]);
        $skill->save();
    }
}
