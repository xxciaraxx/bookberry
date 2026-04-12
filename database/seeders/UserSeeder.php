<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin Account (seeded, cannot register) ────────
        User::updateOrCreate(
            ['email' => 'admin@bookberry.com'],
            [
                'name'              => 'BookBerry Admin',
                'password'          => Hash::make('Admin@1234!'),   // Meets all password rules
                'is_admin'          => true,
                'email_verified_at' => now(),
            ]
        );

        // ── Sample Customer Account ─────────────────────────
        User::updateOrCreate(
            ['email' => 'customer@bookberry.com'],
            [
                'name'              => 'Juan dela Cruz',
                'password'          => Hash::make('Customer@1234!'), // Meets all password rules
                'is_admin'          => false,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('');
        $this->command->info('✅ Users seeded:');
        $this->command->info('   Admin    → admin@bookberry.com    / Admin@1234!');
        $this->command->info('   Customer → customer@bookberry.com / Customer@1234!');
        $this->command->info('');
        $this->command->info('Password rules enforced on registration:');
        $this->command->info('   • Minimum 8 characters');
        $this->command->info('   • At least one uppercase letter');
        $this->command->info('   • At least one lowercase letter');
        $this->command->info('   • At least one number');
        $this->command->info('   • At least one special character (!@#$%^&*...)');
    }
}