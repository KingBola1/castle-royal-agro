<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test User
$email = 'johnmtec1@gmail.com';
$password = 'Castle2026'; // From web.php debug route

echo "Checking user: $email\n";
$user = User::where('email', $email)->first();

if (!$user) {
    echo "User found: NO\n";
    exit(1);
}

echo "User found: YES (ID: {$user->id}, Role: {$user->role}, Status: {$user->status})\n";

// Check Password
if (Hash::check($password, $user->password)) {
    echo "Hash check: MATCH\n";
} else {
    echo "Hash check: FAIL\n";
    echo "Stored Hash: " . $user->password . "\n";
    echo "New Hash of '$password': " . Hash::make($password) . "\n";
}

// Attempt Auth
if (Auth::attempt(['email' => $email, 'password' => $password])) {
    echo "Auth::attempt: SUCCESS\n";
} else {
    echo "Auth::attempt: FAILED\n";
}
