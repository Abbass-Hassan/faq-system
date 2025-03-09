<?php
require __DIR__ . '/../../../../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Utility class for JWT operations.
class JWTUtils {
    private static $secret_key = "your_secret_key";
    private static $algorithm = "HS256";

    // Generates a JWT token with user ID, email, and expiration.
    public static function generateToken($userId, $email) {
        $payload = [
            "user_id" => $userId,
            "email" => $email,
            "exp" => time() + (60 * 60) // Token expires in 1 hour
        ];

        return JWT::encode($payload, self::$secret_key, self::$algorithm);
    }

    // Validates a JWT token and returns the decoded payload, or null if invalid.
    public static function validateToken($token) {
        try {
            return JWT::decode($token, new Key(self::$secret_key, self::$algorithm));
        } catch (Exception $e) {
            return null;
        }
    }
}
?>
