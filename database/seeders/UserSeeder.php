<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = '123'; // Replace with your desired password

        DB::table('users')->insert([
            [
                'name' => 'Manager',
                'email' => 'manager@example.com',
                'password' => Hash::make($password), // Hash the password
                'role' => 2, // Manager role
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make($password), // Hash the password
                'role' => 1, // Admin role
            ],
            [
                'name' => 'Cashier',
                'email' => 'cashier@example.com',
                'password' => Hash::make($password), // Hash the password
                'role' => 0, // Cashier role
            ],
        ]);
    }
}
