<?php
session_start();

// DB connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "elms_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// ======================
//  REGISTER NEW ACCOUNT
// ======================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, remaining_leave) VALUES (?, ?, ?, ?, 35)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    if ($stmt->execute()) {
        $new_user_id = $conn->insert_id;

        // Assign default leave credits automatically
        $current_year = date("Y");
        $credit_stmt = $conn->prepare("
            INSERT INTO leave_credits (user_id, year, annual_leave, sick_leave, calamity_leave, used_annual, used_sick, used_calamity)
            VALUES (?, ?, 15, 15, 5, 0, 0, 0)
        ");
        $credit_stmt->bind_param("is", $new_user_id, $current_year);
        $credit_stmt->execute();
        $credit_stmt->close();

        $success_msg = "Registration successful! Default leave credits assigned. You can now log in.";
    } else {
        $error_msg = "Error: " . $stmt->error;
    }

    $stmt->close();
}

// ======================
//  LOGIN EXISTING ACCOUNT
// ======================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email=? AND role=?");
    $stmt->bind_param("ss", $email, $role);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $hashed_password, $user_role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['name'] = $name;
            $_SESSION['role'] = $user_role;

            // Redirect by role
            if ($user_role === 'employee') {
                header("Location: index.php");
            } elseif ($user_role === 'hr') {
                header("Location: hr_dashboard.php");
            } elseif ($user_role === 'dept_head') {
                header("Location: dept_dashboard.php");
            } elseif ($user_role === 'gen_manager') {
                header("Location: gm_dashboard.php");
            }
            exit();
        } else {
            $error_msg = "Invalid password.";
        }
    } else {
        $error_msg = "No account found for this role.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Employee Leave Management System</title>
    <link rel="stylesheet" href="style2.css">
    <style>
        select { color: gray; }
        select:focus, select:not(:invalid) { color: black; }
        option[value=""][disabled][selected] { display: none; }
        .message { color: green; text-align: center; }
        .error { color: red; text-align: center; }
    </style>
</head>
<body>
<div class="container" id="container">

    <!-- SIGN UP FORM -->
    <div class="form-container sign-up-container">
        <form method="POST" action="">
            <h2>Create Account</h2>
            <?php if (!empty($success_msg)) echo "<p class='message'>$success_msg</p>"; ?>
            <?php if (!empty($error_msg)) echo "<p class='error'>$error_msg</p>"; ?>
            <input type="text" name="name" placeholder="Full Name" required />
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <select name="role" required>
                <option value="" disabled selected>Select Role</option>
                <option value="employee">Employee</option>
                <option value="hr">HR</option>
                <option value="dept_head">Department Head</option>
                <option value="gen_manager">General Manager</option>
            </select>
            <button class="filled" type="submit" name="register">SIGN UP</button>
        </form>
    </div>

    <!-- SIGN IN FORM -->
    <div class="form-container sign-in-container">
        <form method="POST" action="">
            <h2>Sign In</h2>
            <?php if (!empty($error_msg)) echo "<p class='error'>$error_msg</p>"; ?>
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <select name="role" required>
                <option value="" disabled selected>Login As</option>
                <option value="employee">Employee</option>
                <option value="hr">HR</option>
                <option value="dept_head">Department Head</option>
                <option value="gen_manager">General Manager</option>
            </select>
            <a href="#">Forgot your password?</a>
            <button class="filled" type="submit" name="login">SIGN IN</button>
        </form>
    </div>

    <!-- OVERLAY -->
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h2>Welcome Back!</h2>
                <p>Login with your credentials to continue.</p>
                <button class="ghost" id="signIn">SIGN IN</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h2>Hello, Friend!</h2>
                <p>Enter your details and start your journey with us.</p>
                <button class="ghost" id="signUp">SIGN UP</button>
            </div>
        </div>
    </div>
</div>
<script src="scriptreg.js"></script>
</body>
</html>
