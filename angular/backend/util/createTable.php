<?php
require "db.php";
// -------- USERS TABLE --------
$users_table = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(100),
    lastname VARCHAR(100),
    email VARCHAR(150) UNIQUE,
    password VARCHAR(255)
);
";

// -------- JOB APPLICATION TABLE --------
$job_table = "
CREATE TABLE IF NOT EXISTS job_application (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,

    fname VARCHAR(150),
    lname VARCHAR(150),
    dob DATE,
    gender VARCHAR(20),
    marital VARCHAR(20),
    nationality VARCHAR(100),
    mobile VARCHAR(20),
    email VARCHAR(150),
    address TEXT,
    pincode VARCHAR(20),

    qualification VARCHAR(150),
    fieldofstudy VARCHAR(150),
    universityinstitutionname VARCHAR(255),

    experience VARCHAR(150),
    experienceyear VARCHAR(10),
    previousjob VARCHAR(150),
    company VARCHAR(150),
    previoussalary VARCHAR(50),
    skills TEXT,

    jobposition VARCHAR(150),
    joblocation VARCHAR(150),
    startdate DATE,
    jobexpectedsalary VARCHAR(50),

    resume VARCHAR(255),
    photo VARCHAR(255),

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;
";

// Execute queries
if ($conn->query($users_table) === TRUE) {
    echo "Users table created successfully.<br>";
} else {
    echo "Error creating users table: " . $conn->error . "<br>";
}

if ($conn->query($job_table) === TRUE) {
    echo "Job Application table created successfully.<br>";
} else {
    echo "Error creating job_application table: " . $conn->error . "<br>";
}

$conn->close();
?>
