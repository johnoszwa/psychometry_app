<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

include 'db_connection.php';

$user_id = $_SESSION['user_id'];
$test_id = $_POST['test_id'];
$answers = $_POST['answers'];
$total_questions = count($answers);
$correct_answers = 0;

try {
    // Fetch correct answers from the database
    $stmt = $conn->prepare("SELECT question_id, correct_option FROM Questions WHERE test_id = :test_id");
    $stmt->bindValue(':test_id', $test_id, PDO::PARAM_INT);
    $stmt->execute();
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($questions as $question) {
        $question_id = $question['question_id'];
        $correct_option = $question['correct_option'];
        
        if (isset($answers[$question_id]) && $answers[$question_id] === $correct_option) {
            $correct_answers++;
        }
    }

    // Calculate score
    $score = ($correct_answers / $total_questions) * 100;

    // Insert test result into the database
    $result_stmt = $conn->prepare("
        INSERT INTO Test_Result (user_id, test_id, score, interpretation)
        VALUES (:user_id, :test_id, :score, :interpretation)
    ");
    $result_stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $result_stmt->bindValue(':test_id', $test_id, PDO::PARAM_INT);
    $result_stmt->bindValue(':score', $score, PDO::PARAM_STR);
    $result_stmt->bindValue(':interpretation', "You scored $score%.", PDO::PARAM_STR);
    $result_stmt->execute();

    echo "Test submitted successfully! Your score: $score%.";
    echo '<br><a href="dashboard.php">Go back to dashboard</a>';
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
