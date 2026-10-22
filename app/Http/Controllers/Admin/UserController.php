<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $currentUser = auth()->user();
        $query = User::with('roles');

        // THE BLINDFOLD: Hide superiors based on who is logged in
        if ($currentUser->role === 'super_admin') {
            // Super Admins cannot see System Owners
            $query->where('role', '!=', 'System Owner');
        } elseif ($currentUser->role === 'admin') {
            // Regular Admins can ONLY see investors
            $query->where('role', 'investor');
        }

        $users = $query->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $currentUser = auth()->user();

        // THE BLINDFOLD: Only show roles beneath the current user
        if ($currentUser->hasRole('System Owner')) {
            $roles = Role::whereIn('name', ['super_admin', 'admin', 'investor'])->get();
        } elseif ($currentUser->role === 'super_admin') {
            $roles = Role::whereIn('name', ['admin', 'investor'])->get();
        } else {
            $roles = Role::whereIn('name', ['investor'])->get();
        }
        
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Ensure database column is updated
        ]);

        $user->assignRole($request->role);
        $user->markEmailAsVerified();

        return redirect()->route('users.index')->with('status', 'New user created successfully.');
    }

    public function edit(User $user)
    {
        $currentUser = auth()->user();

        // Security Check: Prevent lower roles from manually typing a URL to edit superiors
        if ($currentUser->role === 'admin' && $user->role !== 'investor') {
            abort(403, 'You are not authorized to edit this user.');
        }
        if ($currentUser->role === 'super_admin' && $user->hasRole('System Owner')) {
            abort(403, 'You are not authorized to edit the System Owner.');
        }

        // Dropdown blindfold
        if ($currentUser->hasRole('System Owner')) {
            $roles = Role::whereIn('name', ['super_admin', 'admin', 'investor'])->get();
        } elseif ($currentUser->role === 'super_admin') {
            $roles = Role::whereIn('name', ['admin', 'investor'])->get();
        } else {
            $roles = Role::whereIn('name', ['investor'])->get();
        }

        $permissions = Permission::all();
        return view('admin.users.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array',
            'permissions' => 'array',
        ]);

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
            // Keep the database text column in sync with Spatie
            $user->role = $request->roles[0]; 
            $user->save();
        } else {
            $user->syncRoles([]);
        }

        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        } else {
            $user->syncPermissions([]);
        }

        return redirect()->route('users.index')->with('status', 'User updated successfully.');
    }

    public function suspend($id)
    {
        if (!auth()->user()->hasRole('System Owner')) {
            abort(403, 'Only the System Owner can suspend users.');
        }
        $user = User::findOrFail($id);
        $user->status = 'frozen';
        $user->save();
        return back()->with('status', "User {$user->name} has been suspended.");
    }

    public function restore($id)
    {
        if (!auth()->user()->hasRole('System Owner')) {
            abort(403, 'Only the System Owner can restore users.');
        }
        $user = User::findOrFail($id);
        $user->status = 'active';
        $user->save();
        return back()->with('status', "User {$user->name} has been restored.");
    }
}