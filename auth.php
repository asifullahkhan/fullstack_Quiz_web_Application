<?php

session_start();

/* ==========================================
   Check Student Login
========================================== */

if (!isset($_SESSION['student_id']))
{
    header("Location: login.php");
    exit();
}

/* ==========================================
   Store Session Values
========================================== */

$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'];
$registration_no = $_SESSION['reg_no'] ?? ($_SESSION['registration_no'] ?? '');

?>