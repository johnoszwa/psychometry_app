<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Use the correct PDO method
        $stmt = $conn->prepare("SELECT * FROM User WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR); // Bind the email parameter
        $stmt->execute(); // Execute the query
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the user data

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            header('Location: dashboard.php'); // Redirect to dashboard
            exit;
        } else {
            echo "Invalid email or password."; // Show error message
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage(); // Handle exceptions
    }
}
?>
