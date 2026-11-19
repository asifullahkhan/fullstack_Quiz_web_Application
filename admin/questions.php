<?php
require_once("admin_auth.php");
require_once(__DIR__ . "/../db.php");

$message = "";

if (isset($_GET['deleted'])) {
    $message = "<div class='success'>Question deleted successfully.</div>";
}

$query = "SELECT q.*, s.subject_name
          FROM questions q
          INNER JOIN subjects s ON s.id = q.subject_id
          ORDER BY s.subject_name ASC, q.id ASC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Questions</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f7fb; margin: 0; padding: 24px; }
        .wrap { max-width: 1100px; margin: 0 auto; background: #fff; border-radius: 14px; padding: 24px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        .top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn { display: inline-block; background: #0d6efd; color: #fff; text-decoration: none; padding: 10px 16px; border-radius: 8px; }
        .success { background: #d1f5df; color: #0a5d2c; padding: 12px; border-radius: 8px; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border-bottom: 1px solid #e5e7eb; text-align: left; vertical-align: top; }
        th { background: #eef3ff; }
        .actions a { color: #0d6efd; text-decoration: none; margin-right: 10px; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="top">
            <h2>Manage Questions</h2>
            <a href="add_question.php" class="btn">Add Question</a>
        </div>

        <?php echo $message; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Subject</th>
                    <th>Question</th>
                    <th>Correct Answer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo (int)$row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['subject_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['question']); ?></td>
                        <td><?php echo htmlspecialchars($row['correct_answer']); ?></td>
                        <td class="actions">
                            <a href="delete_question.php?id=<?php echo (int)$row['id']; ?>" onclick="return confirm('Delete this question?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
