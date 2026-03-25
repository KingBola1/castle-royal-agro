<?php

namespace App\Http\Controllers;

use App\Models\InvestmentPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class InvestmentPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $packages = \App\Models\InvestmentPackage::paginate(10);
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'roi_percentage' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1',
            'status' => 'required|string',
            'image' => 'nullable|file|max:5120',
            'image_url' => 'nullable|string'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('packages', 'public');
        } elseif (!empty($validated['image_url'])) {
            $validated['image'] = $validated['image_url'];
        }

        unset($validated['image_url']);

        \App\Models\InvestmentPackage::create($validated);

        return redirect()->route('admin.packages.index')->with('status', 'Package created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $package = InvestmentPackage::findOrFail($id);
        
        // Optional: delete image from storage if it exists and is not a URL
        if ($package->image && !filter_var($package->image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($package->image);
        }

        $package->delete();

        return redirect()->back()->with('status', 'Package deleted successfully.');
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function edit(string $id)
    {
        $package = \App\Models\InvestmentPackage::findOrFail($id);
        return view('admin.packages.edit', compact('package'));
    }

    public function update(\Illuminate\Http\Request $request, string $id) {
        $package = \App\Models\InvestmentPackage::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'roi_percentage' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1',
            'status' => 'required|string',
            'image' => 'nullable|file|max:5120',
            'image_url' => 'nullable|string'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            // Delete old image if it's stored locally
            if ($package->image && !filter_var($package->image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($package->image);
            }
            $validated['image'] = $request->file('image')->store('packages', 'public');
        } elseif (!empty($validated['image_url'])) {
            $validated['image'] = $validated['image_url'];
        } else {
             // Keep the existing image if no new one or url is provided
             $validated['image'] = $package->image;
        }

        unset($validated['image_url']);

        $package->update($validated);

        return redirect()->route('admin.packages.index')->with('status', 'Package updated successfully.');
    }
}
