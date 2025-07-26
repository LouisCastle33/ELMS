<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Sliding Auth</title>
    <link rel="stylesheet" href="style2.css">
    <style>
        /* Make placeholder text gray */
        select {
            color: gray;
        }
        /* When user selects a valid option, text becomes black */
        select:focus, select:not(:invalid) {
            color: black;
        }
        /* Hide the placeholder option from dropdown list */
        option[value=""][disabled][selected] {
            display: none;
        }
    </style>
</head>
<body>
<div class="container" id="container">
    <!-- SIGN UP FORM -->
    <div class="form-container sign-up-container">
        <form action="process_register.php" method="POST">
            <h2>Create Account</h2>
            <input type="text" name="name" placeholder="Full Name" required />
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />

            <!-- Role dropdown -->
            <select name="role" required>
                <option value="" disabled selected>Select Role</option>
                <option value="employee">Employee</option>
                <option value="hr">HR</option>
                <option value="dept_head">Department Head</option>
                <option value="gm">General Manager</option>
            </select>

            <button class="filled" type="submit">SIGN UP</button>
        </form>
    </div>

    <!-- SIGN IN FORM -->
    <div class="form-container sign-in-container">
        <form action="process_login.php" method="POST">
            <h2>Sign in</h2>
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />

            <!-- Role dropdown -->
            <select name="role" required>
                <option value="" disabled selected>Login As</option>
                <option value="employee">Employee</option>
                <option value="hr">HR</option>
                <option value="dept_head">Department Head</option>
                <option value="gm">General Manager</option>
            </select>

            <a href="#">Forgot your password?</a>
            <button class="filled" type="submit">SIGN IN</button>
        </form>
    </div>

    <!-- OVERLAY -->
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h2>Welcome Back!</h2>
                <p>To keep connected with us please login with your personal info</p>
                <button class="ghost" id="signIn">SIGN IN</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h2>Hello, Friend!</h2>
                <p>Enter your personal details and start your journey with us</p>
                <button class="ghost" id="signUp">SIGN UP</button>
            </div>
        </div>
    </div>
</div>
<script src="scriptreg.js"></script>
</body>
</html>
