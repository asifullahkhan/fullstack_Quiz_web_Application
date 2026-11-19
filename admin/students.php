<?php
require_once("admin_auth.php");
require_once(__DIR__ . "/../db.php");

$query = "SELECT * FROM students ORDER BY full_name ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <link rel="stylesheet" href="../assets/CSS/students.css">
</head>
<body>
    <div class="students-page">
        <h2 class="students-page__title">Registered Students</h2>

        <?php if (mysqli_num_rows($result) > 0) : ?>
            <table class="students-page__table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Registration No</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?php echo (int)$row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['reg_no']); ?></td>
                            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="students-page__empty">No registered students found.</div>
        <?php endif; ?>
    </div>
</body>
</html>
