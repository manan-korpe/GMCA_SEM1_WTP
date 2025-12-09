<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../practical8/view/login.php");
    exit();
}
?>
