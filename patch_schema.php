<?php

$dbPath = __DIR__ . '/database/database.sqlite';

try {
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Checking schema...\n";

    // 1. Add 'role' column
    try {
        $pdo->exec("ALTER TABLE users ADD COLUMN role TEXT DEFAULT 'investor'");
        echo "Added 'role' column.\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'duplicate column name') !== false) {
            echo "'role' column already exists.\n";
        } else {
            throw $e;
        }
    }

    // 2. Add 'status' column
    try {
        $pdo->exec("ALTER TABLE users ADD COLUMN status TEXT DEFAULT 'active'");
        echo "Added 'status' column.\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'duplicate column name') !== false) {
            echo "'status' column already exists.\n";
        } else {
            throw $e;
        }
    }

    // 3. Add 'blocked_by' column
    try {
        $pdo->exec("ALTER TABLE users ADD COLUMN blocked_by INTEGER DEFAULT NULL");
        echo "Added 'blocked_by' column.\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'duplicate column name') !== false) {
            echo "'blocked_by' column already exists.\n";
        } else {
            throw $e;
        }
    }
    
    echo "Schema patch complete.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
