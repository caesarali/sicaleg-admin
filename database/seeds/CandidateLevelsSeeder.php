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
            ['code' => 'dpr', 'name' => 'Caleg DPR', 'locationable' => 'App\Models\Province', 'locationable_child' => 'App\Models\City'],
            ['code' => 'dprd', 'name' => 'Caleg DPRD', 'locationable' => 'App\Models\City', 'locationable_child' => 'App\Models\District']
        ]);
    }
}
