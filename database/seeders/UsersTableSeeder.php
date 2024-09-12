<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 2; $i++) {
            $userData = [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'school_id' => '07102296',
                'organization_id' => $faker->numberBetween(1, 3), // Ensure valid ID from organizations table
                'course_id' => $faker->numberBetween(1, 4), // Ensure valid ID from courses table
                'year_id' => $faker->numberBetween(1, 3), // Ensure valid ID from years table
                'image' => $faker->imageUrl(),
                'barcode_image' => $faker->imageUrl(),
                'password' => bcrypt('password'), // Hash passwords
            ];

            DB::table('users')->insert($userData);
        }
    }
}
