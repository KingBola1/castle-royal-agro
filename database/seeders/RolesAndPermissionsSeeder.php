<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Force clear the Spatie RAM cache so it doesn't get confused
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Explicitly create permissions using firstOrCreate and the 'web' guard
        Permission::firstOrCreate(['name' => 'manage users', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'view financials', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'edit projects', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'view own portfolio', 'guard_name' => 'web']);

        // 3. Create roles and safely assign permissions
        $investorRole = Role::firstOrCreate(['name' => 'investor', 'guard_name' => 'web']);
        $investorRole->givePermissionTo('view own portfolio');

        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo(['manage users', 'edit projects']);

        // 4. Ensure Canonical Super Admin exists (matching your migrations)
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);

        // 5. Safely assign to user if they exist at this stage
        $user = User::where('email', 'kwamerahman83@gmail.com')->first();
        if ($user) {
            $user->assignRole($superAdminRole);
        }
    }
}