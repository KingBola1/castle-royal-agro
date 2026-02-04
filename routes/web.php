<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// 1. Home Page
Route::get('/', function () {
    return view('welcome');
});

// 2. The "Secret Door" to fix the Database
Route::get('/force-migrate', function () {
    try {
        // Clear the "Old Memory" (Fixes the 127.0.0.1 error)
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        
        // Run the Database Setup
        Artisan::call('migrate', ['--force' => true]);
        
        return '<h1 style="color:green">SUCCESS! ✅</h1><p>Database is connected and ready.</p>';
    } catch (\Exception $e) {
        return '<h1 style="color:red">Error:</h1><p>' . $e->getMessage() . '</p>';
    }
});