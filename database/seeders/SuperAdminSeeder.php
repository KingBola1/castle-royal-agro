<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'kwamerahman83@gmail.com';
        
        $user = User::where('email', $email)->first();

        if ($user) {
            // Force update existing user
            $user->update([
                'role' => 'super_admin',
                'status' => 'active',
                'email_verified_at' => Carbon::now(),
            ]);
            $this->command->info("Super Admin updated: $email");
        } else {
            // Create new user
            User::create([
                'name' => 'Super Admin',
                'email' => $email,
                'password' => Hash::make('CastleRoyal@2026!'), // Secure placeholder
                'role' => 'super_admin',
                'status' => 'active',
                'email_verified_at' => Carbon::now(),
            ]);
            $this->command->info("Super Admin created: $email");
        }
    }
}
