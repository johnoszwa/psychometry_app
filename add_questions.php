<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

include 'db_connection.php';

// Fetch available tests for selection
try {
    $tests_stmt = $conn->prepare("SELECT test_id, test_name FROM Psychometric_Test");
    $tests_stmt->execute();
    $tests = $tests_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Error fetching tests: " . $e->getMessage();
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $test_id = intval($_POST['test_id']);
    $question_text = $_POST['question_text'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_option = $_POST['correct_option'];

    try {
        $stmt = $conn->prepare("
            INSERT INTO Questions (test_id, question_text, option_a, option_b, option_c, option_d, correct_option)
            VALUES (:test_id, :question_text, :option_a, :option_b, :option_c, :option_d, :correct_option)
        ");
        $stmt->bindValue(':test_id', $test_id, PDO::PARAM_INT);
        $stmt->bindValue(':question_text', $question_text, PDO::PARAM_STR);
        $stmt->bindValue(':option_a', $option_a, PDO::PARAM_STR);
        $stmt->bindValue(':option_b', $option_b, PDO::PARAM_STR);
        $stmt->bindValue(':option_c', $option_c, PDO::PARAM_STR);
        $stmt->bindValue(':option_d', $option_d, PDO::PARAM_STR);
        $stmt->bindValue(':correct_option', $correct_option, PDO::PARAM_STR);
        $stmt->execute();

        echo "<p class='success-msg'>Question added successfully!</p>";
    } catch (Exception $e) {
        echo "<p class='error-msg'>Error adding question: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Questions</title>
    <link rel="stylesheet" href="styles/form-styles.css">
</head>
<body>
    <div class="form-container">
        <h1>Add a New Question</h1>
        <form action="add_questions.php" method="post">
            <div class="form-group">
                <label for="test_id">Select Test</label>
                <select name="test_id" id="test_id" required>
                    <option value="">--Please select a test--</option>
                    <?php
                    foreach ($tests as $test) {
                        echo "<option value='" . $test['test_id'] . "'>" . htmlspecialchars($test['test_name']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="question">Question</label>
                <input type="text" name="question_text" id="question" required placeholder="Enter the question">
            </div>

            <div class="form-group">
                <label for="option_a">Option A</label>
                <input type="text" name="option_a" id="option_a" required placeholder="Enter option A">
            </div>

            <div class="form-group">
                <label for="option_b">Option B</label>
                <input type="text" name="option_b" id="option_b" required placeholder="Enter option B">
            </div>

            <div class="form-group">
                <label for="option_c">Option C</label>
                <input type="text" name="option_c" id="option_c" required placeholder="Enter option C">
            </div>

            <div class="form-group">
                <label for="option_d">Option D</label>
                <input type="text" name="option_d" id="option_d" required placeholder="Enter option D">
            </div>

            <div class="form-group">
                <label for="correct_option">Correct Option</label>
                <select name="correct_option" id="correct_option" required>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </div>

            <button type="submit" class="submit-btn">Add Question</button>
        </form>

        <a href="dashboard.php" class="back-link">Back to Dashboard</a>
    </div>
</body>
</html>
