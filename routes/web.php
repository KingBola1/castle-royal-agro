<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/initiative', [PageController::class, 'initiative'])->name('initiative');
Route::get('/products', [PageController::class, 'products'])->name('products');
Route::get('/investors', [PageController::class, 'investors'])->name('investors');
Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
// Secret Route to Force Database Migration
Route::get('/force-migrate', function () {
    try {
        Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        return '<h1>Database Setup Complete! ✅</h1><p>You can now use Login/Register.</p>';
    } catch (\Exception $e) {
        return '<h1>Error:</h1><p>' . $e->getMessage() . '</p>';
    }
});
