<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fees;
use App\Models\Semester; // Ensure to include the Semester model
use Faker\Factory as Faker;

class FeesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Assuming you have some semesters already in the database
        $semesterIds = Semester::pluck('id')->toArray();

        foreach (range(1, 20) as $index) {
            Fees::create([
                'name' => $faker->word . ' Fee',
                'default_amount' => $faker->randomFloat(2, 100, 1000), // Random amount between 100 and 1000
                'semester_id' => $faker->randomElement($semesterIds),
                'school_year' => $faker->year,
            ]);
        }
    }
}
