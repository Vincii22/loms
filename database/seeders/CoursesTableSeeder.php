<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            ['name' => 'BSIT'],
            ['name' => 'BSCS'],
            ['name' => 'BLISS'],
            ['name' => 'BSCE'],
            ['name' => 'BSEE'],
        ];

        DB::table('courses')->insert($courses);
    }
}
