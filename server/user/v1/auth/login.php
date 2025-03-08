<?php
include '../../../connection/db.php';
include '../../../models/UserModel.php';
include 'jwt_utils.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['email'], $data['password'])) {
        echo json_encode(["error" => "Email and password are required"]);
        exit;
    }

    $email = $data['email'];
    $password = hash("sha256", $data['password']); // SHA-256 Hashing

    try {
        $userModel = new UserModel($conn);
        $user = $userModel->getUserByEmail($email);

        if ($user && $user->getPassword() === $password) {
            $token = JWTUtils::generateToken($user->getId(), $user->getEmail());
            echo json_encode(["message" => "Login successful", "token" => $token]);
        } else {
            echo json_encode(["error" => "Invalid email or password"]);
        }
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
