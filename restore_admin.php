<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$email = 'johnmtec1@gmail.com';
$password = 'Castle2026';

$user = User::where('email', $email)->first();

if (!$user) {
    echo "Creating admin user...\n";
    $user = new User();
    $user->name = 'Castle Royal Admin';
    $user->email = $email;
    $user->password = Hash::make($password);
    $user->role = 'super_admin';
    $user->status = 'active';
    $user->save();
    echo "User created successfully.\n";
} else {
    echo "User already exists. Updating role/status...\n";
    $user->role = 'super_admin';
    $user->status = 'active';
    $user->password = Hash::make($password); // Reset password ensure it works
    $user->save();
    echo "User updated.\n";
}

echo "Done.\n";
