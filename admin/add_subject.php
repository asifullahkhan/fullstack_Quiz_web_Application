<?php

require_once("admin_auth.php");
require_once(__DIR__ . "/../db.php");

$message = "";

if(isset($_POST['save_subject']))
{

    $subjectName = mysqli_real_escape_string($conn,$_POST['subject_name']);
    $description = mysqli_real_escape_string($conn,$_POST['description']);

    $query = "INSERT INTO subjects
    (
        subject_name,
        description
    )
    VALUES
    (
        '$subjectName',
        '$description'
    )";

    if(mysqli_query($conn,$query))
    {
        $message = "<div class='admin-add-subject__success'>
                        Subject Added Successfully.
                    </div>";
    }
    else
    {
        $message = "<div class='admin-add-subject__error'>
                        Failed to Add Subject.
                    </div>";
    }

}

?>

<!DOCTYPE html>
<html>

<head>

<title>Add Subject</title>

<link rel="stylesheet" href="../assets/CSS/admin-add-subject.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<div class="admin-add-subject">

<div class="admin-add-subject__card">

<h2>

<i class="fa-solid fa-book"></i>

Add New Subject

</h2>

<?php echo $message; ?>

<form method="POST">

<div class="admin-add-subject__group">

<label>Subject Name</label>

<input
type="text"
name="subject_name"
required>

</div>

<div class="admin-add-subject__group">

<label>Description</label>

<textarea
name="description"
rows="4"
required></textarea>

</div>


<div class="admin-add-subject__buttons">

<button
type="submit"
name="save_subject">

Save Subject

</button>

<a href="subjects.php">

Back

</a>

</div>

</form>

</div>

</div>

</body>

</html>