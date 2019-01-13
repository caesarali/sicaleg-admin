<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'superadmin', 'display_name' => 'Superadmin'],
            ['name' => 'admin', 'display_name' => 'Administrator'],
            ['name' => 'province-co', 'display_name' => 'Kordinator Tingkat Provinsi'],
            ['name' => 'city-co', 'display_name' => 'Kordinator Tingkat Kab/Kota'],
            ['name' => 'district-co', 'display_name' => 'Kordinator Tingkat Kecamatan'],
            ['name' => 'village-co', 'display_name' => 'Kordinator Tingkat Desa'],
            ['name' => 'volunteer', 'display_name' => 'Relawan']
        ]);
    }
}
