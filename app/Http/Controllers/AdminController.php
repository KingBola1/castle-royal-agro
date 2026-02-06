<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // 1. Show the Dashboard
    public function index()
    {
        // Get all users, ordered by newest first
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.dashboard', compact('users'));
    }

    // 2. Show the "Manage User" Page
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    // 3. Update the User (THE FIX)
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Security: Prevent lower-level admins from editing Super Admins
        if ($user->role === 'super_admin' && Auth::user()->id !== $user->id) {
             return redirect()->back()->with('error', 'You cannot edit a Super Admin.');
        }

        // Validate inputs (Simple and Permissive)
        $validated = $request->validate([
            'role' => ['required', 'string', 'in:investor,admin,super_admin'],
            'status' => ['required', 'string', 'in:active,frozen,blocked'],
        ]);

        // Explicitly Update Fields
        $user->role = $request->role;
        $user->status = $request->status;
        $user->save(); // Force the write to database

        return redirect()->route('admin.users.show', $user->id)
            ->with('status', 'User updated successfully!');
    }
}
