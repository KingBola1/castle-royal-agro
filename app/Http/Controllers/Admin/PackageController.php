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
        if (!auth()->user()->hasAnyRole(['System Owner', 'Super Admin', 'super_admin']) && !auth()->user()->hasDirectPermission('manage_packages')) {
            abort(403, 'Unauthorized. You do not have the required permissions to manage packages.');
        }

        return view('admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasAnyRole(['System Owner', 'Super Admin', 'super_admin']) && !auth()->user()->hasDirectPermission('manage_packages')) {
            abort(403, 'Unauthorized. You do not have the required permissions to manage packages.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'roi_percentage' => 'nullable|numeric|min:0',
            'duration_months' => 'nullable|integer|min:1',
            'status' => 'nullable|in:draft,open,closed,sold_out',
            'image' => 'nullable', 
            'image_url' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($request->name);
        $count = Package::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $data = $request->except(['image', 'image_url']);
        $data['slug'] = $slug;

        // 1. Handle File Upload (Native SDK)
        if ($request->hasFile('image')) {
            // Fetch URL safely bypassing Laravel's config cache entirely
            $cloudUrl = $_SERVER['CLOUDINARY_URL'] ?? $_ENV['CLOUDINARY_URL'] ?? env('CLOUDINARY_URL');

            if (empty($cloudUrl)) {
                return back()->withErrors(['image' => 'CRITICAL: Cloudinary URL is missing from server.']);
            }

            // Initialize Native PHP SDK directly
            $cloudinary = new \Cloudinary\Cloudinary($cloudUrl);

            // Execute upload
            $response = $cloudinary->uploadApi()->upload($request->file('image')->getRealPath(), [
                'folder' => 'castle_royal_packages'
            ]);

            $data['image'] = $response['secure_url'];
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
        if (!auth()->user()->hasAnyRole(['System Owner', 'Super Admin', 'super_admin']) && !auth()->user()->hasDirectPermission('manage_packages')) {
            abort(403, 'Unauthorized. You do not have the required permissions to manage packages.');
        }

        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        if (!auth()->user()->hasAnyRole(['System Owner', 'Super Admin', 'super_admin']) && !auth()->user()->hasDirectPermission('manage_packages')) {
            abort(403, 'Unauthorized. You do not have the required permissions to manage packages.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'roi_percentage' => 'nullable|numeric|min:0',
            'duration_months' => 'nullable|integer|min:1',
            'status' => 'nullable|in:draft,open,closed,sold_out',
            'image' => 'nullable',
            'image_url' => 'nullable|string',
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

        // 1. Handle File Upload (Native SDK)
        if ($request->hasFile('image')) {
            // Fetch URL safely bypassing Laravel's config cache entirely
            $cloudUrl = $_SERVER['CLOUDINARY_URL'] ?? $_ENV['CLOUDINARY_URL'] ?? env('CLOUDINARY_URL');

            if (empty($cloudUrl)) {
                return back()->withErrors(['image' => 'CRITICAL: Cloudinary URL is missing from server.']);
            }

            // Initialize Native PHP SDK directly
            $cloudinary = new \Cloudinary\Cloudinary($cloudUrl);

            // Execute upload
            $response = $cloudinary->uploadApi()->upload($request->file('image')->getRealPath(), [
                'folder' => 'castle_royal_packages'
            ]);

            $package->image = $response['secure_url'];
        } 
        // 2. Handle URL fallback
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
        if (!auth()->user()->hasAnyRole(['System Owner', 'Super Admin', 'super_admin']) && !auth()->user()->hasDirectPermission('manage_packages')) {
            abort(403, 'Unauthorized. You do not have the required permissions to manage packages.');
        }

        $package->delete();
        return redirect()->route('admin.packages.index')->with('status', 'Package deleted successfully.');
    }
}
