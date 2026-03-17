<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Position::create([
            'name' => 'Admin',
            'division_id' => 1,
        ]);

        Position::create([
            'division_id' => 1,
            'name' => 'Fullstack Developer',
        ]);

        Position::create([
            'division_id' => 1,
            'name' => 'System Administrator',
        ]);


        Position::create([
            'division_id' => 2,
            'name' => 'HR Manager',
        ]);

        Position::create([
            'division_id' => 3,
            'name' => 'Accountant',
        ]);
    }
}
