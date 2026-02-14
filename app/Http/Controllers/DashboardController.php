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

        // 3. Projected ROI: This could be complicated. 
        // For now, let's sum the 'expected_roi' of active investments? 
        // Or keep user->projected_roi if that's still relevant?
        // The user request didn't explicitly ask to change projected_roi logic, but total_invested logic.
        // Let's keep projectedRoi from the user model for now to avoid breaking it, OR sum it up if intended.
        // BUT, given we are calculating totalInvested dynamically, we should probably do the same for ROI if possible.
        // Let's stick to the REQUEST: "Update ... to accurately sum the user's active investments".
        // It didn't explicitly say "change projected roi", but "total invested".
        $projectedRoi = $user->projected_roi ?? 0.0; 

        // 4. Total Withdrawn: Sum of APPROVED withdrawals
        // Check if relationship exists first. Use 'withdrawals' relationship.
        $totalWithdrawn = $user->withdrawals()->where('status', 'approved')->sum('amount');

        // 5. Total Amount Left (Available Balance)
        // This represents the remaining funds available after withdrawals
        $totalAmountLeft = $projectedRoi - $totalWithdrawn;

        // Fetch Investment History
        $investments = $user->investments()->with('package')->latest()->get();

        return view('dashboard', compact('user', 'totalInvested', 'activeAcres', 'projectedRoi', 'totalWithdrawn', 'totalAmountLeft', 'investments'));
    }
}