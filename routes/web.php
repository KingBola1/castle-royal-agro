<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController; // Added to prevent Admin crash
use App\Http\Controllers\InvestmentPackageController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\AdminWithdrawalController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

// --- Homepage ---
Route::get('/', function () {
    return view('welcome');
});

// --- Investor Dashboard (The Fix) ---
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// --- Profile Routes ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/payment-details', [ProfileController::class, 'updatePaymentDetails'])->name('profile.payment-details');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Public Pages ---
Route::get('/initiative', [PageController::class, 'initiative'])->name('initiative');
Route::get('/products', [PageController::class, 'products'])->name('products');
Route::get('/about', function () { return view('about'); })->name('about');

// --- Redirects ---
Route::redirect('/investors', '/login');

// --- Admin Panel (Protected) ---
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users/{id}', [AdminController::class, 'show'])->name('admin.users.show');
    Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::post('/admin/users/{id}/invest', [AdminController::class, 'invest'])->name('admin.users.invest');
    Route::post('/admin/users/{id}/reset-password', [AdminController::class, 'resetPassword'])->name('admin.users.reset-password');
    
    // Investment CRUD
    Route::put('/admin/investments/{id}', [AdminController::class, 'updateInvestment'])->name('admin.investments.update');
    Route::delete('/admin/investments/{id}', [AdminController::class, 'destroyInvestment'])->name('admin.investments.destroy');
    
    
    Route::post('/admin/investments/bulk-update', [AdminController::class, 'bulkUpdateRoi'])->name('admin.investments.bulk-update');
    
    // Investment Packages (The Package Factory)
    Route::resource('admin/packages', \App\Http\Controllers\InvestmentPackageController::class)->except(['show', 'edit', 'update']);

    // Admin Withdrawals
    Route::resource('admin/withdrawals', AdminWithdrawalController::class)->only(['index', 'update']);
});

// User Withdrawal Routes
Route::middleware(['auth', 'ensure.active'])->group(function () {
    Route::resource('withdrawals', WithdrawalController::class)->only(['create', 'store']);
});

// --- Auth Routes (Login/Register) ---
require __DIR__.'/auth.php';

// ==========================================
// DEBUG & TOOLS (Keep these for now)
// ==========================================

// Route to Fix the Button (Clear Cache)
Route::get('/fix-site', function () {
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    return '<h1>FIX DONE! ✅</h1><p>Go refresh the homepage.</p>';
});

// Test Email Route
Route::get('/test-email', function () {
    try {
        Mail::raw('If you are reading this, the email system is WORKING!', function ($msg) {
            $msg->to(['kwamerahman83@gmail.com'])
                ->subject('Test Email from Castle Royal');
        });
        return '<h1>SUCCESS! ✅</h1> <p>Email sent successfully.</p>';
    } catch (\Exception $e) {
        return '<h1>FAILURE ❌</h1> <p>Error Message:</p> <pre>' . $e->getMessage() . '</pre>';
    }
});

// SMTP Debug Route
Route::get('/debug-smtp', function () {
    $config = Config::get('mail.mailers.smtp');
    return "<h1>SMTP Diagnostic</h1>" .
           "<p><strong>Host:</strong> " . $config['host'] . "</p>" .
           "<p><strong>Port:</strong> " . $config['port'] . "</p>" .
           "<p><strong>Username:</strong> " . $config['username'] . "</p>";
});