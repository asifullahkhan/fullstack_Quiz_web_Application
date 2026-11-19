<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Online Quiz Management System</title>

    <!-- CSS -->

    <link rel="stylesheet" href="assets/CSS/CSS.css">

    <!-- Google Font -->

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<header class="oqms-header">

    <div class="oqms-header__logo">

        <i class="fa-solid fa-graduation-cap"></i>

        <span>Online Quiz System</span>

    </div>

    <?php if(isset($_SESSION['student_name'])) { ?>

    <div class="oqms-header__user">

        <i class="fa-solid fa-circle-user"></i>

        <span>

            <?php echo $_SESSION['student_name']; ?>

        </span>

        <a href="logout.php" class="oqms-header__logout">

            Logout

        </a>

    </div>

    <?php } ?>

</header>

<div class="oqms-page-wrapper">