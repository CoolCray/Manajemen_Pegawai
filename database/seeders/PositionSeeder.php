<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;
use App\Models\Division;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $it = Division::where('name', 'IT Department')->first();
        $hr = Division::where('name', 'Human Resources')->first();
        $finance = Division::where('name', 'Finance')->first();
        $marketing = Division::where('name', 'Marketing')->first();
        $ops = Division::where('name', 'Operations')->first();

        $positions = [
            ['name' => 'Software Engineer', 'division_id' => $it->id],
            ['name' => 'System Analyst', 'division_id' => $it->id],
            ['name' => 'IT Support', 'division_id' => $it->id],
            ['name' => 'HR Manager', 'division_id' => $hr->id],
            ['name' => 'Recruiter', 'division_id' => $hr->id],
            ['name' => 'Accountant', 'division_id' => $finance->id],
            ['name' => 'Financial Analyst', 'division_id' => $finance->id],
            ['name' => 'Marketing Specialist', 'division_id' => $marketing->id],
            ['name' => 'Content Creator', 'division_id' => $marketing->id],
            ['name' => 'Operations Manager', 'division_id' => $ops->id],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }
    }
}
