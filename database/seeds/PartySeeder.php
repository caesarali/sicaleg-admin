<?php

use Illuminate\Database\Seeder;

class PartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parties')->insert([
            'name' => 'ALC',
            'fullname' => 'Anti Lembur-lembur Club',
            'number' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
