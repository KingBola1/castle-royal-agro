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
            'price' => 'nullable|numeric|min:0',
            'roi_percentage' => 'nullable|numeric|min:0',
            'duration_months' => 'nullable|integer|min:1',
            'status' => 'nullable|in:draft,open,closed,sold_out',
            'image' => 'nullable|image|max:2048', // File upload validation
            'image_url' => 'nullable|url',        // URL fallback validation
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($request->name);
        $count = Package::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $data = $request->except(['image', 'image_url']);
        $data['slug'] = $slug;

        // 1. Handle File Upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('packages', 'public');
            $data['image'] = 'storage/' . $path;
        }
        // 2. Handle URL fallback
        elseif ($request->filled('image_url')) {
            $data['image'] = $request->image_url;
        }

        Package::create($data);

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
            'price' => 'nullable|numeric|min:0',
            'roi_percentage' => 'nullable|numeric|min:0',
            'duration_months' => 'nullable|integer|min:1',
            'status' => 'nullable|in:draft,open,closed,sold_out',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',
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

        $package->fill($request->except(['image', 'image_url']));

        // 1. Handle File Upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('packages', 'public');
            $package->image = 'storage/' . $path;
        }
        // 2. Handle URL fallback (only update if provided)
        elseif ($request->filled('image_url')) {
            $package->image = $request->image_url;
        }

        $package->save();

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
