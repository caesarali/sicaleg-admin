<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesSeeder::class);
        $this->call(CandidateLevelsSeeder::class);
        $this->call(DisabilitiesSeeder::class);
        $this->call(MaritalStatusSeeder::class);
    }
}
