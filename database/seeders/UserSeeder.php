<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Str;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $genders = ['male', 'female'];

        for ($i = 0; $i < 15; $i++) {
            $name = $faker->name();
            $email = strtolower($faker->unique()->safeEmail());
            $gender = $genders[array_rand($genders)];

            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('Password1!'), 
                'gender' => $gender,
                'avatar' => null,
                'role_id' => 2,
                'status' => true,
            ]);
        }
    }
}