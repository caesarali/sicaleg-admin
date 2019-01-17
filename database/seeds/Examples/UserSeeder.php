<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Caesar Ali L.',
            'username' => 'caesarali',
            'email' => 'caesaralilamondo@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('caesarali'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 1,
        ]);
    }
}
