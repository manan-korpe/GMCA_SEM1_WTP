<?php
session_start();
require "util/db.php";

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
    $password = password_hash($password, PASSWORD_DEFAULT);
    // Check email existence
    $check = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $_SESSION["toastMessage"] = "Email already registered!";
        $_SESSION["toastType"] = "error";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstname, $lastname, $email, $password);

    if ($stmt->execute()) {
        $_SESSION["toastMessage"] = "registeration Successful";
        $_SESSION["toastType"] = "success";
        header("Location: ../view/login.php");
        exit;
    } else {
        $_SESSION["toastMessage"] = $stmt->error;
        $_SESSION["toastType"] = "error";
        header("Location: ../view/login.php");
    }
    exit;
}
?>
