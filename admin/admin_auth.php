<?php

session_start();

/* ==========================================
   Check Admin Login
========================================== */

if (!isset($_SESSION['admin_id']))
{
    header("Location: login.php");
    exit();
}

/* ==========================================
   Store Session Variables
========================================== */

$admin_id = $_SESSION['admin_id'];
$admin_username = $_SESSION['admin_username'] ?? 'Admin';

?>