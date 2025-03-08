<?php
require_once 'jwt_utils.php';

function verifyJWT() {
    $headers = apache_request_headers();
    if (!isset($headers['Authorization'])) {
        return false;
    }
    if (!preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
        return false;
    }
    $token = $matches[1];
    $decoded = JWTUtils::validateToken($token);
    if (!$decoded) {
        return false;
    }
    return $decoded;
}
?>
