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

