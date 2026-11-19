<?php
require_once("auth.php");
require_once("db.php");
include("header.php");

try {
    if (!isset($_SESSION['student_id'])) {
        throw new Exception("Student session is not active.");
    }

    if (!empty($_SESSION['quiz_submitted'])) {
        header("Location: result.php");
        exit();
    }

    $subjectId = (int)($_SESSION['subject_id'] ?? 0);
    if ($subjectId <= 0) {
        throw new Exception("No subject selected.");
    }

    $sql = "SELECT * FROM questions WHERE subject_id = ? ORDER BY id ASC";
    $statement = $conn->prepare($sql);
    $statement->bind_param("i", $subjectId);
    $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("No questions found for this subject.");
    }
} catch (Exception $exception) {
    error_log("Quiz page error: " . $exception->getMessage());
    header("Location: subject.php");
    exit();
}
?>

<link rel="stylesheet" href="assets/CSS/quiz.css">

<div class="container">

    <div class="quiz-header">
        <h1><?php echo htmlspecialchars($_SESSION['subject_name'] ?? 'Quiz'); ?> Quiz</h1>
        <div class="quiz-timer" id="quizTimer">20:00</div>
    </div>

    <form action="result.php" method="POST" id="quizForm">

        <?php
        $number = 1;
        while ($row = $result->fetch_assoc()) {
        ?>

        <div class="question">
            <h3>Question <?php echo $number; ?></h3>
            <p><?php echo htmlspecialchars($row['question']); ?></p>

            <label><input type="radio" name="answer[<?php echo (int)$row['id']; ?>]" value="A"> <?php echo htmlspecialchars($row['option1']); ?></label>
            <label><input type="radio" name="answer[<?php echo (int)$row['id']; ?>]" value="B"> <?php echo htmlspecialchars($row['option2']); ?></label>
            <label><input type="radio" name="answer[<?php echo (int)$row['id']; ?>]" value="C"> <?php echo htmlspecialchars($row['option3']); ?></label>
            <label><input type="radio" name="answer[<?php echo (int)$row['id']; ?>]" value="D"> <?php echo htmlspecialchars($row['option4']); ?></label>
        </div>

        <?php
            $number++;
        }
        ?>

        <div class="quiz-actions">
            <button type="submit" name="submit">Submit Quiz</button>
        </div>

    </form>

</div>

<script src="assets/JS/quiz.js"></script>
<script>
window.history.pushState(null, '', location.href);
window.addEventListener('popstate', function () {
    window.history.pushState(null, '', location.href);
});
</script>

<?php include("footer.php"); ?>