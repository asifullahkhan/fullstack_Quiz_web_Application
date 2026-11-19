
<?php
require_once("admin_auth.php");
require_once(__DIR__ . "/../db.php");

$message = "";

if (isset($_GET['deleted'])) {
    $message = "<div class='admin-subjects__success'>Subject deleted successfully.</div>";
}

$query = "SELECT s.*, COUNT(q.id) AS total_questions
          FROM subjects s
          LEFT JOIN questions q ON q.subject_id = s.id
          GROUP BY s.id
          ORDER BY s.subject_name ASC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Subjects</title>
    <link rel="stylesheet" href="../assets/CSS/admin-subjects.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>

<div class="admin-subjects-page">
    <div class="admin-subjects-page__header">
        <h2><i class="fa-solid fa-book"></i> Manage Subjects</h2>
        <a href="add_subject.php" class="admin-subjects-page__button">Add Subject</a>
    </div>

    <?php echo $message; ?>

    <div class="admin-subjects-page__grid">
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="admin-subject-card">
                <div class="admin-subject-card__top">
                    <h3><?php echo htmlspecialchars($row['subject_name']); ?></h3>
                    <span><?php echo (int)$row['total_questions']; ?> Questions</span>
                </div>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <div class="admin-subject-card__actions">
                    <a href="edit_subject.php?id=<?php echo (int)$row['id']; ?>">Edit</a>
                    <a href="delete_subject.php?id=<?php echo (int)$row['id']; ?>" onclick="return confirm('Delete this subject?')">Delete</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>