<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Province;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('candidates')->insert([
            'name' => 'Caesar Ali L.',
            'number' => 2,
            'level_id' => 1,
            'locationable_type' => Province::class,
            'locationable_id' => 73,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
