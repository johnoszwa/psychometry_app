<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $contact_number = $_POST['contact_number'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    try {
        // Prepare the query
        $stmt = $conn->prepare(
            "INSERT INTO User (first_name, last_name, email, dob, gender, contact_number, password)
            VALUES (:first_name, :last_name, :email, :dob, :gender, :contact_number, :password)"
        );

        // Bind parameters securely
        $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':dob', $dob, PDO::PARAM_STR);
        $stmt->bindValue(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindValue(':contact_number', $contact_number, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);

        // Execute the statement
        $stmt->execute();

        echo "Registration successful!";
        header('Location: login.html'); // Redirect to login page after successful registration
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage(); // Handle exceptions
    }
}
?>
