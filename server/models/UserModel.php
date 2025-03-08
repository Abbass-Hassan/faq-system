<?php
require_once __DIR__ . '/../connection/db.php';
require_once __DIR__ . '/UserSkeleton.php';

class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createUser(UserSkeleton $user) {
        try {
            $sql = "INSERT INTO users (fullname, email, password, created_at) VALUES (:fullname, :email, :password, NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':fullname' => $user->getFullname(),
                ':email' => $user->getEmail(),
                ':password' => $user->getPassword()
            ]);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            error_log("Database Insert Error: " . $e->getMessage());
            return null;
        }
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new UserSkeleton($row['id'], $row['fullname'], $row['email'], $row['password'], $row['created_at']);
        }
        return null;
    }
}
?>
