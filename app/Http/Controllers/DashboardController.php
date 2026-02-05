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

        // 2. Fetch their real investment data (Placeholder logic for now)
        // Later, we will create an 'Investments' table to sum up real money.
        // For now, we set it to 0 or check if they have fields in the DB.
        $totalInvested = 0; 
        $activeAcres = 0;
        $projectedRoi = 0;

        // 3. Send this data to the dashboard view
        return view('dashboard', compact('user', 'totalInvested', 'activeAcres', 'projectedRoi'));
    }
}