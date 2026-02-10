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
        User::updateOrCreate(
            ['email' => 'kwamerahman83@gmail.com'],
            [
                'name' => 'Kwame Rahman',
                'role' => 'super_admin',
                'status' => 'active',
                'password' => Hash::make('CastleRoyal2026!'),
                'email_verified_at' => Carbon::now(),
            ]
        );
        
        $this->command->info("Super Admin seeded successfully: kwamerahman83@gmail.com");
    }
}
