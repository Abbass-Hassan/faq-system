<?php
require_once '../../../connection/db.php';
require_once '../../../models/UserModel.php';
require_once '../../../models/UserSkeleton.php';
require_once 'jwt_utils.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['fullname'], $data['email'], $data['password'])) {
        echo json_encode(["error" => "All fields are required"]);
        exit;
    }

    $fullname = $data['fullname'];
    $email = $data['email'];
    $password = hash("sha256", $data['password']); // SHA-256 Hashing

    try {
        $userModel = new UserModel($conn);

        if ($userModel->getUserByEmail($email)) {
            echo json_encode(["error" => "Email already exists"]);
            exit;
        }

        $user = new UserSkeleton(null, $fullname, $email, $password, date("Y-m-d H:i:s"));
        $userId = $userModel->createUser($user);

        $token = JWTUtils::generateToken($userId, $email);

        echo json_encode([
            "message" => "User registered successfully",
            "user_id" => $userId,
            "token" => $token
        ]);
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
