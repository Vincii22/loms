<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            OrganizationsTableSeeder::class,
            YearsTableSeeder::class,
            RolesTableSeeder::class,
            CoursesTableSeeder::class,
            SemestersTableSeeder::class,
            UsersTableSeeder::class,
            OfficersTableSeeder::class,
            AdminTableSeeder::class,
            ActivitiesTableSeeder::class,
            FeesTableSeeder::class
            // Add other seeders here
        ]);
    }
}
