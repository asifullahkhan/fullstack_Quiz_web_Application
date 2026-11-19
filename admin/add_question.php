<?php
require_once("admin_auth.php");
require_once(__DIR__ . "/../db.php");

$message = "";

$subjectQuery = "SELECT * FROM subjects ORDER BY subject_name ASC";
$subjectResult = mysqli_query($conn, $subjectQuery);

if (isset($_POST['save_question'])) {
    $subjectId = (int)$_POST['subject_id'];
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $option1 = mysqli_real_escape_string($conn, $_POST['option1']);
    $option2 = mysqli_real_escape_string($conn, $_POST['option2']);
    $option3 = mysqli_real_escape_string($conn, $_POST['option3']);
    $option4 = mysqli_real_escape_string($conn, $_POST['option4']);
    $correct = mysqli_real_escape_string($conn, $_POST['correct_answer']);
    $explanation = mysqli_real_escape_string($conn, $_POST['explanation']);
    $marks = (int)$_POST['marks'];

    $insert = "INSERT INTO questions (subject_id, question, option1, option2, option3, option4, correct_answer, explanation, marks)
               VALUES ('$subjectId', '$question', '$option1', '$option2', '$option3', '$option4', '$correct', '$explanation', '$marks')";

    if (mysqli_query($conn, $insert)) {
        $message = "<div class='success'>Question added successfully.</div>";
    } else {
        $message = "<div class='error'>Unable to add question.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f7fb; margin: 0; padding: 24px; }
        .wrap { max-width: 800px; margin: 0 auto; background: #fff; border-radius: 14px; padding: 24px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        .field { margin-bottom: 14px; }
        label { display: block; margin-bottom: 6px; font-weight: 600; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #cfd8e3; border-radius: 8px; }
        button, a { display: inline-block; padding: 10px 16px; border-radius: 8px; text-decoration: none; }
        button { background: #198754; color: #fff; border: 0; cursor: pointer; }
        a { background: #6c757d; color: #fff; margin-left: 8px; }
        .success { background: #d1f5df; color: #0a5d2c; padding: 12px; border-radius: 8px; margin-bottom: 16px; }
        .error { background: #f8d7da; color: #842029; padding: 12px; border-radius: 8px; margin-bottom: 16px; }
    </style>
</head>
<body>
    <div class="wrap">
        <h2>Add Question</h2>
        <?php echo $message; ?>

        <form method="POST">
            <div class="field">
                <label>Subject</label>
                <select name="subject_id" required>
                    <?php while ($subject = mysqli_fetch_assoc($subjectResult)) : ?>
                        <option value="<?php echo (int)$subject['id']; ?>"><?php echo htmlspecialchars($subject['subject_name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="field">
                <label>Question</label>
                <textarea name="question" rows="3" required></textarea>
            </div>

            <div class="field">
                <label>Option 1</label>
                <input type="text" name="option1" required>
            </div>

            <div class="field">
                <label>Option 2</label>
                <input type="text" name="option2" required>
            </div>

            <div class="field">
                <label>Option 3</label>
                <input type="text" name="option3" required>
            </div>

            <div class="field">
                <label>Option 4</label>
                <input type="text" name="option4" required>
            </div>

            <div class="field">
                <label>Correct Answer (A/B/C/D)</label>
                <input type="text" name="correct_answer" maxlength="1" required>
            </div>

            <div class="field">
                <label>Explanation</label>
                <textarea name="explanation" rows="3"></textarea>
            </div>

            <div class="field">
                <label>Marks</label>
                <input type="number" name="marks" value="1" required>
            </div>

            <button type="submit" name="save_question">Save Question</button>
            <a href="questions.php">Back</a>
        </form>
    </div>
</body>
</html>
