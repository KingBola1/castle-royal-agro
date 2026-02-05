<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// --- PASTE THIS INSTEAD ---
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/initiative', [PageController::class, 'initiative'])->name('initiative');
Route::get('/products', [PageController::class, 'products'])->name('products');
Route::redirect('/investors', '/login');

require __DIR__.'/auth.php';
// Route to Fix the Button (Clear Cache)
Route::get('/fix-site', function () {
    Illuminate\Support\Facades\Artisan::call('view:clear');
    Illuminate\Support\Facades\Artisan::call('route:clear');
    Illuminate\Support\Facades\Artisan::call('config:clear');
    Illuminate\Support\Facades\Artisan::call('cache:clear');
    return '<h1>FIX DONE! ✅</h1><p>Go refresh the homepage.</p>';
});
use Illuminate\Support\Facades\Mail;

Route::get('/test-email', function () {
    try {
        Mail::raw('If you are reading this, the email system is WORKING!', function ($msg) {
            $msg->to(['kwamerahman83@gmail.com']) // <--- CHANGE THIS to your actual email
                ->subject('Test Email from Castle Royal');
        });
        return '<h1>SUCCESS! ✅</h1> <p>Email sent successfully. Check your inbox (and Spam).</p>';
    } catch (\Exception $e) {
        return '<h1>FAILURE ❌</h1> <p>Error Message:</p> <pre>' . $e->getMessage() . '</pre>';
    }
});
use Illuminate\Support\Facades\Config;

Route::get('/debug-smtp', function () {
    $config = Config::get('mail.mailers.smtp');
    $password = $config['password'];
    $length = strlen($password);
    
    return "<h1>SMTP Diagnostic</h1>" .
           "<p><strong>Host:</strong> " . $config['host'] . "</p>" .
           "<p><strong>Port:</strong> " . $config['port'] . "</p>" .
           "<p><strong>Username:</strong> " . $config['username'] . "</p>" .
           "<p><strong>Encryption:</strong> " . ($config['encryption'] ?? 'null') . "</p>" .
           "<hr>" .
           "<p><strong>Password Length:</strong> " . $length . " characters (Should be approx 73)</p>" .
           "<p><strong>First 3 chars:</strong> " . substr($password, 0, 3) . "***</p>" .
           "<p><strong>Last 3 chars:</strong> ***" . substr($password, -3) . "</p>";
});
// --- New Impact Page Route ---
Route::get('/about', function () {
    return view('about');
})->name('about');