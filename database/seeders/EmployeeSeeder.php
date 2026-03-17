<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = \App\Models\Position::all();
        $faker = \Faker\Factory::create('id_ID');

        for ($i = 0; $i < 50; $i++) {
            $position = $positions->random();
            \App\Models\Employee::create([
                'position_id' => $position->id,
                'name' => $faker->name,
                'nip' => $faker->unique()->numerify('199###### ###### # ###'),
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'salary' => $faker->numberBetween(5000000, 25000000),
                'join_date' => $faker->date('Y-m-d', 'now'),
            ]);
        }
    }
}
