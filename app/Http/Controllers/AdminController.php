<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Investment;
use App\Models\InvestmentPackage;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
        $packages = InvestmentPackage::all();
        $investments = $user->investments()->orderBy('created_at', 'desc')->get(); // Fetch investments
        $auditLogs = AuditLog::where('user_id', $user->id)->latest()->take(5)->get(); // Fetch logs

        return view('admin.users.show', compact('user', 'packages', 'investments', 'auditLogs'));
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

        // Capture Old State for Audit
        $oldRole = $user->role;
        $oldStatus = $user->status;

        // Explicitly Update Fields
        $user->role = $request->role;
        $user->status = $request->status;
        
        // THE FIX: Use 'input' with a default value of 0
        $user->total_invested = $request->input('total_invested', 0);
        $user->active_acres = $request->input('active_acres', 0);
        $user->projected_roi = $request->input('projected_roi', 0);

        $user->save();

        // Audit Log if Role or Status Changed
        if ($oldRole !== $user->role) {
            AuditLog::create([
                'user_id' => $user->id,
                'admin_id' => Auth::id(),
                'action' => 'Role Updated',
                'details' => "Changed role from $oldRole to {$user->role}",
            ]);
        }
        if ($oldStatus !== $user->status) {
            AuditLog::create([
                'user_id' => $user->id,
                'admin_id' => Auth::id(),
                'action' => 'Status Updated',
                'details' => "Changed status from $oldStatus to {$user->status}",
            ]);
        }

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
            'projected_profit' => 'nullable|numeric|min:0', 
            'package_name' => 'nullable|string|max:255',
        ]);

        // 1. Calculate Profit based on Input Percentage
        // Note: Adding support for 'projected_profit' input if available (e.g. from package logic), otherwise calc.
        // Actually, let's strictly calculate based on ROI % provided to ensure consistency.
        $profit = $request->amount * ($request->roi_percentage / 100);

        // 2. Create the Receipt
        $investment = $user->investments()->create([
            'package_name' => $request->package_name,
            'amount' => $request->amount,
            'acres' => $request->acres,
            'roi_percentage' => $request->roi_percentage, 
            'projected_profit' => $profit,
            'status' => 'active',
        ]);

        // 3. Update User Totals
        $user->increment('total_invested', $request->amount);
        $user->increment('active_acres', $request->acres);
        $user->increment('projected_roi', ($request->amount + $profit)); // Total Cash Return

        // 4. Audit Log
        AuditLog::create([
            'user_id' => $user->id,
            'admin_id' => Auth::id(),
            'action' => 'Investment Added',
            'details' => "Added Investment of GH₵ {$request->amount} ({$request->acres} acres).",
        ]);

        return redirect()->back()->with('status', 'Investment added successfully!');
    }

    /**
     * Force reset a user's password.
     */
    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $user = User::findOrFail($id);

        // Hash the password typed by the Admin
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', "Password successfully changed to: " . $request->password);
    }

    // 6. Update Existing Investment
    public function updateInvestment(Request $request, $id)
    {
        $investment = Investment::findOrFail($id);
        $user = $investment->user;

        $request->validate([
            'amount' => 'required|numeric|min:0',
            'acres' => 'required|numeric|min:0',
            'roi_percentage' => 'required|numeric|min:0',
        ]);

        // Calculate differences
        $amountDiff = $request->amount - $investment->amount;
        $acresDiff = $request->acres - $investment->acres;
        
        // New Profit
        $newProfit = $request->amount * ($request->roi_percentage / 100);
        $oldProfit = $investment->projected_profit;
        $profitDiff = $newProfit - $oldProfit;
        
        // Update Investment
        $investment->update([
            'amount' => $request->amount,
            'acres' => $request->acres,
            'roi_percentage' => $request->roi_percentage,
            'projected_profit' => $newProfit,
        ]);

        // Update User Totals
        if ($amountDiff != 0) $user->increment('total_invested', $amountDiff);
        if ($acresDiff != 0) $user->increment('active_acres', $acresDiff);
        
        // Update Projected ROI (Principal + Profit)
        // Total Diff = (NewPrincipal + NewProfit) - (OldPrincipal + OldProfit)
        //            = (AmountDiff) + (ProfitDiff)
        $totalRoiDiff = $amountDiff + $profitDiff;
        if ($totalRoiDiff != 0) $user->increment('projected_roi', $totalRoiDiff);

        // Audit Log
        AuditLog::create([
            'user_id' => $user->id,
            'admin_id' => Auth::id(),
            'action' => 'Investment Updated',
            'details' => "Updated Investment #{$investment->id}. Amount: {$amountDiff}, Acres: {$acresDiff}.",
        ]);

        return redirect()->back()->with('status', 'Investment updated successfully!');
    }

    // 7. Delete Investment (Soft Delete)
    public function destroyInvestment($id)
    {
        $investment = Investment::findOrFail($id);
        $user = $investment->user;

        // Recalculate User Totals (Subtract)
        $user->decrement('total_invested', $investment->amount);
        $user->decrement('active_acres', $investment->acres);
        $user->decrement('projected_roi', ($investment->amount + $investment->projected_profit));

        // Audit Log
        AuditLog::create([
            'user_id' => $user->id,
            'admin_id' => Auth::id(),
            'action' => 'Investment Deleted',
            'details' => "Deleted Investment #{$investment->id} of GH₵ {$investment->amount}.",
        ]);

        $investment->delete();

        return redirect()->back()->with('status', 'Investment deleted (soft) and totals adjusted.');
    }
    // 8. Bulk ROI Adjustment (Hybrid: Yield Per Acre OR Financial ROI)
    public function bulkUpdateRoi(Request $request)
    {
        $request->validate([
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after_or_equal:start_date',
            'calculation_method'=> 'required|in:per_acre,percentage',
            'declared_value'    => 'required|numeric|min:0',
        ]);

        // 1. Find Investments in Range
        $investments = \App\Models\Investment::whereBetween('created_at', [
            $request->start_date . ' 00:00:00',
            $request->end_date . ' 23:59:59'
        ])->get();

        $count = $investments->count();
        $userIdsToSync = [];

        // 2. Loop & Update based on Method
        foreach ($investments as $inv) {
            
            if ($request->calculation_method === 'percentage') {
                // Method A: Financial (ROI %)
                $roi_percent = $request->declared_value;
                $profit = $inv->amount * ($roi_percent / 100);

            } else {
                // Method B: Yield (GHS / Acre)
                $profit = $inv->acres * $request->declared_value;
                
                // Back-calculate % for record keeping
                $roi_percent = ($inv->amount > 0) ? ($profit / $inv->amount) * 100 : 0;
            }

            $inv->roi_percentage = $roi_percent;
            $inv->projected_profit = $profit;
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
                
                // Projected Cash Return = Principal + Profit
                $totalInvested = $user->investments()->sum('amount');
                $user->projected_roi = $totalInvested + $totalProfit;
                $user->save();
            }
        }

        return redirect()->back()->with('status', "Success! Updated {$count} investments using method: {$request->calculation_method}.");
    }
}
