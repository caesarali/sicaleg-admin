<?php

use Illuminate\Database\Seeder;

class DisabilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ref_disabilities')->insert([
            ['id' => 1, 'name' => 'Tuna Daksa'],
            ['id' => 2, 'name' => 'Tuna Netra'],
            ['id' => 3, 'name' => 'Tuna Rungu/Wicara'],
            ['id' => 4, 'name' => 'Tuna Grahita'],
            ['id' => 5, 'name' => 'Disabilitas Lainnya']
        ]);
    }
}
