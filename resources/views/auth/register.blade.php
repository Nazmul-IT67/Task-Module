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
                <span>Sign Up</span>
            </div>
            <form action="{{ route('register')}}" method="POST">
                @csrf
                <div class="input_box">
                    <input type="name" id="name" name="name" class="input-field" required>
                    <label for="name" class="label">Name</label>
                    <i class="bx bx-user icon"></i>
                </div>

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

                <div class="input_box">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="input-field" required>
                    <label for="pass" class="label">Confirm Password</label>
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
                    <input type="submit" class="input-submit" value="Register">
                </div>
            </form>

            <div class="login">
                <span>I have an account? <a href="{{ route('login')}}">Login</a></span>
            </div>
        </div>
    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>
