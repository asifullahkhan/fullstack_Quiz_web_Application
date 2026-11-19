<?php
require_once("admin_auth.php");
require_once(__DIR__ . "/../db.php");

if (!isset($_GET['id'])) {
    header("Location: questions.php");
    exit();
}

$id = (int)$_GET['id'];
mysqli_query($conn, "DELETE FROM questions WHERE id='$id'");
header("Location: questions.php?deleted=1");
exit();
