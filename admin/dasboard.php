<?php
require_once(__DIR__ . "/../db.php");
require_once("admin_auth.php");
// include("db.php");
// Ensure session is started and provide a fallback for admin username
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$admin_username = 'Admin';
if (!empty($_SESSION['admin_username'])) {
    $admin_username = $_SESSION['admin_username'];
} elseif (!empty($_SESSION['username'])) {
    $admin_username = $_SESSION['username'];
}

/* ==========================================
   Dashboard Statistics
========================================== */

$studentCount = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM students"))['total'];

$subjectCount = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM subjects"))['total'];

$questionCount = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM questions"))['total'];

$resultCount = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM results"))['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard</title>

<link rel="stylesheet" href="../assets/CSS/admin-dashboard.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<div class="admin-dashboard">

    <aside class="admin-dashboard__sidebar">

        <h2>Quiz Admin</h2>

        <a href="dashboard.php">
            <i class="fa fa-home"></i> Dashboard
        </a>

        <a href="subjects.php">
            <i class="fa fa-book"></i> Subjects
        </a>

        <a href="questions.php">
            <i class="fa fa-list"></i> Questions
        </a>

        <a href="students.php">
            <i class="fa fa-users"></i> Students
        </a>

        <a href="results.php">
            <i class="fa fa-chart-line"></i> Results
        </a>

        <a href="logout.php">
            <i class="fa fa-sign-out-alt"></i> Logout
        </a>

    </aside>

    <main class="admin-dashboard__content">

        <h1>Welcome,
            <?php echo htmlspecialchars($admin_username); ?>
        </h1>

        <div class="admin-dashboard__cards">

            <div class="admin-dashboard__card">

                <i class="fa fa-users"></i>

                <h2><?php echo $studentCount; ?></h2>

                <p>Students</p>

            </div>

            <div class="admin-dashboard__card">

                <i class="fa fa-book"></i>

                <h2><?php echo $subjectCount; ?></h2>

                <p>Subjects</p>

            </div>

            <div class="admin-dashboard__card">

                <i class="fa fa-list"></i>

                <h2><?php echo $questionCount; ?></h2>

                <p>Questions</p>

            </div>

            <div class="admin-dashboard__card">

                <i class="fa fa-chart-bar"></i>

                <h2><?php echo $resultCount; ?></h2>

                <p>Results</p>

            </div>

        </div>

    </main>

</div>

</body>

</html>