<?php
session_start();
require "db.php";
// echo "wokring";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usernameEmail = trim($_POST['username']);
    $password = $_POST['password'];
    echo $password;
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $usernameEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if ($password ==  $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];

            // header("Location: dashboard.php");
            // exit;
            echo "loging success";
        } else {
            echo "Wrong password!";
        }
    } else {
        echo "User not found!";
    }
}
?>
