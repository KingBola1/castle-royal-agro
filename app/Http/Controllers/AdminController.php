<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::paginate(10);
        return view('admin.dashboard', compact('users'));
    }

    public function show(\App\Models\User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function update(Request $request, \App\Models\User $user)
    {
        $request->validate([
            'role' => 'required|in:investor,admin,super_admin',
            'status' => 'required|in:active,frozen,blocked',
        ]);

        // Hierarchy Check: Prevent admins from editing super admins
        if (auth()->user()->role !== 'super_admin' && $user->role === 'super_admin') {
            return redirect()->back()->with('error', 'You cannot modify a Super Admin.');
        }

        $user->update([
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'User updated successfully.');
    }
}
