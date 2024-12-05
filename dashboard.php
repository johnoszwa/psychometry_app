<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

include 'db_connection.php';

// Get user information
try {
    $stmt = $conn->prepare("SELECT first_name, last_name FROM User WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found.";
        exit;
    }
} catch (Exception $e) {
    echo "Error fetching user data: " . $e->getMessage();
    exit;
}

// Fetch available tests for the form
try {
    $tests_stmt = $conn->prepare("SELECT test_id, test_name FROM Psychometric_Test");
    $tests_stmt->execute();
    $tests = $tests_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "<div style='color: red;'>Error fetching tests: " . htmlspecialchars($e->getMessage()) . "</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        h2 {
            color: #555;
            margin-bottom: 20px;
            text-align: center;
        }
        ul {
            list-style: none;
            padding: 0;
            text-align: center;
        }
        li {
            margin: 15px 0;
        }
        a {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: #007BFF;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #0056b3;
        }
        .welcome-message {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
            text-align: center;
        }
        .form-container {
            margin-bottom: 20px;
        }
        select, button {
            display: block;
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #28a745;
            color: #ffffff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-message">
            <h1>Welcome, <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>!</h1>
        </div>

        <h2>Navigate to:</h2>
        <ul>
            <li><a href="view_result.php">View Results</a></li>
            <li><a href="add_questions.php">Add Questions</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>

        <div class="form-container">
            <h2>Select a Test to Start</h2>
            <form action="start_test.php" method="get">
                <label for="test_id">Select Test:</label>
                <select name="test_id" id="test_id" required>
                    <option value="">--Please select a test--</option>
                    <?php
                    foreach ($tests as $test) {
                        echo "<option value=\"" . htmlspecialchars($test['test_id']) . "\">" . htmlspecialchars($test['test_name']) . "</option>";
                    }
                    ?>
                </select>
                <button type="submit">Start Test</button>
            </form>
        </div>
    </div>
</body>
</html>
