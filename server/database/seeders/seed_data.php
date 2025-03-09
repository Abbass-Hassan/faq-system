<?php
require_once __DIR__ . '/../../connection/db.php'; 

try {
    // --- SEED A SINGLE USER ---
    $userFullname = "Abbas Hassan";
    $userEmail    = "abbasHassan@gmail.com";
    $rawPassword  = "password123";
    $hashedPass   = hash("sha256", $rawPassword);

    // Insert user if not exists
    $checkUser = $conn->prepare("SELECT id FROM users WHERE email = :email");
    $checkUser->execute([':email' => $userEmail]);
    $existingUser = $checkUser->fetch();

    if (!$existingUser) {
        $insertUser = $conn->prepare("
            INSERT INTO users (fullname, email, password, created_at) 
            VALUES (:fullname, :email, :password, NOW())
        ");
        $insertUser->execute([
            ':fullname' => $userFullname,
            ':email'    => $userEmail,
            ':password' => $hashedPass
        ]);
        echo "User seeded successfully!\n";
    } else {
        echo "User already exists, skipping user seed.\n";
    }

    // --- SEED MULTIPLE FAQS ---
    $faqs = [
        [
            "question" => "What is Prompt Engineering?",
            "answer"   => "Prompt engineering is the practice of designing and refining inputs for large language models so that their outputs are more controlled, useful, and aligned with specific goals."
        ],
        [
            "question" => "How are prompt patterns similar to software patterns?",
            "answer"   => "Both are reusable solutions that follow a structure and provide clarity. Prompt patterns adapt software pattern principles to LLM interactions."
        ],
        [
            "question" => "What is the Meta Language Creation Pattern?",
            "answer"   => "It introduces an alternative notation to express complex ideas succinctly, reducing verbosity and potential ambiguity in prompts."
        ],
        [
            "question" => "What does the Persona Pattern achieve?",
            "answer"   => "It assigns a specific role or perspective to the LLM, guiding outputs toward that expertise or viewpoint."
        ],
        [
            "question" => "How does the Output Automater Pattern help?",
            "answer"   => "It instructs the LLM to generate executable artifacts (like Python scripts) that automate multi-step processes, reducing manual coding."
        ],
        [
            "question" => "Why use the Fact Check List Pattern?",
            "answer"   => "It appends a list of key facts or assumptions to the output, making it easier for users to validate correctness."
        ],
        [
            "question" => "What is the purpose of the Infinite Generation Pattern?",
            "answer"   => "It enables continuous output generation without re-entering the prompt, though a stopping rule is essential."
        ],
        [
            "question" => "How can multiple prompt patterns be integrated?",
            "answer"   => "Combining patterns (like Persona + Fact Check List) can tailor responses while also highlighting critical facts to verify."
        ]
    ];

    // Insert each FAQ if not exists
    foreach ($faqs as $faq) {
        $checkFaq = $conn->prepare("SELECT id FROM faqs WHERE question = :question");
        $checkFaq->execute([':question' => $faq['question']]);
        $existingFaq = $checkFaq->fetch();

        if (!$existingFaq) {
            $insertFaq = $conn->prepare("
                INSERT INTO faqs (question, answer, created_at) 
                VALUES (:question, :answer, NOW())
            ");
            $insertFaq->execute([
                ':question' => $faq['question'],
                ':answer'   => $faq['answer']
            ]);
            echo "Seeded FAQ: {$faq['question']}\n";
        } else {
            echo "FAQ already exists, skipping: {$faq['question']}\n";
        }
    }

    echo "Seeding completed successfully!\n";

} catch (Exception $e) {
    echo "Seeding error: " . $e->getMessage() . "\n";
}
