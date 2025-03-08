<?php
include __DIR__ . '/../connection/db.php';
include __DIR__ . '/FAQSkeleton.php';

class FAQModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new FAQ
    public function createFAQ(FAQSkeleton $faq) {
        $sql = "INSERT INTO faqs (question, answer) VALUES (:question, :answer)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':question' => $faq->getQuestion(),
            ':answer' => $faq->getAnswer()
        ]);
        return $this->conn->lastInsertId();
    }

    // Get all FAQs
    public function getAllFAQs() {
        $sql = "SELECT * FROM faqs";
        $stmt = $this->conn->query($sql);
        $faqs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $faqs[] = new FAQSkeleton($row['id'], $row['question'], $row['answer'], $row['created_at']);
        }
        return $faqs;
    }

    // Get FAQ by ID
    public function getFAQById($id) {
        $sql = "SELECT * FROM faqs WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new FAQSkeleton($row['id'], $row['question'], $row['answer'], $row['created_at']) : null;
    }
}
?>
