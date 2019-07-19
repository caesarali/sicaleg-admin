<?php

use Illuminate\Database\Seeder;
use App\Models\Voter;

class SupportersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $voters = Voter::all();
        $voters = $voters->map(function ($item) {
            return [
                'voter_id' => $item->id,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ];
        });

        DB::table('supporters')->insert($voters->toArray());
    }
}
