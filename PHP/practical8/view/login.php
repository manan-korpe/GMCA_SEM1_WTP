<?php
    require "../model/util/guest.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="../css/loginAndRegister.css" />
    <link rel="stylesheet" href="../css/toast.css"/>
</head>

<body>
    
    <div class="container">
        <div class="left">
            <form action="../model/login_handler.php" method="POST" id="loginForm">
                <h2>Login</h2>
                <div class="input-form">
                    <div class="input-group">
                        <label for="username">Username or Email</label>
                        <input type="text" id="username" name="username" placeholder="username or email" />
                        <div class="error" id="username-error"></div>
                    </div>

                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="password" />
                        <div class="error" id="password-error"></div>
                    </div>
                </div>
                <button type="submit" class="btn">Login</button>

                <p class="register-text">
                    Don’t have an account? <a href="./register.php">Register</a>
                </p>
            </form>
        </div>

        <div class="right">
            <div class="shape shape-a"></div>
            <div class="shape shape-b"></div>
            <div class="shape shape-c"></div>
            <div class="shape shape-d"></div>
            <div class="shape shape-e"></div>
            <div class="shape shape-f"></div>
        </div>
    </div>

    <?php
        require "../model/util/toast.php";
    ?>
        <script src="../js/login.js"></script>
</body>

</html>