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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
    Route::post('/admin/users/{id}/magic-link', [AdminController::class, 'generateMagicLink'])->name('admin.users.magic-link');
    
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


// Route for Force Password Reset (Temporary Debugging)
Route::get('/force-password-fix', function () {
    $email = 'johnmtec1@gmail.com'; // Hardcoded test email
    $newPass = 'Castle2026';
    
    $user = Illuminate\Support\Facades\DB::table('users')->where('email', $email)->first();
    
    if (!$user) {
        return "ERROR: User $email not found.";
    }

    // 1. Force update with manually hashed password (bypassing model events/casts)
    Illuminate\Support\Facades\DB::table('users')
        ->where('email', $email)
        ->update(['password' => Illuminate\Support\Facades\Hash::make($newPass)]);
        
    // 2. Verify immediately
    $updatedUser = Illuminate\Support\Facades\DB::table('users')->where('email', $email)->first();
    $storedHash = $updatedUser->password;
    $check = Illuminate\Support\Facades\Hash::check($newPass, $storedHash);
    $driver = config('hashing.driver');
    $len = strlen($storedHash);
    
    return "<h1>Deep Diagnostic</h1>" .
           "<p><strong>Hashing Driver:</strong> $driver</p>" .
           "<p><strong>Stored Hash Length:</strong> $len chars (Should be >= 60)</p>" .
           "<hr>" .
           "<p><strong>Target Password:</strong> $newPass</p>" .
           "<p><strong>Stored Hash:</strong> $storedHash</p>" .
           "<hr>" .
           "<h3>Hash::check Result: " . ($check ? '<span style="color:green">YES - MATCH</span>' : '<span style="color:red; font-size: 2em;">NO - MISMATCH</span>') . "</h3>" .
           "<p>If Length is < 60, your database column is too short.</p>" .
           "<p>If Length is 60+ but Mismatch, your App Key or Hashing Config might be inconsistent.</p>";
});

// --- DEBUG ROUTE (Hashing Test) ---
Route::get('/debug-hashing', function () {
    $password = 'Castle2026';
    $user = User::where('email', 'johnmtec1@gmail.com')->first();
    
    if (!$user) return 'User not found';

    // Update (Model Cast should handle hashing)
    $user->password = $password; 
    $user->save();
    
    $user->refresh();

    return [
        'stored_hash' => $user->password,
        'length' => strlen($user->password),
        'check_match' => \Illuminate\Support\Facades\Hash::check($password, $user->password) ? 'MATCH' : 'FAIL',
        'is_double_hashed' => str_starts_with($user->password, '$2y$') && \Illuminate\Support\Facades\Hash::needsRehash($user->password) ? 'NO' : 'MAYBE',
    ];
});

// --- GLOBAL MAGIC LINK ROUTE (Must be outside all groups) ---


Route::get('/magic-login/{user}', function (Request $request, $id) {
    // 1. Verify Signature
    if (! $request->hasValidSignature()) {
        abort(403, 'This link is invalid or has expired.');
    }

    // 2. Login User
    $user = User::findOrFail($id);
    Auth::login($user);

    // 3. Redirect
    return redirect('/dashboard')->with('status', 'Magic Login Successful! Welcome back.');
})->name('magic.login');