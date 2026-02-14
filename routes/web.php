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
use App\Http\Controllers\Investor\MarketplaceController; // Added Import
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
// --- Investor Dashboard (The Fix) ---
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Marketplace Routes
    Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace.index');
    Route::get('/marketplace/{package:slug}', [MarketplaceController::class, 'show'])->name('marketplace.show'); // Binding by slug is better for URLs
    Route::post('/marketplace/{package}/buy', [MarketplaceController::class, 'store'])->name('marketplace.buy');
});

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
    
    // Investment Packages (THE NEW PackageController HANDLES THIS NOW)
    // Route::resource('admin/packages', \App\Http\Controllers\InvestmentPackageController::class)->except(['show', 'edit', 'update']);

    // Admin Withdrawals
    // Admin Withdrawals (Moved to named group below)

    // User Management (New RBAC System)
    Route::get('/users-management', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users-management/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users-management/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
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

// --- DEBUG CONFIG (HTTPS/Proxy Test) ---
Route::get('/debug-config', function (Illuminate\Http\Request $request) {
    return [
        'secure' => $request->secure() ? 'YES (HTTPS)' : 'NO (HTTP)',
        'ip' => $request->ip(),
        'user_agent' => $request->header('User-Agent'),
        'host' => $request->getHost(),
        'port' => $request->getPort(),
        'scheme' => $request->getScheme(),
        'url_generation' => url('/'),
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

// --- DEBUG ROUTE (Hashing Test) ---

// --- Support / Contact Form ---
Route::post('/contact-support', [App\Http\Controllers\SupportController::class, 'handleContact'])->name('support.send');

// --- Roles Setup Route (Temporary) ---
Route::get('/fix-roles', function () {
    try {
        // 1. Create Roles if they don't exist
        $superAdmin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'super_admin']); 
        $admin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
        $investor = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'investor']);

        // 2. Find Me
        $user = \App\Models\User::where('email', 'kwamerahman83@gmail.com')->first();

        if (!$user) {
            return 'Error: User not found!';
        }

        // 3. Assign Role
        $user->assignRole($superAdmin);

        return "Success! You are now Super Admin. <a href='/users-management'>Go to User Management</a>";
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

use App\Http\Controllers\Admin\UserController;

Route::middleware(['auth', 'verified', 'role:Super Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('packages', \App\Http\Controllers\Admin\PackageController::class);
    Route::get('/withdrawals', [\App\Http\Controllers\Admin\WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::post('/withdrawals/{id}/approve', [\App\Http\Controllers\Admin\WithdrawalController::class, 'approve'])->name('withdrawals.approve');
    Route::post('/withdrawals/{id}/reject', [\App\Http\Controllers\Admin\WithdrawalController::class, 'reject'])->name('withdrawals.reject');
    
    // Admin Investment Management
    Route::get('/investments', [\App\Http\Controllers\Admin\InvestmentController::class, 'index'])->name('investments.index');
    Route::post('/investments/{investment}/approve', [\App\Http\Controllers\Admin\InvestmentController::class, 'approve'])->name('investments.approve');
    Route::post('/investments/{investment}/reject', [\App\Http\Controllers\Admin\InvestmentController::class, 'reject'])->name('investments.reject');

    // System Operations
    Route::post('/system/migrate', [\App\Http\Controllers\Admin\SystemController::class, 'runMigrations'])->name('system.migrate');
});








// --- Quick Role Fix (Case Sensitivity) ---
Route::get('/fix-roles-v2', function () {
    try {
        // Create the role exactly as the middleware expects it ('Super Admin')
        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Super Admin']);
        
        $user = \App\Models\User::where('email', 'kwamerahman83@gmail.com')->first();
        
        if (!$user) {
            return 'User not found';
        }

        $user->assignRole($role);
        
        return "Role 'Super Admin' assigned to " . $user->email;
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});

// --- Debug Route (User Auth) ---
Route::get('/debug-user', function () {
    $user = Auth::user();
    if (!$user) return response()->json(['error' => 'Not Logged In'], 401);
    
    return [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'role_column' => $user->role, 
        'roles_spatie' => $user->getRoleNames(),
        'permissions' => $user->getAllPermissions()->pluck('name'),
        'is_super_admin' => $user->hasRole('Super Admin') ? 'YES' : 'NO',
        'is_admin' => $user->hasRole('admin') ? 'YES' : 'NO',
    ];
});

// --- Force Verify Route ---
Route::get('/force-verify', function () {
    $user = auth()->user();
    if (!$user) return "Login first.";

    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    return redirect('/dashboard')->with('status', 'You have been manually verified!');
});

// --- Cache Clearing Route (Emergency Fix) ---
Route::get('/clear-cache', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    return "Config Cleared! Brevo should work now.";
});
