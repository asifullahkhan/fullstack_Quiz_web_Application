CREATE DATABASE IF NOT EXISTS quiz_system;
USE quiz_system;

-- ===========================
-- ADMINS
-- ===========================
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO admins(username,password)
VALUES
('Engr.Asfullah','admin123'),
('Engr.Fayaz Shah','admin123');

-- ===========================
-- STUDENTS
-- ===========================
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registration_no VARCHAR(30) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    password VARCHAR(255) NOT NULL,
    department VARCHAR(100),
    semester VARCHAR(30),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO students
(registration_no,full_name,email,password,department,semester)
VALUES
('2023-SE-001',
'Asif Ullah',
'asif@gmail.com',
'123456',
'Software Engineering',
'6th');

-- ===========================
-- SUBJECTS
-- ===========================
CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_name VARCHAR(100) NOT NULL,
    description TEXT,
    total_questions INT DEFAULT 5,
    quiz_time INT DEFAULT 10,
    difficulty ENUM('Easy','Medium','Hard') DEFAULT 'Medium',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO subjects
(subject_name,description,total_questions,quiz_time,difficulty)
VALUES
('PHP','PHP Programming',5,10,'Medium'),
('HTML','HTML Basics',5,10,'Easy'),
('CSS','CSS Styling',5,10,'Easy');

-- ===========================
-- QUESTIONS
-- ===========================
CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_id INT NOT NULL,
    question TEXT NOT NULL,
    option1 VARCHAR(255) NOT NULL,
    option2 VARCHAR(255) NOT NULL,
    option3 VARCHAR(255) NOT NULL,
    option4 VARCHAR(255) NOT NULL,
    correct_answer VARCHAR(255) NOT NULL,
    explanation TEXT,
    marks INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(subject_id)
    REFERENCES subjects(id)
    ON DELETE CASCADE
);

-- ===========================
-- RESULTS
-- ===========================
CREATE TABLE results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    subject_id INT NOT NULL,
    total_questions INT,
    correct_answers INT,
    wrong_answers INT,
    obtained_marks INT,
    percentage DECIMAL(5,2),
    quiz_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(student_id)
    REFERENCES students(id)
    ON DELETE CASCADE,
    FOREIGN KEY(subject_id)
    REFERENCES subjects(id)
    ON DELETE CASCADE
);


INSERT INTO students
(registration_no,full_name,email,password,department,semester)
VALUES
(
'2023-SE-001',
'Asif Ullah',
'asif@gmail.com',
'123456',
'Software Engineering',
'6th'
);