<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class YearsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $years = [
            ['name' => '1st Year'],
            ['name' => '2nd Year'],
            ['name' => '3rd Year'],
            ['name' => '4th Year'],
        ];

        DB::table('years')->insert($years);
    }
}
