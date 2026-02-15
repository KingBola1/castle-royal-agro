<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // 1. Create the Permission
        $permission = \Spatie\Permission\Models\Permission::create(['name' => 'view_audit_logs']);

        // 2. Assign to System Owner (Super Admins get it manually later)
        $role = \Spatie\Permission\Models\Role::where('name', 'System Owner')->first();
        if ($role) {
            $role->givePermissionTo($permission);
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
