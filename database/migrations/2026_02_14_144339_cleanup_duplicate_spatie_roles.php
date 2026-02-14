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
        // 1. Ensure Canonical Role Exists
        $canonicalRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);

        // 2. Find and Fix Duplicate 'Super_admin'
        $duplicateRole = Role::where('name', 'Super_admin')->first();

        if ($duplicateRole) {
            // Re-assign users from duplicate to canonical
            $users = User::role('Super_admin')->get();
            foreach ($users as $user) {
                // Remove old, assign new
                $user->removeRole($duplicateRole);
                $user->assignRole($canonicalRole);
            }
            
            // Delete the duplicate role
            $duplicateRole->delete();
        }

        // 3. Cleanup other potential typos if they exist (optional safety)
        $typos = ['super_admin', 'Superadmin', 'super admin']; // Add any others if known
        foreach ($typos as $typo) {
            $role = Role::where('name', $typo)->where('id', '!=', $canonicalRole->id)->first();
            if ($role) {
                // Re-assign users
                $users = User::role($typo)->get();
                foreach ($users as $user) {
                    $user->removeRole($role);
                    $user->assignRole($canonicalRole);
                }
                $role->delete();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse action needed for cleanup
    }
};
