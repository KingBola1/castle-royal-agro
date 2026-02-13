<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // We need this tool

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // FORCE HTTPS GLOBALLY (Fixes Signature Mismatch)
        URL::forceScheme('https');

        // Register Brevo Mailer Driver (Bulletproof)
        \Illuminate\Support\Facades\Mail::extend('brevo', function () {
            // 1. Force read from environment to bypass config cache on Render
            $key = env('BREVO_KEY') ?: config('services.brevo.key');

            // 2. Clear error if the key is missing from Render
            if (empty($key)) {
                throw new \Exception("CRITICAL: BREVO_KEY is missing from Render Environment Variables.");
            }

            // 3. Build the Symfony Transport
            return (new \Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoTransportFactory)->create(
                new \Symfony\Component\Mailer\Transport\Dsn('brevo+api', 'default', $key)
            );
        });


        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });
    }
}