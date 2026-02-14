<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create the God Mode Role
        $systemOwner = Role::firstOrCreate(['name' => 'System Owner', 'guard_name' => 'web']);

        // 2. Find the CTD Master Account
        $ctdEmail = 'kwamerahman83@gmail.com';
        $user = User::where('email', $ctdEmail)->first();

        if ($user) {
            // 3. Assign the Role
            $user->assignRole($systemOwner);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
