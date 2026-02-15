<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireTwoFactor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user) {
            // 1. If user hasn't set up 2FA yet, force them to setup
            if (!$user->google2fa_secret) {
                // Prevent infinite redirect loop if already on setup page or enable action
                if (!$request->routeIs('admin.2fa.setup') && !$request->routeIs('admin.2fa.enable') && !$request->routeIs('admin.2fa.verify.store')) {
                    return redirect()->route('admin.2fa.setup');
                }
            } 
            // 2. If user has 2FA set up, check if session is verified
            elseif (!$request->session()->has('2fa_verified')) {
                // Prevent infinite redirect loop if already on verify page or verify action
                if (!$request->routeIs('admin.2fa.verify') && !$request->routeIs('admin.2fa.verify.store')) {
                    return redirect()->route('admin.2fa.verify');
                }
            }
        }

        return $next($request);
    }
}
