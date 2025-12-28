<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link rel="stylesheet" href="css/loginRegister.css" />
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
</head>

<body>
    <div class="container">

        <!-- Left Section / Login Form -->
        <div class="left">
            <form action="{{ route('register.submit') }}" method="POST" id="registerform">
                @csrf
                <h2>Register</h2>
                <div class="input-form">
                    <div class="multi-input-group">

                        <div class="input-group">
                            <label for="firstname">First Name</label>
                            <input type="text" id="firstname" name="firstname" placeholder="first name" />
                            <div class="error" id="firstname-error"></div>
                        </div>
                        <div class="input-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" id="lastname" name="lastname" placeholder="last name" />
                            <div class="error" id="lastname-error"></div>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="email" />
                        <div class="error" id="email-error"></div>
                    </div>

                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="password" />
                        <div class="error" id="password-error"></div>
                    </div>

                    <div class="input-group">
                        <label for="confirmpassword">Confirm Password</label>
                        <input type="password" id="confirmpassword" name="confirmpassword"
                            placeholder="confirm password" />
                        <div class="error" id="confirmpassword-error"></div>
                    </div>
                </div>
                <button type="submit" class="btn">Register</button>
                @if ($errors->any())
                <ul>
                    #foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    #endforeach
                </ul>
                @endif
                <p class="register-text">
                    Alredy have Account? <a href="{{ route('login') }}">Login</a>
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
    
    @if(session('toastMessage'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                showToast("{{ session('toastType') }}", "{{ session('toastMessage') }}");
            });
        </script>
    @endif

    <script src="{{ asset('js/toast.js') }}"></script>
    <script src="js/register.js"></script>
</body>

</html>