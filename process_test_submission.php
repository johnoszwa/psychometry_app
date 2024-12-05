<?php
// Debugging step: Check if this script is being accessed directly
echo "Debug: Reached process_test_submission.php";

// Check if form data is posted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "Debug: Form data received.";
    if (isset($_POST['submit_answer'])) {
        echo "Debug: Submit button was clicked.";
        // Process the submitted answer here (e.g., validate and store the answer)
        
        // Example: Process the submitted answer and redirect or show a success message
        // You can access POST data like this: $_POST['answer_input_name']
        
        // Redirect to another page after processing (optional)
        header('Location: view_result.php'); // Replace with the correct redirect page
        exit;
    } else {
        echo "Debug: Submit button not clicked.";
    }
} else {
    echo "Debug: No POST data received.";
}
?>
