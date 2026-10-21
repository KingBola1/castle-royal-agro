<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireTwoFactor
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Check the database column directly (which loads instantly)
        if ($user && in_array($user->role, ['super_admin', 'admin', 'System Owner'])) {
            
            // Allow them to visit the 2FA screens without getting stuck in a loop
            if ($request->routeIs('admin.2fa.*')) {
                return $next($request);
            }

            // 1. If they haven't set up the Google App yet, force setup
            if (empty($user->google2fa_secret)) {
                return redirect()->route('admin.2fa.setup');
            } 
            
            // 2. If they have it set up, but haven't typed the 6 digits yet, force verify
            if (!$request->session()->has('2fa_verified')) {
                return redirect()->route('admin.2fa.verify');
            }
        }

        return $next($request);
    }
}