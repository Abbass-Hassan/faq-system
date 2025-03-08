<?php
include 'jwt_utils.php';

header("Content-Type: application/json");

$headers = apache_request_headers();
$authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    echo json_encode(["error" => "Unauthorized"]);
    http_response_code(401);
    exit;
}

$token = $matches[1];
$decoded = JWTUtils::validateToken($token);

if (!$decoded) {
    echo json_encode(["error" => "Invalid token"]);
    http_response_code(401);
    exit;
}

$userId = $decoded->user_id; 
?>
