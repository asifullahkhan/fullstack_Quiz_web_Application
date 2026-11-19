<?php
require_once("admin_auth.php");
require_once(__DIR__ . "/../db.php");

if(!isset($_GET['id']))
{
    header("Location: subjects.php");
    exit();
}

$id = (int)$_GET['id'];

$query = "SELECT * FROM subjects WHERE id='$id'";
$result = mysqli_query($conn,$query);

if(mysqli_num_rows($result)==0)
{
    header("Location: subjects.php");
    exit();
}

$subject = mysqli_fetch_assoc($result);

$message = "";

if(isset($_POST['update_subject']))
{

    $subjectName = mysqli_real_escape_string($conn,$_POST['subject_name']);
    $description = mysqli_real_escape_string($conn,$_POST['description']);

    $updateQuery = "UPDATE subjects SET

    subject_name='$subjectName',
    description='$description'

    WHERE id='$id'";

    if(mysqli_query($conn,$updateQuery))
    {

        $message = "<div class='admin-edit-subject__success'>
        Subject Updated Successfully.
        </div>";

        $query = "SELECT * FROM subjects WHERE id='$id'";
        $result = mysqli_query($conn,$query);
        $subject = mysqli_fetch_assoc($result);

    }
    else
    {

        $message = "<div class='admin-edit-subject__error'>
        Failed to Update Subject.
        </div>";

    }

}

?>

<!DOCTYPE html>

<html>

<head>

<title>Edit Subject</title>

<link rel="stylesheet" href="../assets/CSS/admin-edit-subject.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<div class="admin-edit-subject">

<div class="admin-edit-subject__card">

<h2>

<i class="fa-solid fa-pen-to-square"></i>

Edit Subject

</h2>

<?php echo $message; ?>

<form method="POST">

<div class="admin-edit-subject__group">

<label>Subject Name</label>

<input
type="text"
name="subject_name"
value="<?php echo htmlspecialchars($subject['subject_name']); ?>"
required>

</div>

<div class="admin-edit-subject__group">

<label>Description</label>

<textarea
name="description"
rows="4"
required><?php echo htmlspecialchars($subject['description']); ?></textarea>

</div>


<div class="admin-edit-subject__buttons">

<button
type="submit"
name="update_subject">

Update Subject

</button>

<a href="subjects.php">

Cancel

</a>

</div>

</form>

</div>

</div>

</body>

</html>