<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

if (!isset($_SESSION['test_id'])) {
    echo "No test started.";
    exit;
}

$test_id = $_SESSION['test_id'];
$current_question = $_SESSION['current_question'];
$questions = $_SESSION['questions'];

if ($current_question >= count($questions)) {
    // If all questions have been answered, redirect to the results page
    header('Location: view_results.php');
    exit;
}

$current_question_data = $questions[$current_question];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test - Question <?php echo $current_question + 1; ?></title>
</head>
<body>
    <h1>Question <?php echo $current_question + 1; ?></h1>
    <p><?php echo htmlspecialchars($current_question_data['question_text']); ?></p>

    <form action="submit_answer.php" method="post">
        <input type="radio" name="answer" value="A" id="option_a" required>
        <label for="option_a"><?php echo htmlspecialchars($current_question_data['option_a']); ?></label><br>
        
        <input type="radio" name="answer" value="B" id="option_b">
        <label for="option_b"><?php echo htmlspecialchars($current_question_data['option_b']); ?></label><br>
        
        <input type="radio" name="answer" value="C" id="option_c">
        <label for="option_c"><?php echo htmlspecialchars($current_question_data['option_c']); ?></label><br>
        
        <input type="radio" name="answer" value="D" id="option_d">
        <label for="option_d"><?php echo htmlspecialchars($current_question_data['option_d']); ?></label><br>

        <?php if ($current_question == count($questions) - 1): ?>
            <p>This is the last question. After submitting, you will be redirected to view your results.</p>
        <?php endif; ?>

        <button type="submit">Submit Answer</button>
    </form>
</body>
</html>
