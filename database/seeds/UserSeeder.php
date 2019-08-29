<?php

use Illuminate\Database\Seeder;
use App\Models\User;

use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $su = User::create([
            'name' => 'Caesar Ali L.',
            'username' => 'caesarali',
            'email' => 'caesaralilamondo@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('caesarali'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $su->assignRole('superadmin');

        $admin = User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@simcaleg',
            'email_verified_at' => now(),
            'password' => bcrypt('admin'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $admin->assignRole('admin');

        $faker = Faker::create('id_ID');
        for ($i=1; $i <= 10; $i++) {
            $user = User::create([
                'name' => 'Relawan ' . $i,
                'username' => 'relawan' . $i,
                'email' => 'relawan' . $i . '@simcaleg',
                'email_verified_at' => now(),
                'password' => bcrypt('relawan' . $i),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $user->assignRole('district-co');
            DB::table('volunteers')->insert([
                'name' => $user->name,
                'nik' => $this->generateCode(16),
                'address' => $faker->address,
                'phone' => '082293425786',
                'locationable_type' => 'App\Models\District',
                'locationable_id' => 7371031,
                'user_id' => $user->id,
                'created_by' => $su->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function generateCode($limit){
        $code = '';
        for($i = 0; $i < $limit; $i++) {
            $code .= mt_rand(0, 9);
        }
        return $code;
    }
}
