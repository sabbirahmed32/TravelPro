<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@travelbiz.com'],
            [
                'name' => 'System Administrator',
                'email' => 'admin@travelbiz.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+1234567890',
                'address' => '123 Admin Street, Admin City, AC 12345',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@travelbiz.com'],
            [
                'name' => 'Test User',
                'email' => 'user@travelbiz.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '+1234567891',
                'address' => '123 User Street, User City, UC 12345',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin and test user created successfully!');
        $this->command->info('Admin: admin@travelbiz.com / password');
        $this->command->info('User: user@travelbiz.com / password');
    }
}