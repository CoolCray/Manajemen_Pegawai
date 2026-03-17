<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Division;

class DivitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Division::create([
            'name' => 'IT',
        ]);

        Division::create([
            'name' => 'HR',
        ]);

        Division::create([
            'name' => 'Finance',
        ]);

        Division::create([
            'name' => 'Marketing',
        ]);

        Division::create([
            'name' => 'Sales',
        ]);
    }
}
