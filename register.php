<?php
session_start();
require_once("db.php");

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $regNo = trim($_POST['reg_no'] ?? '');
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($regNo === '' || $fullName === '' || $email === '' || $password === '') {
        $message = "<div class='error'>Please fill in all fields.</div>";
    } else {
        $check = mysqli_prepare($conn, "SELECT id FROM students WHERE reg_no = ? OR email = ? LIMIT 1");
        mysqli_stmt_bind_param($check, "ss", $regNo, $email);
        mysqli_stmt_execute($check);
        $result = mysqli_stmt_get_result($check);

        if (mysqli_num_rows($result) > 0) {
            $message = "<div class='error'>Registration number or email already exists.</div>";
        } else {
            $insert = mysqli_prepare($conn, "INSERT INTO students (reg_no, full_name, email, password) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($insert, "ssss", $regNo, $fullName, $email, $password);

            if (mysqli_stmt_execute($insert)) {
                $_SESSION['student_id'] = mysqli_insert_id($conn);
                $_SESSION['student_name'] = $fullName;
                $_SESSION['registration_no'] = $regNo;
                $_SESSION['reg_no'] = $regNo;

                header("Location: dashboard.php");
                exit();
            } else {
                $message = "<div class='error'>Unable to register student.</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="assets/CSS/student-login.css">
</head>
<body>
    <div class="student-login-page">
        <div class="student-login-page__card">
            <div class="student-login-page__logo"><i class="fa-solid fa-user-plus"></i></div>
            <h1>Register Student</h1>
            <p>Create a new student account.</p>

            <?php echo $message; ?>

            <form action="register.php" method="POST">
                <div class="student-login-page__group">
                    <label>Registration Number</label>
                    <input type="text" name="reg_no" placeholder="Enter Registration Number" required>
                </div>

                <div class="student-login-page__group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" placeholder="Enter Full Name" required>
                </div>

                <div class="student-login-page__group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter Email" required>
                </div>

                <div class="student-login-page__group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter Password" required>
                </div>

                <button type="submit" class="student-login-page__button">Register</button>
                <p style="margin-top:14px;"><a href="admin/login.php">Already have an account? Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>
