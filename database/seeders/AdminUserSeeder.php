<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin user already exists to avoid duplicates
        if (!User::where('email', 'admin@gmail.com')->exists()) {
            User::create([
                'name' => 'MOHD ADMIN',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('@dmin2O25'),
                'role' => 'ADMIN',
                'username' => 'admin',
                'email_verified_at' => now(),
            ]);

            $this->command->info('Admin user created successfully!');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}
