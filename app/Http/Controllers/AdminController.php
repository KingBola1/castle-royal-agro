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
            'total_invested' => ['nullable', 'numeric', 'min:0'],
            'active_acres' => ['nullable', 'numeric', 'min:0'],
            'projected_roi' => ['nullable', 'numeric', 'min:0'],
        ]);

        // Explicitly Update Fields
        $user->role = $request->role;
        $user->status = $request->status;
        
        // THE FIX: Use 'input' with a default value of 0
        $user->total_invested = $request->input('total_invested', 0);
        $user->active_acres = $request->input('active_acres', 0);
        $user->projected_roi = $request->input('projected_roi', 0);

        $user->save();

        return redirect()->route('admin.users.show', $user->id)
            ->with('status', 'User updated successfully!');
    }

    // 4. Add New Investment (Receipt)
    public function invest(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'acres' => 'required|numeric|min:0',
            'roi_percentage' => 'required|numeric|min:0',
        ]);

        // 1. Create the Receipt
        $user->investments()->create([
            'amount' => $request->amount,
            'acres' => $request->acres,
            'status' => 'active',
        ]);

        // 2. Calculate Profit based on Input Percentage
        // Example: 1000 * (40 / 100) = 400 Profit. Total ROI = 1400 (if you want principal + profit)
        // OR just Profit. Let's assume Projected ROI = Pure Profit for now.
        $profit = $request->amount * ($request->roi_percentage / 100);

        // 3. Update User Totals
        $user->increment('total_invested', $request->amount);
        $user->increment('active_acres', $request->acres);
        $user->increment('projected_roi', ($request->amount + $profit)); // Total Cash Return

        return redirect()->back()->with('status', 'Investment added successfully!');
    }
}
