<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $roleName = 'Super Admin';
        $email = 'kwamerahman83@gmail.com';

        // 1. Ensure 'Super Admin' role exists
        $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);

        // 2. Find the user
        $user = User::where('email', $email)->first();

        if ($user) {
            // 3. Gracefully try to remove old roles if they exist
            // effectively 'cleaning' the user's roles before assigning the correct one
            $user->syncRoles([$role]); 
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
