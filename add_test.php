<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

include 'db_connection.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $test_name = $_POST['test_name'];

    try {
        $stmt = $conn->prepare("INSERT INTO Psychometric_Test (test_name) VALUES (:test_name)");
        $stmt->bindValue(':test_name', $test_name, PDO::PARAM_STR);
        $stmt->execute();

        echo "<p class='success-msg'>Test added successfully!</p>";
    } catch (Exception $e) {
        echo "<p class='error-msg'>Error adding test: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        button {
            padding: 10px 20px;
            cursor: pointer;
        }
        .success-msg, .error-msg {
            margin-top: 15px;
            padding: 10px;
            border-radius: 5px;
        }
        .success-msg {
            background-color: #d4edda;
            color: #155724;
        }
        .error-msg {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h1>Add a New Test</h1>
    <form action="add_test.php" method="post">
        <div class="form-group">
            <label for="test_name">Test Name</label>
            <input type="text" name="test_name" id="test_name" required>
        </div>
        <button type="submit">Add Test</button>
    </form>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
