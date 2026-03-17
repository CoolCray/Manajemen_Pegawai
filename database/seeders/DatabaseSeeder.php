<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        User::create([
            'username' => 'user',
            'password' => 'password',
            'email' => 'admin@example.com',
        ]);

        $this->call([
            DivitionSeeder::class,
            PositionSeeder::class,
        ]);

        Employee::create([
            'name' => 'Admin',
            'salary' => 1000000,
            'nip' => '1234567890',
            'address' => 'Jl. Admin',
            'phone' => '1234567890',
            'email' => 'admin@example.com',
            'position_id' => 1,
        ]);

        Employee::create([
            'name' => 'Admin',
            'salary' => 1000000,
            'nip' => '1234567890',
            'address' => 'Jl. Admin',
            'phone' => '1234567890',
            'email' => 'admin@example.com',
            'position_id' => 1,
        ]);


    }
}
