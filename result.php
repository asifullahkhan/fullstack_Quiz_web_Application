<?php
require_once("auth.php");
require_once("db.php");
require_once("classes/QuizService.php");
include("header.php");

$quizService = new QuizService($conn);
$systemMessage = "";

try {
    if (!isset($_POST['submit'])) {
        header("Location: subject.php");
        exit();
    }

    if (!empty($_SESSION['quiz_submitted'])) {
        header("Location: history.php");
        exit();
    }

    $subjectId = (int)($_SESSION['subject_id'] ?? 0);
    $studentId = (int)($_SESSION['student_id'] ?? 0);

    if ($subjectId <= 0 || $studentId <= 0) {
        throw new Exception("Quiz session is invalid.");
    }

    $answers = $_POST['answer'] ?? [];
    $score = 0;
    $total = 0;
    $notAttempted = 0;

    $query = "SELECT * FROM questions WHERE subject_id = ? ORDER BY id ASC";
    $statement = $conn->prepare($query);
    $statement->bind_param("i", $subjectId);
    $statement->execute();
    $questionResult = $statement->get_result();

    if ($questionResult->num_rows === 0) {
        throw new Exception("No questions are available for this subject.");
    }

    echo "<link rel='stylesheet' href='assets/CSS/result.css'>";
    echo "<div class='result-page'>";
    echo "<h1>Quiz Result</h1>";

    while ($row = $questionResult->fetch_assoc()) {
        $total++;
        $qid = (int)$row['id'];
        $correct = $row['correct_answer'];
        $studentAnswer = $answers[$qid] ?? null;

        if ($studentAnswer === null) {
            $notAttempted++;
        } elseif ($studentAnswer === $correct) {
            $score++;
        }

        echo "<hr><h3>" . htmlspecialchars($row['question']) . "</h3>";
        echo "<b>Your Answer:</b> " . htmlspecialchars($studentAnswer ?? 'Not Attempted') . "<br>";
        echo "<b>Correct Answer:</b> " . htmlspecialchars($correct) . "<br>";

        if ($studentAnswer === null) {
            echo "<span style='color:orange;'>Not Attempted</span>";
        } elseif ($studentAnswer === $correct) {
            echo "<span style='color:green;'>Correct</span>";
        } else {
            echo "<span style='color:red;'>Wrong</span><br><br>";
            echo "<b>Explanation:</b><br>" . htmlspecialchars($row['explanation'] ?? '');
        }
    }

    echo "<hr><h2>Marks : $score / $total</h2>";
    $percentage = $total > 0 ? round(($score / $total) * 100, 2) : 0;
    echo "<h2>Percentage : " . number_format($percentage, 2) . "%</h2>";

    $totalQuestions = $total;
    $correctAnswers = $score;
    $wrongAnswers = $totalQuestions - $score - $notAttempted;

    if ($percentage >= 90) {
        $grade = "A+";
    } elseif ($percentage >= 80) {
        $grade = "A";
    } elseif ($percentage >= 70) {
        $grade = "B";
    } elseif ($percentage >= 60) {
        $grade = "C";
    } else {
        $grade = "F";
    }

    $status = ($percentage >= 50) ? "PASS" : "FAIL";

    $insert = $conn->prepare("INSERT INTO results (student_id, subject_id, total_questions, correct_answers, wrong_answers, not_attempted, marks, percentage, grade, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insert->bind_param("iiiiiiidss", $studentId, $subjectId, $totalQuestions, $correctAnswers, $wrongAnswers, $notAttempted, $score, $percentage, $grade, $status);

    if (!$insert->execute()) {
        throw new Exception("Unable to save quiz result.");
    }

    $_SESSION['quiz_submitted'] = true;
    $_SESSION['last_result_subject_id'] = $subjectId;

    $studentQuery = $conn->prepare("SELECT email, full_name FROM students WHERE id = ? LIMIT 1");
    $studentQuery->bind_param("i", $studentId);
    $studentQuery->execute();
    $studentRecord = $studentQuery->get_result()->fetch_assoc();

    if ($studentRecord) {
        $emailMessage = "Dear " . $studentRecord['full_name'] . ",\n\nYour quiz has been submitted successfully.\nScore: " . $score . " / " . $totalQuestions . "\nPercentage: " . number_format($percentage, 2) . "%\nGrade: " . $grade . "\nStatus: " . $status . "\n\nThank you for using the Online Quiz Management System.";
        $quizService->sendEmail($studentRecord['email'], "Quiz Submission Acknowledgement", $emailMessage);
    }

    echo "<div class='result-page__actions'><a class='result-page__button' href='dashboard.php'>Done</a></div>";
    echo "</div>";
} catch (Exception $exception) {
    error_log("Result page error: " . $exception->getMessage());
    $systemMessage = "Unable to process the result right now.";
    echo "<div class='result-page__error'>" . htmlspecialchars($systemMessage) . "</div>";
    echo "<div class='result-page__actions'><a class='result-page__button' href='dashboard.php'>Done</a></div>";
}

include("footer.php");
?>