<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            ['name' => 'President'],
            ['name' => 'Internal Vice President'],
            ['name' => 'External Vice President'],
            ['name' => 'Secretary General'],
            ['name' => 'Deputy Secretary'],
            ['name' => 'Finance Officer'],
            ['name' => 'Deputy Finance'],
            ['name' => 'Deputy Secretary'],
            ['name' => 'Auditor'],
            ['name' => 'Public Information Officer'],
            ['name' => 'Business Manager'],
            ['name' => 'Creatives & Techincals Chairman'],
            ['name' => 'Creatives & Techincals Co-Chairman'],
            ['name' => 'CSITS COUNCILOR'],
            ['name' => 'CSITS COUNCILOR'],
            ['name' => 'CE COUNCILOR'],
            ['name' => 'CE COUNCILOR'],
            ['name' => 'EE COUNCILOR'],
            ['name' => 'EE COUNCILOR'],
            ['name' => 'BLIS COUNCILOR'],
            ['name' => 'BLIS COUNCILOR'],

        ];

        DB::table('roles')->insert($courses);
    }
}
