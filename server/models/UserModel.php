<?php
include __DIR__ . '/../connection/db.php';
include __DIR__ . '/UserSkeleton.php';

class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new user
    public function createUser(UserSkeleton $user) {
        $sql = "INSERT INTO users (fullname, email, password) VALUES (:fullname, :email, :password)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':fullname' => $user->getFullname(),
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword()
        ]);
        return $this->conn->lastInsertId();
    }

    // Get all users
    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->query($sql);
        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new UserSkeleton($row['id'], $row['fullname'], $row['email'], $row['password'], $row['created_at']);
        }
        return $users;
    }

    // Get user by ID
    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new UserSkeleton($row['id'], $row['fullname'], $row['email'], $row['password'], $row['created_at']) : null;
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
