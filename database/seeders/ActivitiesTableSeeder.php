<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;
use App\Models\Semester; // Make sure to include the Semester model if you're using it
use Faker\Factory as Faker;

class ActivitiesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Assuming you have some semesters already in the database
        $semesterIds = Semester::pluck('id')->toArray();

        foreach (range(1, 20) as $index) {
            Activity::create([
                'name' => $faker->word,
                'description' => $faker->sentence,
                'start_time' => $faker->dateTimeBetween('-1 month', '+1 month'),
                'end_time' => $faker->dateTimeBetween('+1 month', '+2 months'),
                'location' => $faker->address,
                'semester_id' => $faker->randomElement($semesterIds),
                'school_year' => $faker->year,
                'image' => $faker->imageUrl(),
            ]);
        }
    }
}
