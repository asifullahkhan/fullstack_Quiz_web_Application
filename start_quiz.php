<?php

session_start();
require_once("db.php");
require_once("classes/QuizService.php");

try {
    if (!isset($_POST['subject_id']) || !isset($_POST['subject_name'])) {
        throw new Exception("Subject selection is missing.");
    }

    $studentId = (int)($_SESSION['student_id'] ?? 0);
    $subjectId = (int)$_POST['subject_id'];

    if ($studentId <= 0) {
        throw new Exception("Student session is not active.");
    }

    $quizService = new QuizService($conn);
    $attemptCount = $quizService->getAttemptCount($studentId, $subjectId);
    $hasPaid = $quizService->hasPaidForExtraAttempts($studentId, $subjectId);

    if ($attemptCount >= 5 && !$hasPaid) {
        $_SESSION['pending_payment_subject_id'] = $subjectId;
        header("Location: payment.php?subject_id=" . $subjectId);
        exit();
    }

    $_SESSION['subject_id'] = $subjectId;
    $_SESSION['subject_name'] = trim($_POST['subject_name']);
    $_SESSION['quiz_submitted'] = false;

    header("Location: instructions.php");
    exit();
} catch (Exception $exception) {
    error_log("Start quiz error: " . $exception->getMessage());
    $_SESSION['system_message'] = "Unable to start quiz right now.";
    header("Location: dashboard.php");
    exit();
}