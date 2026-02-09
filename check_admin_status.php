<?php

use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$email = 'johnmtec1@gmail.com';

echo "Querying DB for $email...\n";

$user = DB::table('users')->where('email', $email)->first();

if ($user) {
    echo "User Found:\n";
    echo "ID: " . $user->id . "\n";
    echo "Name: " . $user->name . "\n";
    echo "Role: " . $user->role . "\n";
    echo "Status: " . $user->status . "\n";
} else {
    echo "User NOT found.\n";
}
