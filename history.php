<?php

include("auth.php");
include("db.php");
include("header.php");

$studentId = $_SESSION['student_id'];

$query = "
SELECT
    results.*,
    subjects.subject_name
FROM results
INNER JOIN subjects
ON results.subject_id = subjects.id
WHERE results.student_id = '$studentId'
ORDER BY results.attempt_date DESC
";

$result = mysqli_query($conn,$query);

?>

<link rel="stylesheet" href="assets/CSS/history.css">

<div class="history-page">

    <div class="history-page__header">

        <h2>Quiz History</h2>

        <p>Your previous quiz attempts</p>

    </div>

    <div class="history-page__table-wrapper">

        <table class="history-page__table">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Subject</th>

                    <th>Marks</th>

                    <th>Percentage</th>

                    <th>Grade</th>

                    <th>Status</th>

                    <th>Date</th>

                </tr>

            </thead>

            <tbody>

<?php

$sr = 1;

if(mysqli_num_rows($result)>0)
{

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?php echo $sr++; ?></td>

<td><?php echo $row['subject_name']; ?></td>

<td>

<?php

echo $row['marks'];

echo " / ";

echo $row['total_questions'];

?>

</td>

<td>

<?php echo $row['percentage']; ?>%

</td>

<td>

<?php echo $row['grade']; ?>

</td>

<td>

<?php

if($row['status']=="PASS")
{

?>

<span class="history-page__status--pass">

PASS

</span>

<?php

}
else
{

?>

<span class="history-page__status--fail">

FAIL

</span>

<?php

}

?>

</td>

<td>

<?php

echo date("d M Y",
strtotime($row['attempt_date']));

?>

</td>

</tr>

<?php

}

}
else
{

?>

<tr>

<td colspan="7">

No quiz attempts found.

</td>

</tr>

<?php

}

?>

            </tbody>

        </table>

    </div>

</div>

<?php include("footer.php"); ?>