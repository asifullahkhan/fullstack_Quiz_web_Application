<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Quiz Management System</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #eaf2ff, #f8fbff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-choice {
            width: min(680px, 90%);
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 12px 35px rgba(0,0,0,0.12);
            padding: 36px;
            text-align: center;
        }
        .login-choice h1 {
            margin-bottom: 10px;
            color: #0d6efd;
        }
        .login-choice p {
            margin-bottom: 28px;
            color: #495057;
        }
        .login-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .login-buttons a {
            text-decoration: none;
            padding: 14px 24px;
            border-radius: 10px;
            color: #fff;
            font-weight: 600;
            background: #0d6efd;
            transition: 0.2s ease;
        }
        .login-buttons a:hover {
            opacity: 0.92;
        }
        .login-buttons .admin-btn {
            background: #198754;
        }
    </style>
</head>
<body>
    <div class="login-choice">
        <h1>Online Quiz Management System</h1>
        <p>Select your login role to continue.</p>

        <div class="login-buttons">
            <a href="admin/login.php">Student Login</a>
            <a href="admin/admin_login.php" class="admin-btn">Admin Login</a>
            <a href="register.php">Register New Student</a>
        </div>
    </div>
</body>
</html>
