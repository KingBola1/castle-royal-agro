<?php

$dbPath = __DIR__ . '/database/database.sqlite';

try {
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Listing users...\n";
    $stmt = $pdo->query("SELECT id, name, email, role, status FROM users LIMIT 10");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($users)) {
        echo "No users found in database!\n";
    } else {
        foreach ($users as $user) {
            print_r($user);
        }
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
