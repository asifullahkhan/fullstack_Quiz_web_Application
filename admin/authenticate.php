<?php
session_start();

require_once(__DIR__ . "/../db.php");

/* ==========================================
   Check Request Method
========================================== */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit();
}

/* ==========================================
   Get Form Data
========================================== */

$adminUsername = trim($_POST['admin_username'] ?? '');
$password      = trim($_POST['password'] ?? '');

/* ==========================================
   Validate Input
========================================== */

if (empty($adminUsername) || empty($password)) {

    echo "<script>
            alert('Please fill in all fields.');
            window.location='admin_login.php';
          </script>";
    exit();
}

/* ==========================================
   Prepared Statement
========================================== */

$sql = "SELECT * FROM admins WHERE username = ? LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Database Error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $adminUsername);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

/* ==========================================
   Check Admin
========================================== */

if (mysqli_num_rows($result) == 1) {

    $admin = mysqli_fetch_assoc($result);

    /*
    ------------------------------------------------
    If using plain text passwords
    ------------------------------------------------
    */

    if ($password === $admin['password']) {

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_name'] = $admin['username'];

        header("Location: dashboard.php");
        exit();

    }

    /*
    ------------------------------------------------
    If using password_hash()
    Uncomment this and remove the above block.
    ------------------------------------------------

    if (password_verify($password, $admin['password'])) {

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['admin_name'];
        $_SESSION['admin_email'] = $admin['admin_email'];

        header("Location: dashboard.php");
        exit();

    }

    */

    echo "<script>
            alert('Incorrect Password');
            window.location='admin_login.php';
          </script>";
    exit();

} else {

    echo "<script>
            alert('Admin account not found.');
            window.location='admin_login.php';
          </script>";
    exit();

}
?>