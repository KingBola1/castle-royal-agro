<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SystemSettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function transferOwnership(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $currentOwner = Auth::user();
        $newOwner = User::where('email', $request->email)->firstOrFail();

        if ($currentOwner->id === $newOwner->id) {
            return back()->withErrors(['email' => 'You are already the System Owner.']);
        }

        // 1. Crown the new System Owner
        $newOwner->assignRole('System Owner');

        // 2. Safely step down the current owner to a Super Admin so they aren't fully locked out
        $currentOwner->removeRole('System Owner');
        if (!$currentOwner->hasRole('Super Admin') && !$currentOwner->hasRole('super_admin')) {
            $currentOwner->assignRole('Super Admin');
        }

        // 3. Log out to finalize the security transfer
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'System Ownership has been successfully transferred. You have been logged out.');
    }
}
