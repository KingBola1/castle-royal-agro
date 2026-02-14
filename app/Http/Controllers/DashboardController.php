<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Get the currently logged-in user
        $user = Auth::user();

        // Calculate Financials from the User Model
        // 1. Total Invested: Sum of ACTIVE investments
        $totalInvested = $user->investments()->where('status', 'active')->sum('amount_invested');

        // 2. Active Acres: Sum of units (acres) of ACTIVE investments
        // Note: 'units' column holds the acres/quantity
        $activeAcres = $user->investments()->where('status', 'active')->sum('units');

        // 3. Projected ROI: Unify Legacy and New Package Returns
        $legacyProjectedReturn = $user->projected_roi ?? 0.0;
        $packageRoi = $user->investments()->where('status', 'active')->sum('expected_roi');
        
        // Unified Total Projected Return
        $projectedRoi = $legacyProjectedReturn + $packageRoi;

        // 4. Total Withdrawn: Sum of APPROVED withdrawals (For Display)
        $totalWithdrawn = $user->withdrawals()->where('status', 'approved')->sum('amount');

        // 5. Total Amount Left (Available Balance)
        // This represents the true remaining funds: (Unified ROI - [Approved + Pending Withdrawals])
        $unavailableFunds = $user->withdrawals()->whereIn('status', ['approved', 'pending'])->sum('amount');
        $totalAmountLeft = max(0, $projectedRoi - $unavailableFunds);

        // Fetch Investment History
        $investments = $user->investments()->with('package')->latest()->get();

        return view('dashboard', compact('user', 'totalInvested', 'activeAcres', 'projectedRoi', 'totalWithdrawn', 'totalAmountLeft', 'investments'));
    }
}