<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="css/loginRegister.css" />
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
</head>

<body>
    
    <div class="container">
        <div class="left">
            <form action="{{ route('login.submit') }}" method="POST" id="loginForm">
                @csrf
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
                    Don’t have an account? <a href="{{ route('register') }}">Register</a>
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
    <div class="toast-container" id="toastContainer"></div>
    @if(session()->has('toastMessage'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
               showToast("{{ session('toastType') }}", "{{ session('toastMessage') }}");
            });
        </script>
    @endif


    <script src="js/toast.js"></script>
    <script src="js/login.js"></script>
</body>

</html>