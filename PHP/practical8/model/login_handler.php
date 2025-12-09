<?php
session_start();
require "./util/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usernameEmail = trim($_POST['username']);
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $usernameEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];

            header("Location: ../../practical1/index.php");
            exit;
        } else {
            $_SESSION["toastMessage"] = "Wrong password!";
            $_SESSION["toastType"] = "error";
        }
    } else {
        $_SESSION["toastMessage"] = "User not found!";
        $_SESSION["toastType"] = "error";
    }
    header("Location: ../view/login.php");
    exit;
}
?>
