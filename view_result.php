<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

if (!isset($_SESSION['test_id'])) {
    echo "No test data found.";
    exit;
}

$questions = $_SESSION['questions'];
$answers = $_SESSION['answers'] ?? [];

echo "<h1>Test Results</h1>";

$total_questions = count($questions);
$score = 0;

foreach ($questions as $index => $question) {
    $correct_answer = $question['correct_answer'] ?? 'N/A'; // Default to 'N/A' if not set
    $user_answer = $answers[$index] ?? 'N/A'; // Default to 'N/A' if not set

    echo "<h3>Question " . ($index + 1) . "</h3>";
    echo "<p>Question: " . htmlspecialchars($question['question_text']) . "</p>";
    echo "<p>Your Answer: " . htmlspecialchars($user_answer) . "</p>";
    echo "<p>Correct Answer: " . htmlspecialchars($correct_answer) . "</p>";

    if ($user_answer == $correct_answer) {
        $score++;
    }
}

echo "<h2>Your Score: $score / $total_questions</h2>";
echo "<p>Thank you for completing the test.</p>";
?>
