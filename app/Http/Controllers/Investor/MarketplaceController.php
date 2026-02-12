<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketplaceController extends Controller
{
    public function index()
    {
        // 1. Fetch only 'open' or 'active' packages (adjust logic based on your Status enum)
        // Assuming status can be 'open'
        $packages = Package::whereIn('status', ['open', 'active'])->latest()->get();
        return view('investor.marketplace.index', compact('packages'));
    }

    public function show(Package $package)
    {
        return view('investor.marketplace.show', compact('package'));
    }

    public function store(Request $request, Package $package)
    {
        // 1. Validate
        $request->validate([
            'units' => 'required|integer|min:1',
            'payment_reference' => 'required|string|max:255',
        ]);

        // 2. Calculate Total
        $totalAmount = $request->units * $package->price;
        
        // Calculate expected ROI
        // ROI is percentage of total amount. e.g. 10% of 1000 = 100. Total expected = 1100? Or just profit?
        // Usually ROI amount = Principal * (roi_percentage / 100).
        // Let's store the *profit* amount as expected_roi, or the total return?
        // Let's assume expected_roi is the PROFIT amount.
        $roiAmount = $totalAmount * ($package->roi_percentage / 100);


        // 3. Create Investment
        Investment::create([
            'user_id' => Auth::id(),
            'package_id' => $package->id,
            'units' => $request->units,
            'amount_invested' => $totalAmount,
            'expected_roi' => $roiAmount, // Storing purely the profit component
            'status' => 'pending', // Waiting admin approval
            'payment_reference' => $request->payment_reference,
        ]);

        // 4. Redirect
        return redirect()->route('dashboard')->with('status', 'Investment request submitted successfully! Pending approval.');
    }
}
