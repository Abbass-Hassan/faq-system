<?php

// Prevent duplicate class declarations
if (!class_exists('FAQSkeleton')) {
    class FAQSkeleton {
        private $id;
        private $question;
        private $answer;
        private $created_at;

        public function __construct($id, $question, $answer, $created_at) {
            $this->id = $id;
            $this->question = $question;
            $this->answer = $answer;
            $this->created_at = $created_at;
        }

        // Getters
        public function getId() {
            return $this->id;
        }

        public function getQuestion() {
            return $this->question;
        }

        public function getAnswer() {
            return $this->answer;
        }

        public function getCreatedAt() {
            return $this->created_at;
        }

        // Setters
        public function setQuestion($question) {
            $this->question = $question;
        }

        public function setAnswer($answer) {
            $this->answer = $answer;
        }
    }
}
?>
