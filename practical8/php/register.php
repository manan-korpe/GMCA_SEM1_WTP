<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get values safely
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    // Server-side validation (ALWAYS required)
    if ($firstname == "" || $lastname == "" || $email == "" || $password == "" || $confirmpassword == "") {
        die("All fields are required.");
    }

    if ($password !== $confirmpassword) {
        die("Passwords do not match.");
    }

    // Check email existence
    $check = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        die("Email already registered.");
    }

    // Hash password
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstname, $lastname, $email, $password);

    if ($stmt->execute()) {
        header("Location: login.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
