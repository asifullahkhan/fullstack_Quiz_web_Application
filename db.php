<?php

class DatabaseConnection
{
    private mysqli $connection;

    public function __construct()
    {
        try {
            $host = "localhost";
            $user = "root";
            $password = "";
            $database = "quiz_system";

            $this->connection = @new mysqli($host, $user, $password, $database);

            if ($this->connection->connect_error) {
                throw new Exception("Database Connection Failed : " . $this->connection->connect_error);
            }

            $this->connection->set_charset("utf8");
        } catch (Exception $exception) {
            error_log($exception->getMessage());
            die($exception->getMessage());
        }
    }

    public function getConnection(): mysqli
    {
        return $this->connection;
    }
}

try {
    $databaseConnection = new DatabaseConnection();
    $conn = $databaseConnection->getConnection();
} catch (Exception $exception) {
    error_log($exception->getMessage());
    die($exception->getMessage());
}

try {
    $conn->query("CREATE TABLE IF NOT EXISTS payments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT NOT NULL,
        subject_id INT NOT NULL,
        amount DECIMAL(10,2) NOT NULL,
        payment_method VARCHAR(50) NOT NULL,
        transaction_id VARCHAR(100) DEFAULT NULL,
        status VARCHAR(20) NOT NULL DEFAULT 'PENDING',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
} catch (Exception $exception) {
    error_log("Payment table setup failed: " . $exception->getMessage());
}
