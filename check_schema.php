<?php

$dbPath = __DIR__ . '/database/database.sqlite';

try {
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Table Schema for 'users':\n";
    $stmt = $pdo->query("PRAGMA table_info(users)");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($columns as $col) {
        echo $col['cid'] . ": " . $col['name'] . " (" . $col['type'] . ")\n";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
