<?php

class QuizService
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function getAttemptCount(int $studentId, int $subjectId): int
    {
        $query = "SELECT COUNT(*) AS total FROM results WHERE student_id = ? AND subject_id = ?";
        $statement = $this->conn->prepare($query);
        $statement->bind_param("ii", $studentId, $subjectId);
        $statement->execute();
        $result = $statement->get_result();
        $row = $result->fetch_assoc();

        return (int)($row['total'] ?? 0);
    }

    public function hasPaidForExtraAttempts(int $studentId, int $subjectId): bool
    {
        $query = "SELECT id FROM payments WHERE student_id = ? AND subject_id = ? AND status = 'PAID' LIMIT 1";
        $statement = $this->conn->prepare($query);
        $statement->bind_param("ii", $studentId, $subjectId);
        $statement->execute();
        $result = $statement->get_result();

        return $result->num_rows > 0;
    }

    public function savePayment(int $studentId, int $subjectId, string $method, string $transactionId): bool
    {
        $query = "INSERT INTO payments (student_id, subject_id, amount, payment_method, transaction_id, status)
                  VALUES (?, ?, 1000.00, ?, ?, 'PAID')";
        $statement = $this->conn->prepare($query);
        $statement->bind_param("iiss", $studentId, $subjectId, $method, $transactionId);

        return $statement->execute();
    }

    public function sendEmail(string $emailAddress, string $subject, string $message): bool
    {
        if ($emailAddress === '') {
            return false;
        }

        $headers = "From: no-reply@quizsystem.local\r\n";
        $headers .= "Reply-To: no-reply@quizsystem.local\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        return @mail($emailAddress, $subject, $message, $headers);
    }
}
