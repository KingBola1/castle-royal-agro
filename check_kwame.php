<?php

use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$email = 'kwamerahman83@gmail.com';

echo "Querying DB for $email...\n";

$user = DB::table('users')->where('email', $email)->first();

if ($user) {
    echo "User Found:\n";
    echo "ID: " . $user->id . "\n";
    echo "Role: " . ($user->role ?? 'N/A') . "\n";
    echo "Status: " . ($user->status ?? 'N/A') . "\n";
} else {
    echo "User NOT found.\n";
}
