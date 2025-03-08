<?php
include '../../connection/db.php';
include '../../models/FAQModel.php';
include '../../models/FAQSkeleton.php';
include '../auth/verify_jwt.php'; // Verify JWT before proceeding

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['question'], $data['answer'])) {
        echo json_encode(["error" => "Both question and answer are required"]);
        exit;
    }

    $question = $data['question'];
    $answer = $data['answer'];

    try {
        $faqModel = new FAQModel($conn);
        $faq = new FAQSkeleton(null, $question, $answer, date("Y-m-d H:i:s"));
        $faqId = $faqModel->createFAQ($faq);

        echo json_encode(["message" => "FAQ created successfully", "faq_id" => $faqId]);
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
