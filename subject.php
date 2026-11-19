<?php

try {
    include("auth.php");
    include("db.php");
    include("header.php");

    $studentId = $_SESSION['student_id'] ?? 0;
    $paymentMessage = "";

    if (isset($_GET['payment_required'])) {
        $paymentMessage = "<div class='subject-page__notice'>You have reached the 5-attempt limit for this subject. Please complete the Easypaisa payment to continue.</div>";
    }
} catch (Exception $exception) {
    error_log("Subject page error: " . $exception->getMessage());
    $paymentMessage = "<div class='subject-page__notice'>Unable to load subject list right now.</div>";
}

?>

<link rel="stylesheet" href="assets/CSS/subject.css">

<div class="subject-page">

    <?php echo $paymentMessage; ?>

    <div class="subject-page__header">

        <h2>Select Quiz Subject</h2>

        <p>Select one subject to start your quiz.</p>

    </div>

    <div class="subject-page__grid">

<?php

$sql = "SELECT * FROM subjects ORDER BY subject_name ASC";

$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($result))
{

?>

<div class="subject-card">

    <div class="subject-card__icon">

        <i class="fa-solid fa-book-open"></i>

    </div>

    <div class="subject-card__body">

        <h3>

            <?php echo $row['subject_name']; ?>

        </h3>

        <p>

            <?php echo $row['description']; ?>

        </p>

<?php

$countQuery = "SELECT COUNT(*) AS total
FROM questions
WHERE subject_id=".$row['id'];

$countResult = mysqli_query($conn,$countQuery);

$count = mysqli_fetch_assoc($countResult);

?>

        <ul class="subject-card__details">

            <li>

                <i class="fa-solid fa-circle-question"></i>

                <?php echo $count['total']; ?> Questions

            </li>

            <li>

                <i class="fa-solid fa-clock"></i>

                20 Minutes

            </li>

            <li>

                <i class="fa-solid fa-layer-group"></i>

                Medium

            </li>

        </ul>

        <form action="start_quiz.php" method="POST" class="subject-card__form">

            <input
            type="hidden"
            name="subject_id"
            value="<?php echo $row['id']; ?>">

            <input
            type="hidden"
            name="subject_name"
            value="<?php echo $row['subject_name']; ?>">

            <button
            class="subject-card__button"
            type="submit">

                Start Quiz

            </button>

        </form>

    </div>

</div>

<?php

}

?>

    </div>

</div>

<?php include("footer.php"); ?>