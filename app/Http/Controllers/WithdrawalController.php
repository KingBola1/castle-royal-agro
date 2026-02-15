<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        // 1. Get Total Projected Return (Unified)
        $legacyProjectedReturn = $user->projected_roi ?? 0.0;
        $packageRoi = \App\Models\Investment::where('user_id', $user->id)
            ->where('status', 'active') // Only count active, approved investments
            ->sum('expected_roi');

        $projectedReturn = $legacyProjectedReturn + $packageRoi;

        // 2. Get Total Withdrawn AND Pending (to prevent spamming requests)
        $unavailableFunds = Withdrawal::where('user_id', $user->id)
            ->whereIn('status', ['approved', 'pending'])
            ->sum('amount');

        // 3. Calculate True Available Balance
        $availableBalance = max(0, $projectedReturn - $unavailableFunds);

        return view('withdrawals.create', compact('availableBalance'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // 1. Get Total Projected Return (Unified)
        $legacyProjectedReturn = $user->projected_roi ?? 0.0;
        $packageRoi = \App\Models\Investment::where('user_id', $user->id)
            ->where('status', 'active') // Only count active, approved investments
            ->sum('expected_roi');

        $projectedReturn = $legacyProjectedReturn + $packageRoi;

        // 2. Get Total Withdrawn AND Pending (to prevent spamming requests)
        $unavailableFunds = Withdrawal::where('user_id', $user->id)
            ->whereIn('status', ['approved', 'pending'])
            ->sum('amount');

        // 3. Calculate True Available Balance
        $availableBalance = max(0, $projectedReturn - $unavailableFunds);

        $request->validate([
            'amount' => ['required', 'numeric', 'min:1', 'max:' . $availableBalance],
            'payment_details' => 'required|string',
        ], [
            'amount.max' => 'You cannot withdraw more than your available balance of GH₵ ' . number_format($availableBalance, 2),
        ]);

        Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'payment_details' => $request->payment_details,
            'status' => 'pending',
        ]);

        // Non-Repudiation Logging (Investor Request)
        \App\Models\AuditLog::create([
            'user_id' => $user->id,
            'admin_id' => null, // Self-service action
            'action' => 'Withdrawal Requested',
            'details' => "Investor requested withdrawal of GH₵ " . number_format($request->amount, 2) . " via " . $request->payment_details,
        ]);

        return redirect()->route('dashboard')->with('status', 'Withdrawal request submitted successfully.');
    }
}
