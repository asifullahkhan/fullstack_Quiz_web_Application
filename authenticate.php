<?php

session_start();

require_once("db.php");

/* ==========================================
   Allow Only POST Requests
========================================== */

if ($_SERVER["REQUEST_METHOD"] != "POST")
{
    header("Location: login.php");
    exit();
}

/* ==========================================
   Get Form Data
========================================== */

$reg_no = trim($_POST['registration_no'] ?? '');
$password = trim($_POST['password'] ?? '');

/* ==========================================
   Validate Input
========================================== */

if(empty($reg_no) || empty($password))
{
    echo "<script>
    alert('Please fill all fields.');
    window.location='login.php';
    </script>";
    exit();
}

/* ==========================================
   Find Student
========================================== */

$sql = "SELECT * FROM students WHERE reg_no = ? LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);

if(!$stmt)
{
    die("Database Error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $reg_no);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result) == 1)
{
    $student = mysqli_fetch_assoc($result);

    /*
    -------------------------------------------
    Plain Text Password
    -------------------------------------------
    */

    if($password == $student['password'])
    {

        $_SESSION['student_id'] = $student['id'];
        $_SESSION['student_name'] = $student['full_name'];
        $_SESSION['reg_no'] = $student['reg_no'];
        $_SESSION['registration_no'] = $student['reg_no'];

        header("Location: dashboard.php");
        exit();

    }
    else
    {

        echo "<script>
        alert('Incorrect Password');
        window.location='login.php';
        </script>";

        exit();

    }

}
else
{

    echo "<script>
    alert('Registration Number not found');
    window.location='login.php';
    </script>";

    exit();

}

?>