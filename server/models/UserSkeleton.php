<?php
if (!class_exists('UserSkeleton')) {
    class UserSkeleton {
        private $id;
        private $fullname;
        private $email;
        private $password;
        private $created_at;

        public function __construct($id, $fullname, $email, $password, $created_at) {
            $this->id = $id;
            $this->fullname = $fullname;
            $this->email = $email;
            $this->password = $password;
            $this->created_at = $created_at;
        }

        public function getId() {
            return $this->id;
        }

        public function getFullname() {
            return $this->fullname;
        }

        public function getEmail() {
            return $this->email;
        }

        public function getPassword() {
            return $this->password;
        }

        public function getCreatedAt() {
            return $this->created_at;
        }

        public function setFullname($fullname) {
            $this->fullname = $fullname;
        }

        public function setEmail($email) {
            $this->email = $email;
        }

        public function setPassword($password) {
            $this->password = password_hash($password, PASSWORD_BCRYPT);
        }
    }
}
?>
