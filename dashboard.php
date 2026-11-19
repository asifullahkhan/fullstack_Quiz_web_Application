<?php
require_once("auth.php");
require_once("db.php");
include("header.php");
?>

<link rel="stylesheet" href="assets/CSS/dashboard.css">

<div class="dashboard-page">

    <div class="dashboard-page__hero">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['student_name'] ?? 'Student'); ?></h1>
        <p>Choose a subject to start your quiz.</p>
    </div>

    <div class="dashboard-page__actions">
        <a href="subject.php" class="dashboard-page__button">Start Quiz</a>
        <a href="history.php" class="dashboard-page__button">Quiz History</a>
        <a href="profile.php" class="dashboard-page__button">Profile</a>
    </div>

</div>

<?php include("footer.php"); ?>