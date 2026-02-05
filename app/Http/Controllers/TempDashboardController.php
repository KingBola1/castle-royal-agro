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

        // 2. Fetch their real investment data
        // We now have these fields in the 'users' table.
        $totalInvested = $user->total_invested ?? 0; 
        $activeAcres = $user->active_acres ?? 0;
        $projectedRoi = $user->projected_roi ?? 0;

        // 3. Send this data to the dashboard view
        return view('dashboard', compact('user', 'totalInvested', 'activeAcres', 'projectedRoi'));
    }
}