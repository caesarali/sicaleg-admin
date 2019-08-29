<?php

use Illuminate\Database\Seeder;

class DapilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('candidate_areas')->insert([
            ['locationable_type' => 'App\Models\District', 'locationable_id' => 7371031, 'created_at' => now(), 'updated_at' => now()],
            ['locationable_type' => 'App\Models\District', 'locationable_id' => 7371040, 'created_at' => now(), 'updated_at' => now()],
            ['locationable_type' => 'App\Models\District', 'locationable_id' => 7371050, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
