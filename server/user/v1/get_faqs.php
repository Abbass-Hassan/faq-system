<?php
include '../../connection/db.php';
include '../../models/FAQModel.php';

header("Content-Type: application/json");

try {
    // Instantiate FAQModel and retrieve all FAQs.
    $faqModel = new FAQModel($conn);
    $faqs = $faqModel->getAllFAQs();
    echo json_encode(["faqs" => $faqs]);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
