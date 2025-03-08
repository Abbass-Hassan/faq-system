<?php
include __DIR__ . '/../../connection/db.php'; // Correct path to db.php

try {
    $sql = "CREATE TABLE IF NOT EXISTS faqs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        question TEXT NOT NULL,
        answer TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    $conn->exec($sql);
    echo "✅ FAQs table created successfully!\n";
} catch (PDOException $e) {
    die("❌ Error creating FAQs table: " . $e->getMessage());
}
?>
