<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = [
            ['name' => 'CSIT'],
            ['name' => 'SLISS'],
            ['name' => 'PICE'],
            ['name' => 'IIEE']
        ];

        DB::table('organizations')->insert($organizations);
    }
}
