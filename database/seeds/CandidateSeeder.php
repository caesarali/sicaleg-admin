<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\City;

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
            'level' => 'dprd',
            'dapil' => 'KOTA MAKASSAR 1',
            'locationable_type' => City::class,
            'locationable_id' => 7371,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
