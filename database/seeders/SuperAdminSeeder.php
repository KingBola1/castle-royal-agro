<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure the Spatie roles exist
        Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $systemOwnerRole = Role::firstOrCreate(['name' => 'System Owner', 'guard_name' => 'web']);

        // 2. Create your user account
        $user = User::updateOrCreate(
            ['email' => 'kwamerahman83@gmail.com'],
            [
                'name' => 'Kwame Rahman',
                'role' => 'super_admin', // Keep the database column for backup
                'status' => 'active',
                'password' => Hash::make('CastleRoyal2026!'),
                'email_verified_at' => Carbon::now(),
            ]
        );
        
        // 3. THE FIX: Officially give your user the Spatie badge
        $user->assignRole($systemOwnerRole);
        $user->assignRole('super_admin');

        $this->command->info("Super Admin seeded and Spatie roles assigned successfully!");
    }
}