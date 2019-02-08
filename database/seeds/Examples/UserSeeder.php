<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Caesar Ali L.',
            'username' => 'caesarali',
            'email' => 'caesaralilamondo@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('caesarali'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $user->assignRole('superadmin');
    }
}
