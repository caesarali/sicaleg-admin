<?php

use Illuminate\Database\Seeder;

class CandidateLevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('candidate_levels')->insert([
            ['code' => 'dpr', 'name' => 'Caleg DPR'],
            ['code' => 'dprd', 'name' => 'Caleg DPRD']
        ]);
    }
}
