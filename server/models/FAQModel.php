<?php
require_once __DIR__ . '/../connection/db.php';
require_once __DIR__ . '/FAQSkeleton.php';

class FAQModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new FAQ
    public function createFAQ(FAQSkeleton $faq) {
        try {
            $sql = "INSERT INTO faqs (question, answer) VALUES (:question, :answer)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':question' => $faq->getQuestion(),
                ':answer' => $faq->getAnswer()
            ]);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    // Get all FAQs
    public function getAllFAQs() {
        $sql = "SELECT id, question, answer, created_at FROM faqs";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
