<?php
$host = "localhost";
$dbname = "faq_system";
$username = "root"; // Change if using another user
$password = ""; // Keep empty if no password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
