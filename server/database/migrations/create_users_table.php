<?php
include __DIR__ . '/../../connection/db.php'; // Correct path to db.php

try {
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        fullname VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    $conn->exec($sql);
    echo "✅ Users table created successfully!\n";
} catch (PDOException $e) {
    die("❌ Error creating users table: " . $e->getMessage());
}
?>
