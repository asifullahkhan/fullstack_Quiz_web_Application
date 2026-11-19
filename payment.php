<?php
session_start();
require_once("auth.php");
require_once("db.php");
require_once("classes/QuizService.php");
include("header.php");

$studentId = (int)($_SESSION['student_id'] ?? 0);
$subjectId = (int)($_GET['subject_id'] ?? $_SESSION['pending_payment_subject_id'] ?? 0);
$paymentMessage = "";
$quizService = new QuizService($conn);

try {
    if ($studentId <= 0 || $subjectId <= 0) {
        throw new Exception("Invalid payment request.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_now'])) {
        $method = trim($_POST['payment_method'] ?? 'Easypaisa');
        $transactionId = trim($_POST['transaction_id'] ?? '');

        if ($transactionId === '') {
            throw new Exception("Please enter a valid transaction reference.");
        }

        if ($quizService->savePayment($studentId, $subjectId, $method, $transactionId)) {
            $_SESSION['pending_payment_subject_id'] = null;
            $paymentMessage = "<div class='payment-box__success'>Payment successful. You can now attempt the quiz again.</div>";
        } else {
            throw new Exception("Payment could not be processed.");
        }
    }
} catch (Exception $exception) {
    error_log("Payment page error: " . $exception->getMessage());
    $paymentMessage = "<div class='payment-box__error'>" . htmlspecialchars($exception->getMessage()) . "</div>";
}
?>

<link rel="stylesheet" href="assets/CSS/payment.css">

<div class="payment-page">
    <div class="payment-box">
        <h2>Extra Quiz Attempt Payment</h2>
        <p>After 5 attempts, each extra quiz attempt requires a payment of PKR 1000.</p>
        <p><strong>Easypaisa Account:</strong> 03365474606</p>

        <?php echo $paymentMessage; ?>

        <form method="POST">
            <div class="payment-box__group">
                <label>Payment Method</label>
                <input type="text" value="Easypaisa" readonly>
            </div>

            <div class="payment-box__group">
                <label>Transaction Reference</label>
                <input type="text" name="transaction_id" placeholder="Enter transaction reference" required>
            </div>

            <button type="submit" name="pay_now">Confirm Payment</button>
        </form>
    </div>
</div>

<?php include("footer.php"); ?>