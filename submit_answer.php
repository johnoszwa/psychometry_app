<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

// Check if test session data exists
if (!isset($_SESSION['test_id'])) {
    echo "No test started.";
    exit;
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['answer'])) {
        $answer = htmlspecialchars($_POST['answer']);
        $current_question = $_SESSION['current_question'];
        $_SESSION['answers'][$current_question] = $answer; // Save the current answer to session

        // Increment the current question index
        $_SESSION['current_question']++;

        // Check if we've reached the end of the test
        if ($_SESSION['current_question'] < count($_SESSION['questions'])) {
            // Redirect to the next question if there are more questions
            header('Location: display_test.php');
            exit;
        } else {
            // Display a message before redirecting to results (optional)
            echo "<h1>End of Test</h1>";
            echo "<p>Thank you for completing the test. You will be redirected to your results shortly.</p>";

            // Redirect to results page after a short delay
            header("Refresh: 3; URL=view_results.php");
            exit;
        }
    } else {
        echo "No answer provided.";
    }
} else {
    // Redirect to the test page if the request is not POST
    header("Location: view_result.php");
exit;

}
?>
