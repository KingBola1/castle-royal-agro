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

        // The Rule: Only stop people who are Management
        if ($user && $user->hasAnyRole(['System Owner', 'Super Admin', 'super_admin', 'Admin', 'admin'])) {
            
            // If they haven't set up the Google App yet, force them to the setup page
            if (!$user->google2fa_secret) {
                if (!$request->routeIs('admin.2fa.setup') && !$request->routeIs('admin.2fa.verify.store')) {
                    return redirect()->route('admin.2fa.setup');
                }
            } 
            // If they have it set up, but haven't typed the 6 digits yet, force them to the verify page
            elseif (!$request->session()->has('2fa_verified')) {
                if (!$request->routeIs('admin.2fa.verify') && !$request->routeIs('admin.2fa.verify.store')) {
                    return redirect()->route('admin.2fa.verify');
                }
            }
        }

        // Let everyone else (regular investors) walk through without 2FA
        return $next($request);
    }
}