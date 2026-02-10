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
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'view financials']);
        Permission::create(['name' => 'edit projects']);
        Permission::create(['name' => 'view own portfolio']);

        // create roles and assign created permissions

        // Investor
        $role = Role::create(['name' => 'investor']);
        $role->givePermissionTo('view own portfolio');

        // Admin (Customizable)
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(['manage users', 'edit projects']);

        // Super Admin
        $role = Role::create(['name' => 'super_admin']);
        // Super Admin gets all permissions via Gate::before rule; see AuthServiceProvider/AppServiceProvider

        // Assign Super Admin role to specific user
        $user = User::where('email', 'kwamerahman83@gmail.com')->first();
        if ($user) {
            $user->assignRole('super_admin');
        }
    }
}
