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
        // Hashing passwords for security
        $managerPassword = Hash::make('password');
        $adminPassword = Hash::make('password');
        $cashierPassword = Hash::make('password');

        DB::table('users')->insert([
            [
                'name' => 'Manager',
                'email' => 'manager@example.com',
                'password' => $managerPassword,
                'role' => 2, // Manager role
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => $adminPassword,
                'role' => 1, // Admin role
            ],
            [
                'name' => 'Cashier',
                'email' => 'cashier@example.com',
                'password' => $cashierPassword,
                'role' => 0, // Cashier role
            ],
        ]);
    }
}
