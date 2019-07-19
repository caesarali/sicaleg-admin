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
        $this->call('Laravolt\Indonesia\Seeds\DatabaseSeeder');
        $this->call(RolesSeeder::class);
        $this->call(CandidateLevelsSeeder::class);
        $this->call(DisabilitiesSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CandidateSeeder::class);
    }
}
