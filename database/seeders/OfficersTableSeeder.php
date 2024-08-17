<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OfficersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {
            DB::table('officers')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'role_id' =>  $faker->numberBetween(1, 10),
                'image' => $faker->imageUrl(),
                'password' => bcrypt('password'),
                // Add other relevant fields as needed
            ]);
        }
    }
}
