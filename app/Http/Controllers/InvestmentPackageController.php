<?php

namespace App\Http\Controllers;

use App\Models\InvestmentPackage;
use Illuminate\Http\Request;

class InvestmentPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = InvestmentPackage::all();
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'roi_percentage' => 'required|numeric|min:0',
            'acres' => 'nullable|numeric|min:0',
        ]);

        // Default duration to 12 months for now
        $validated['duration_months'] = 12;

        InvestmentPackage::create($validated);

        return redirect()->back()->with('status', 'Package created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $package = InvestmentPackage::findOrFail($id);
        $package->delete();

        return redirect()->back()->with('status', 'Package deleted successfully.');
    }
}
