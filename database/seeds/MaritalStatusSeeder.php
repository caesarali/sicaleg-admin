<?php

use Illuminate\Database\Seeder;

class MaritalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ref_marital_statuses')->insert([
            ['code' => 'B', 'name' => 'Belum Menikah'],
            ['code' => 'S', 'name' => 'Menikah'],
            ['code' => 'P', 'name' => 'Pernah Menikah']
        ]);
    }
}
