<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Modern Login Form | CodingStella </title>
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Poppins&amp;display=swap'>
    <link rel="stylesheet" href="{{ asset('backend/css/from/style.css') }}">
</head>

<body>
    <!-- partial:index.partial.html -->
    <div class="wrapper">
        <div class="login_box">
            <div class="login-header">
                <span>Sign In</span>
            </div>
            <form action="{{ route('login')}}" method="POST">
                @csrf
                <div class="input_box">
                    <input type="email" id="email" name="email" class="input-field" required>
                    <label for="email" class="label">Email</label>
                    <i class="bx bx-user icon"></i>
                </div>

                <div class="input_box">
                    <input type="password" name="password" id="password" class="input-field" required>
                    <label for="pass" class="label">Password</label>
                    <i class="bx bx-lock-alt icon"></i>
                </div>

                <div class="remember-forgot">
                    <div class="remember-me">
                        <input type="checkbox" id="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    <div class="forgot">
                        <a href="#">Forgot password?</a>
                    </div>
                </div>

                <div class="input_box">
                    <input type="submit" class="input-submit" value="Login">
                </div>
            </form>

            <div class="register">
                <span>Don't have an account? <a href="{{ route('register')}}">Register</a></span>
            </div>
            <div>
                <h4>Demo Access</h4>
                <p><b>Email:</b> nazmul.cse67@gmail.com</p>
                <p><b>Password:</b> admin@123</p>
            </div>
        </div>
        <div class="access-user text-center" style="margin-top:20px;">
        </div>

    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include AJAX File -->
    <script src="{{ asset('backend/js/ajax.js') }}"></script>

</body>

</html>