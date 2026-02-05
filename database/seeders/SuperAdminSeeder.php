<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::find(1);
        if ($user) {
            $user->role = 'super_admin';
            $user->save();
            $this->command->info("User ID 1 ({$user->name}) has been promoted to Super Admin.");
        } else {
            $this->command->error("User ID 1 not found. Please register a user first.");
        }
    }
}
