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
        // Assumption: These fields are updated by the Admin when an investment occurs
        $totalInvested = $user->total_invested ?? 0.00;
        $activeAcres = $user->active_acres ?? 0.0;
        $projectedRoi = $user->projected_roi ?? 0.0; // This should be a value (e.g. 2500), not a percentage if you want to display % calculation.
                                                     // But based on the view, it seems we display this directly.

        // Fetch Investment History
        $investments = $user->investments()->with('package')->latest()->get();

        return view('dashboard', compact('user', 'totalInvested', 'activeAcres', 'projectedRoi', 'investments'));
    }
}