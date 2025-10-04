<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ResetPasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This seeder creates or resets passwords for ADMIN and PROVIDER users
     * New password: Passw0rd123
     */
    public function run(): void
    {
        $newPassword = 'Passw0rd123';
        $hashedPassword = Hash::make($newPassword);

        // ADMIN User - Create or Update
        $adminEmail = 'admin@gmail.com';
        $admin = User::where('email', $adminEmail)->first();

        if ($admin) {
            // Update existing ADMIN password
            $admin->password = $hashedPassword;
            $admin->status = 'active';
            $admin->save();
            $this->command->info('✅ ADMIN password UPDATED successfully!');
        } else {
            // Create new ADMIN user
            User::create([
                'name' => 'MOHD ADMIN',
                'email' => $adminEmail,
                'password' => $hashedPassword,
                'role' => 'ADMIN',
                'username' => 'admin',
                'status' => 'active',
                'phone' => '0126469256',
                'email_verified_at' => now(),
            ]);
            $this->command->info('✅ ADMIN user CREATED successfully!');
        }
        $this->command->info('   Email: ' . $adminEmail);
        $this->command->info('   Password: ' . $newPassword);

        // PROVIDER User - Create or Update
        $providerEmail = 'tombak@gmail.com';
        $provider = User::where('email', $providerEmail)->first();

        if ($provider) {
            // Update existing PROVIDER password
            $provider->password = $hashedPassword;
            $provider->status = 'active';
            $provider->save();
            $this->command->info('✅ PROVIDER password UPDATED successfully!');
        } else {
            // Create new PROVIDER user
            User::create([
                'name' => 'TOM TOMBAK',
                'email' => $providerEmail,
                'password' => $hashedPassword,
                'role' => 'PROVIDER',
                'username' => 'tombak',
                'status' => 'active',
                'phone' => '0126469256',
                'profile_image' => 'profile-images/tmQ5r1bq7eWumA14xHOLneKqdMY3YeKdIow...',
                'email_verified_at' => null,
            ]);
            $this->command->info('✅ PROVIDER user CREATED successfully!');
        }
        $this->command->info('   Email: ' . $providerEmail);
        $this->command->info('   Password: ' . $newPassword);

        $this->command->info('');
        $this->command->info('🔐 Password Reset Complete!');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('📧 ADMIN Login:');
        $this->command->info('   Email: ' . $adminEmail);
        $this->command->info('   Password: ' . $newPassword);
        $this->command->info('   Username: admin');
        $this->command->info('');
        $this->command->info('📧 PROVIDER Login:');
        $this->command->info('   Email: ' . $providerEmail);
        $this->command->info('   Password: ' . $newPassword);
        $this->command->info('   Username: tombak');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('');
        $this->command->info('💡 Total users in database: ' . User::count());
    }
}

