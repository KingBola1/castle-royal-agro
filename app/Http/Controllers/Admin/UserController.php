<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        $user->assignRole($request->role);
        $user->markEmailAsVerified(); // Auto-verify administrative staff

        return redirect()->route('users.index')->with('status', 'New staff member created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        
        return view('admin.users.edit', compact('user', 'roles', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array',
            'permissions' => 'array',
        ]);

        // Sync Roles
        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        } else {
            // If no roles selected, ensure we don't accidentally strip Super Admin if not allowed
            // Ideally explicit deselect
            $user->syncRoles([]);
        }

        // Sync Direct Permissions
        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        } else {
            $user->syncPermissions([]);
        }

        return redirect()->route('users.index')->with('status', 'User roles and permissions updated successfully.');
    }
    public function suspend($id)
    {
        if (!auth()->user()->hasRole('System Owner')) {
            abort(403, 'Only the System Owner can suspend users.');
        }

        $user = User::findOrFail($id);
        $user->status = 'banned';
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
