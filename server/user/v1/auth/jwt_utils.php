<?php
require __DIR__ . '/../../../../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTUtils {
    private static $secret_key = "your_secret_key"; // Change this to a strong secret key
    private static $algorithm = "HS256";

    // Generate JWT Token
    public static function generateToken($userId, $email) {
        $payload = [
            "user_id" => $userId,
            "email" => $email,
            "exp" => time() + (60 * 60) // Token expires in 1 hour
        ];

        return JWT::encode($payload, self::$secret_key, self::$algorithm);
    }

    // Validate and Decode JWT
    public static function validateToken($token) {
        try {
            return JWT::decode($token, new Key(self::$secret_key, self::$algorithm));
        } catch (Exception $e) {
            return null; // Invalid token
        }
    }
}
?>
