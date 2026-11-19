<?php

include("auth.php");
include("db.php");
include("header.php");

$studentId = $_SESSION['student_id'];

if(isset($_POST['profile_update']))
{

    $studentName = mysqli_real_escape_string($conn,$_POST['full_name']);
    $studentEmail = mysqli_real_escape_string($conn,$_POST['email']);

    $updateQuery = "
    UPDATE students
    SET
        full_name='$studentName',
        email='$studentEmail'
    WHERE id='$studentId'
    ";

    if(mysqli_query($conn,$updateQuery))
    {
        $_SESSION['student_name']=$studentName;
        $successMessage="Profile updated successfully.";
    }
    else
    {
        $errorMessage="Unable to update profile.";
    }

}

$query="SELECT * FROM students WHERE id='$studentId'";

$result=mysqli_query($conn,$query);

$student=mysqli_fetch_assoc($result);

?>

<link rel="stylesheet" href="assets/CSS/profile.css">

<div class="profile-page">

<div class="profile-page__card">

<div class="profile-page__header">

<h2>My Profile</h2>

<p>Update your personal information</p>

</div>

<?php

if(isset($successMessage))
{
?>

<div class="profile-page__success">

<?php echo $successMessage; ?>

</div>

<?php
}

?>

<?php

if(isset($errorMessage))
{
?>

<div class="profile-page__error">

<?php echo $errorMessage; ?>

</div>

<?php
}

?>

<form method="POST">

<div class="profile-page__group">

<label>Student Name</label>

<input
type="text"
name="full_name"
value="<?php echo $student['full_name']; ?>"
required>

</div>

<div class="profile-page__group">

<label>Email Address</label>

<input
type="email"
name="email"
value="<?php echo $student['email']; ?>"
required>

</div>

<div class="profile-page__group">

<label>Registration Number</label>

<input
type="text"
value="<?php echo $student['reg_no']; ?>"
readonly>

</div>

<div class="profile-page__group">

<label>Department</label>

<input
type="text"
value="<?php echo $student['department']; ?>"
readonly>

</div>

<div class="profile-page__group">

<label>Semester</label>

<input
type="text"
value="<?php echo $student['semester']; ?>"
readonly>

</div>

<button
class="profile-page__button"
type="submit"
name="profile_update">

Update Profile

</button>

</form>

</div>

</div>

<?php include("footer.php"); ?>