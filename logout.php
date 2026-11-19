<?php
session_start();

try {
    session_unset();
    session_destroy();

    header("Location: login.php");
    exit();
} catch (Exception $exception) {
    error_log("Logout failed: " . $exception->getMessage());
    header("Location: login.php");
    exit();
}
