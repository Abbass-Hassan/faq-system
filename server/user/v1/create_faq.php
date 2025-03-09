<?php
require_once __DIR__ . '/auth/verify_jwt.php';
require_once __DIR__ . '/../../connection/db.php';
require_once __DIR__ . '/../../models/FAQModel.php';
require_once __DIR__ . '/../../models/FAQSkeleton.php';

header("Content-Type: application/json");

// Authenticate user with JWT.
$userData = verifyJWT();
if (!$userData) {
    echo json_encode(["error" => "Unauthorized request: Invalid token."]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['question'], $data['answer'])) {
        echo json_encode(["error" => "Both question and answer are required"]);
        exit;
    }

    $question = trim($data['question']);
    $answer = trim($data['answer']);

    try {
        // Create a new FAQ entry.
        $faqModel = new FAQModel($conn);
        $faq = new FAQSkeleton(null, $question, $answer, date("Y-m-d H:i:s"));
        $faqId = $faqModel->createFAQ($faq);

        // Return success response.
        echo json_encode([
            "message" => "FAQ created successfully",
            "faq_id" => $faqId,
            "question" => $question,
            "answer" => $answer
        ]);
    } catch (Exception $e) {
        echo json_encode(["error" => "Failed to insert FAQ: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
