<?php

include("auth.php");
include("db.php");
include("header.php");

$subjectId=$_SESSION['subject_id'];
$subjectName=$_SESSION['subject_name'];

$sql="SELECT COUNT(*) AS total
FROM questions
WHERE subject_id='$subjectId'";

$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

$totalQuestions=$row['total'];

?>

<link rel="stylesheet" href="assets/CSS/instructions.css">

<div class="instructions-page">

<div class="instructions-card">

<div class="instructions-card__header">

<h2>

<?php echo $subjectName; ?> Quiz

</h2>

<p>

Please read all instructions carefully before starting.

</p>

</div>

<div class="instructions-info">

<div class="instructions-info__item">

<strong>Student</strong>

<span><?php echo $_SESSION['student_name']; ?></span>

</div>

<div class="instructions-info__item">

<strong>Subject</strong>

<span><?php echo $subjectName; ?></span>

</div>

<div class="instructions-info__item">

<strong>Total Questions</strong>

<span><?php echo $totalQuestions; ?></span>

</div>

<div class="instructions-info__item">

<strong>Time</strong>

<span>20 Minutes</span>

</div>

<div class="instructions-info__item">

<strong>Passing Marks</strong>

<span>50%</span>

</div>

</div>

<hr>

<div class="instructions-rules">

<h3>Quiz Rules</h3>

<ul>

<li>Read every question carefully.</li>

<li>Each question carries 1 mark.</li>

<li>No negative marking.</li>

<li>Do not refresh the browser.</li>

<li>Complete the quiz within the time limit.</li>

<li>Click Submit only after completing the quiz.</li>

</ul>

</div>

<form action="quiz.php" method="POST">

<div class="instructions-checkbox">

<label>

<input
type="checkbox"
required>

I have read and understood all instructions.

</label>

</div>

<button
class="instructions-start-btn"
type="submit">

Start Quiz

</button>

</form>

</div>

</div>

<?php include("footer.php"); ?>