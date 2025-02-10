<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'email' => 'admin@example.com',
                'name' => 'Hà Xuân Phúc',
                'password' => Hash::make('password123'),
                'address' => '123 Admin Street',
                'status' => 1,
                'role' => true, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'staff1@example.com',
                'name' => 'Nguyễn Xuân Sang',
                'password' => Hash::make('password123'),
                'address' => '456 Staff Avenue',
                'status' => 1,
                'role' => false, // Staff
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'staff2@example.com',
                'name' => 'Nguyễn Xuân Hùng',
                'password' => Hash::make('password123'),
                'address' => '789 Staff Boulevard',
                'status' => 1,
                'role' => false, // Staff
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'staff3@example.com',
                'name' => 'Nguyễn Xuân Hùng',
                'password' => Hash::make('password123'),
                'address' => '101 Staff Lane',
                'status' => 1,
                'role' => false, // Staff
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'staff4@example.com',
                'name' => 'Nguyễn Xuân Hùng',
                'password' => Hash::make('password123'),
                'address' => '202 Staff Way',
                'status' => 1,
                'role' => false, // Staff
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
