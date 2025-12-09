<?php
session_start();
    if(isset($_SESSION['user_id']) && isset($_SESSION['email'])){
        echo json_encode(["loggedIn"=>true]);
        exit;
    }
    echo json_encode(["loggedIn"=>false]);
    exit;
?>