<?php
session_start();

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<link rel="stylesheet" href="../assets/CSS/admin-login.css">
</head>
<body>

<div class="admin-login-page">
    <div class="admin-login-card">
        <h1>Admin Login</h1>
        <p>Online Quiz Management System</p>

        <form action="authenticate.php" method="POST">
            <div class="admin-login-group">
                <label>Username</label>
                <input type="text" name="admin_username" placeholder="Enter Admin Username" required>
            </div>

            <div class="admin-login-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter Password" required>
            </div>

            <button type="submit" class="admin-login-button">Login</button>
        </form>
    </div>
</div>

</body>
</html>
