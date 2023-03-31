<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        $users = [
            [
                'password' => Hash::make('12345'),
                'email' => $faker->unique()->safeEmail(),
                'name' => $faker->name,
                'role_id' => 1,
            ],
            [
                'password' => Hash::make('12345'),
                'email' => $faker->unique()->safeEmail(),
                'name' => $faker->name,
                'role_id' => 1,
            ],
        ];

      
        DB::table('users')->insert($users);
    }
}
