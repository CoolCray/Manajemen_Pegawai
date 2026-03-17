<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = ['IT Department', 'Human Resources', 'Finance', 'Marketing', 'Operations'];
        foreach ($divisions as $division) {
            \App\Models\Division::create(['name' => $division]);
        }
    }
}
