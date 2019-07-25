<?php

use Illuminate\Database\Seeder;
use App\Models\Voter;
use App\Models\Village;

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
                'locationable_type' => Village::class,
                'locationable_id' => $item->tps->village_id,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ];
        });

        DB::table('supporters')->insert($voters->toArray());
    }
}
