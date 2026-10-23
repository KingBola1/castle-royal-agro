<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvestmentPackageController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\AdminWithdrawalController;
use App\Http\Controllers\Investor\MarketplaceController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/', function () { return view('welcome'); });
Route::get('/initiative', [PageController::class, 'initiative'])->name('initiative');
Route::get('/products', [PageController::class, 'products'])->name('products');
Route::get('/about', function () { return view('about'); })->name('about');
Route::redirect('/investors', '/login');

Route::middleware(['auth', 'verified', \App\Http\Middleware\RequireTwoFactor::class])->group(function () {
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace.index');
Route::get('/marketplace/{package:slug}', [MarketplaceController::class, 'show'])->name('marketplace.show');
Route::post('/marketplace/{package}/buy', [MarketplaceController::class, 'store'])->name('marketplace.buy');
});

Route::middleware(['auth', 'ensure.active'])->group(function () {
Route::resource('withdrawals', WithdrawalController::class)->only(['create', 'store']);
});

Route::middleware('auth')->group(function () {
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::patch('/profile/payment-details', [ProfileController::class, 'updatePaymentDetails'])->name('profile.payment-details');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:System Owner|Super Admin|super_admin|Admin|admin', \App\Http\Middleware\RequireTwoFactor::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/2fa/setup', [\App\Http\Controllers\Admin\TwoFactorAuthController::class, 'enable'])->name('2fa.setup');
    Route::get('/2fa/verify', [\App\Http\Controllers\Admin\TwoFactorAuthController::class, 'showVerify'])->name('2fa.verify');
    Route::post('/2fa/verify', [\App\Http\Controllers\Admin\TwoFactorAuthController::class, 'verify'])->name('2fa.verify.store');

    // RESTORED: Admin Dashboard Route
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    Route::post('/investments/bulk-update', [\App\Http\Controllers\AdminController::class, 'bulkUpdateRoi'])->name('investments.bulk-update');

    // Admin User Management & Actions
    Route::get('/users/{id}', [\App\Http\Controllers\AdminController::class, 'show'])->name('users.show');
    Route::put('/users/{id}', [\App\Http\Controllers\AdminController::class, 'update'])->name('users.update');
    Route::post('/users/{id}/invest', [\App\Http\Controllers\AdminController::class, 'invest'])->name('users.invest');
    Route::post('/users/{id}/reset-password', [\App\Http\Controllers\AdminController::class, 'resetPassword'])->name('users.reset-password');
    Route::post('/users/{id}/magic-link', [\App\Http\Controllers\AdminController::class, 'generateMagicLink'])->name('users.magic-link');
    Route::delete('/investments/{id}', [\App\Http\Controllers\AdminController::class, 'destroyInvestment'])->name('investments.destroy');

    // Operational Admin Routes
    Route::resource('packages', \App\Http\Controllers\Admin\PackageController::class);
    Route::resource('withdrawals', \App\Http\Controllers\AdminWithdrawalController::class)->only(['index', 'update']);
    Route::post('withdrawals/{withdrawal}/approve', [\App\Http\Controllers\AdminWithdrawalController::class, 'approve'])->name('withdrawals.approve');
    Route::post('withdrawals/{withdrawal}/reject', [\App\Http\Controllers\AdminWithdrawalController::class, 'reject'])->name('withdrawals.reject');
    // Expand Investment routes
    Route::get('investments', [\App\Http\Controllers\Admin\InvestmentController::class, 'index'])->name('investments.index');
    Route::post('investments/{investment}/approve', [\App\Http\Controllers\Admin\InvestmentController::class, 'approve'])->name('investments.approve');
    Route::post('investments/{investment}/reject', [\App\Http\Controllers\Admin\InvestmentController::class, 'reject'])->name('investments.reject');
});

Route::middleware(['auth', 'verified', 'role:System Owner|Super Admin|super_admin', \App\Http\Middleware\RequireTwoFactor::class])->prefix('admin')->group(function () {
Route::get('/users-management', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
Route::get('/users-management/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
Route::post('/users-management', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
Route::get('/users-management/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
Route::put('/users-management/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
});

Route::middleware(['auth', 'verified', 'role:System Owner|Super Admin|super_admin', \App\Http\Middleware\RequireTwoFactor::class])->prefix('admin')->name('admin.')->group(function () {
Route::post('/users/{id}/suspend', [\App\Http\Controllers\Admin\UserController::class, 'suspend'])->name('users.suspend');
Route::post('/users/{id}/restore', [\App\Http\Controllers\Admin\UserController::class, 'restore'])->name('users.restore');
Route::post('/system/migrate', [\App\Http\Controllers\Admin\SystemController::class, 'runMigrations'])->name('system.migrate');
Route::get('/audit-logs', [\App\Http\Controllers\Admin\AuditLogController::class, 'index'])->name('audit-logs.index');
Route::get('/audit-logs/download', [\App\Http\Controllers\Admin\ReportController::class, 'downloadAuditLogs'])->name('reports.audit-logs');
});

Route::middleware(['auth', 'verified', 'role:System Owner', \App\Http\Middleware\RequireTwoFactor::class])->prefix('admin')->name('admin.')->group(function () {
Route::get('/system-settings', [\App\Http\Controllers\Admin\SystemSettingController::class, 'index'])->name('settings.index');
Route::post('/system-settings/transfer-ownership', [\App\Http\Controllers\Admin\SystemSettingController::class, 'transferOwnership'])->name('settings.transfer');
});

require __DIR__.'/auth.php';

Route::get('/magic-login/{user}', function (Request $request, $id) {
if (! $request->hasValidSignature()) abort(403, 'This link is invalid or has expired.');
$user = User::findOrFail($id);
Auth::login($user);
return redirect('/dashboard')->with('status', 'Magic Login Successful!');
})->name('magic.login');

Route::get('/test-email', function () {
try {
Mail::raw('WORKING!', function ($msg) { $msg->to(['kwamerahman83@gmail.com'])->subject('Test Email'); });
return 'SUCCESS!';
} catch (\Exception $e) { return 'FAILURE: ' . $e->getMessage(); }
});

Route::get('/debug-smtp', function () {
$config = Config::get('mail.mailers.smtp');
return "Host: " . $config['host'] . " | Port: " . $config['port'] . " | User: " . $config['username'];
});

Route::get('/clear-cache', function() {
Artisan::call('config:clear'); Artisan::call('cache:clear');
return "Cache Cleared!";
});
