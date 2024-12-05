<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

// Check if test_id is passed via GET
if (!isset($_GET['test_id']) || empty($_GET['test_id'])) {
    echo "No test selected.";
    exit;
}

$test_id = intval($_GET['test_id']);
include 'db_connection.php';

// Fetch questions for the selected test
try {
    $stmt = $conn->prepare("SELECT * FROM Questions WHERE test_id = :test_id");
    $stmt->bindParam(':test_id', $test_id, PDO::PARAM_INT);
    $stmt->execute();
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($questions)) {
        echo "No questions found for this test.";
        exit;
    }
} catch (Exception $e) {
    echo "Error fetching questions: " . $e->getMessage();
    exit;
}

// Store the test ID and questions in the session for later use
$_SESSION['test_id'] = $test_id;
$_SESSION['questions'] = $questions;
$_SESSION['current_question'] = 0; // Initialize current question index

// Redirect to the test page to display the first question
header('Location: display_test.php');
exit;
?>
