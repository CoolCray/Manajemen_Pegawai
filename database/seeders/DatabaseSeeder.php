<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Initial Admin User
        User::create([
            'username' => 'admin',
            'password' => bcrypt('password'),
            'email' => 'admin@admin.com',
        ]);

        $this->call([
            DivisionSeeder::class,
            PositionSeeder::class,
            EmployeeSeeder::class,
        ]);
    }
}
