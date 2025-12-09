<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: ../../practical1/index.html');
    exit();
}
?>
