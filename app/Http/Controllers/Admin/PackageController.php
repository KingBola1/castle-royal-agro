<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // FORCE PAGINATION: Ensure we return a LengthAwarePaginator, not a Collection
        $packages = Package::latest()->paginate(10);
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'roi_percentage' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1',
            'status' => 'required|in:draft,open,closed,sold_out',
            'image' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($request->name);
        $count = Package::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        Package::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'roi_percentage' => $request->roi_percentage,
            'duration_months' => $request->duration_months,
            'status' => $request->status,
            'image' => $request->image,
        ]);

        return redirect()->route('admin.packages.index')->with('status', 'Package created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'roi_percentage' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1',
            'status' => 'required|in:draft,open,closed,sold_out',
            'image' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        if ($request->name !== $package->name) {
             $slug = Str::slug($request->name);
             $count = Package::where('slug', 'LIKE', "{$slug}%")->where('id', '!=', $package->id)->count();
             if ($count > 0) {
                 $slug .= '-' . ($count + 1);
             }
             $package->slug = $slug;
        }

        $package->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'roi_percentage' => $request->roi_percentage,
            'duration_months' => $request->duration_months,
            'status' => $request->status,
            'image' => $request->image,
        ]);

        return redirect()->route('admin.packages.index')->with('status', 'Package updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index')->with('status', 'Package deleted successfully.');
    }
}
