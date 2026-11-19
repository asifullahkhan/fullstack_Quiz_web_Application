<?php

require_once("admin_auth.php");
require_once(__DIR__ . "/../db.php");
/* ==========================================
   Check Subject ID
========================================== */

if(!isset($_GET['id']))
{
    header("Location: subjects.php");
    exit();
}

$id = (int)$_GET['id'];

/* ==========================================
   Check if Subject Exists
========================================== */

$checkQuery = "SELECT * FROM subjects WHERE id='$id'";
$checkResult = mysqli_query($conn,$checkQuery);

if(mysqli_num_rows($checkResult)==0)
{
    echo "<script>

    alert('Subject not found.');

    window.location='subjects.php';

    </script>";

    exit();
}

/* ==========================================
   Delete Subject
========================================== */

$deleteQuery = "DELETE FROM subjects WHERE id='$id'";
mysqli_query($conn, $deleteQuery);

header("Location: subjects.php");
exit();
