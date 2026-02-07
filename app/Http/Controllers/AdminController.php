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
        // Calculate Profit based on Input Percentage
        $profit = $request->amount * ($request->roi_percentage / 100);

        $user->investments()->create([
            'amount' => $request->amount,
            'acres' => $request->acres,
            'roi_percentage' => $request->roi_percentage, // SAVE THE %
            'projected_profit' => $profit,                // SAVE THE PROFIT
            'status' => 'active',
        ]);

        // 3. Update User Totals
        $user->increment('total_invested', $request->amount);
        $user->increment('active_acres', $request->acres);
        $user->increment('projected_roi', ($request->amount + $profit)); // Total Cash Return

        return redirect()->back()->with('status', 'Investment added successfully!');
    }
    // 5. Bulk ROI Adjustment (The Time Machine)
    public function bulkUpdateRoi(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'new_roi'    => 'required|numeric|min:0',
        ]);

        // 1. Find Investments in Range
        $investments = \App\Models\Investment::whereBetween('created_at', [
            $request->start_date . ' 00:00:00',
            $request->end_date . ' 23:59:59'
        ])->get();

        $count = $investments->count();
        $userIdsToSync = [];

        // 2. Loop & Update
        foreach ($investments as $inv) {
            $inv->roi_percentage = $request->new_roi;
            $inv->projected_profit = $inv->amount * ($request->new_roi / 100);
            $inv->save();

            if (!in_array($inv->user_id, $userIdsToSync)) {
                $userIdsToSync[] = $inv->user_id;
            }
        }

        // 3. Sync Users
        foreach ($userIdsToSync as $userId) {
            $user = User::find($userId);
            if ($user) {
                // Sum of all projected profits for this user
                $totalProfit = $user->investments()->sum('projected_profit');
                $user->projected_roi = $totalProfit; // Assuming 'projected_roi' stores the TOTAL sum
                // Note: If projected_roi is expected to be Principal + Profit, then:
                // $totalInvested = $user->investments()->sum('amount');
                // $user->projected_roi = $totalInvested + $totalProfit;
                // Based on previous step, we treated it as "Projected Cash Return" = Principal + Profit.
                 $totalInvested = $user->investments()->sum('amount');
                 $user->projected_roi = $totalInvested + $totalProfit;
                $user->save();
            }
        }

        return redirect()->back()->with('status', "Success! Updated {$count} investments and synced user totals.");
    }
}
