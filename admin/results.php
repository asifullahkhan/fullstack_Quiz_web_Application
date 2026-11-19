<?php
require_once("admin_auth.php");
require_once(__DIR__ . "/../db.php");

$query = "SELECT r.*, s.full_name, sub.subject_name
          FROM results r
          INNER JOIN students s ON s.id = r.student_id
          INNER JOIN subjects sub ON sub.id = r.subject_id
          ORDER BY r.attempt_date DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f7fb; margin: 0; padding: 24px; }
        .wrap { max-width: 1200px; margin: 0 auto; background: #fff; border-radius: 14px; padding: 24px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        th { background: #eef3ff; }
    </style>
</head>
<body>
    <div class="wrap">
        <h2>Student Quiz Results</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student</th>
                    <th>Subject</th>
                    <th>Marks</th>
                    <th>Percentage</th>
                    <th>Grade</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo (int)$row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['subject_name']); ?></td>
                        <td><?php echo (int)$row['marks']; ?> / <?php echo (int)$row['total_questions']; ?></td>
                        <td><?php echo number_format($row['percentage'], 2); ?>%</td>
                        <td><?php echo htmlspecialchars($row['grade']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['attempt_date']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
