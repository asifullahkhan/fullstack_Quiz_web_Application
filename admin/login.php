<?php
session_start();

if(isset($_SESSION['student_id']))
{
    header("Location: ../dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Student Login</title>

<link rel="stylesheet" href="../assets/CSS/student-login.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<div class="student-login-page">

    <div class="student-login-page__card">

        <div class="student-login-page__logo">

            <i class="fa-solid fa-user-graduate"></i>

        </div>

        <h1>Student Login</h1>

        <p>Online Quiz Management System</p>

        <form action="../authenticate.php" method="POST">

            <div class="student-login-page__group">

                <label>Registration Number</label>

                <input
                type="text"
                name="registration_no"
                placeholder="Enter Registration Number"
                required>

            </div>

            <div class="student-login-page__group">

                <label>Password</label>

                <input
                type="password"
                name="password"
                placeholder="Enter Password"
                required>

            </div>

            <button
            type="submit"
            class="student-login-page__button">

            <i class="fa-solid fa-right-to-bracket"></i>

            Login

            </button>

        </form>

    </div>

</div>

</body>

</html>