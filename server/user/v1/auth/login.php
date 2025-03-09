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
    // Hash the password using SHA-256.
    $password = hash("sha256", $data['password']);

    try {
        // Retrieve user by email and verify password.
        $userModel = new UserModel($conn);
        $user = $userModel->getUserByEmail($email);

        if ($user && $user->getPassword() === $password) {
            // Generate JWT token upon successful authentication.
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
