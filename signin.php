<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "pharmacy_inventory"
);

if (!$conn) {
    die("Database connection failed");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check username already exists
    $check = mysqli_query(
        $conn,
        "SELECT * FROM users WHERE username='$username'"
    );

    if (mysqli_num_rows($check) > 0) {

        echo "<script>
            alert('Username already exists. Please choose another username.');
        </script>";

    } else {

        // New accounts are always normal users
        $sql = "INSERT INTO users
                (fullname, email, username, password, role)
                VALUES
                ('$fullname', '$email', '$username', '$password', 'user')";

        if (mysqli_query($conn, $sql)) {

            echo "<script>
                alert('Account created successfully! Please login.');
                window.location.href='login.php';
            </script>";

            exit();

        } else {

            echo "<script>
                alert('Account creation failed.');
            </script>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>PharmaHub - Sign in</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #eefafa, #f8ffff);
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            color: #173b59;
        }

        /* Decorative background */
        body::before {
            content: "";
            position: absolute;
            width: 500px;
            height: 500px;
            left: -180px;
            bottom: -180px;
            background: #d9f3f3;
            border-radius: 50%;
            opacity: 0.8;
        }

        body::after {
            content: "";
            position: absolute;
            width: 420px;
            height: 420px;
            right: -160px;
            top: -160px;
            background: #dff7f6;
            border-radius: 50%;
            opacity: 0.8;
        }

        /* Left text */
        .left-text {
            position: absolute;
            left: 7%;
            top: 24%;
            color: #169ba0;
            z-index: 1;
        }

        .left-text h1 {
            font-size: 32px;
            font-style: italic;
            line-height: 1.2;
        }

        .left-text p {
            margin-top: 10px;
            color: #54758a;
            font-size: 16px;
        }

        /* Right text */
        .right-text {
            position: absolute;
            right: 6%;
            top: 22%;
            text-align: center;
            color: #169ba0;
            z-index: 1;
        }

        .right-text h1 {
            font-size: 30px;
            font-style: italic;
            line-height: 1.25;
        }

        .icons {
            margin-top: 25px;
            font-size: 38px;
            letter-spacing: 15px;
        }

        /* Main box */
        .box {
            width: 500px;
            background: rgba(255, 255, 255, 0.96);
            padding: 42px 52px;
            border-radius: 22px;
            box-shadow: 0 15px 45px rgba(30, 90, 110, 0.15);
            text-align: center;
            position: relative;
            z-index: 5;
        }

        /* Logo */
        .logo {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 14px;
            margin-bottom: 10px;
        }

        .logo-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #009da2, #00b5b0);
            color: white;
            border-radius: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 38px;
            font-weight: bold;
        }

        .logo-name {
            font-size: 34px;
            font-weight: bold;
            color: #153b59;
        }

        .logo-name span {
            color: #00a6a6;
        }

        .tagline {
            color: #637c8d;
            font-size: 17px;
            margin-bottom: 30px;
        }

        /* Heading */
        h2 {
            color: #153b59;
            font-size: 32px;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #71899a;
            font-size: 16px;
            margin-bottom: 25px;
        }

        /* Input group */
        .input-group {
            position: relative;
            margin: 15px 0;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 19px;
            color: #607d91;
        }

        input {
            width: 100%;
            height: 55px;
            padding: 0 18px 0 52px;
            border: 1px solid #cbdde5;
            border-radius: 11px;
            outline: none;
            font-size: 16px;
            color: #173b59;
            background: #fbfdfe;
            transition: 0.3s;
        }

        input:focus {
            border-color: #00a6a6;
            box-shadow: 0 0 0 3px rgba(0, 166, 166, 0.10);
            background: white;
        }

        input::placeholder {
            color: #91a3ae;
        }

        /* Password icon */
        .password-icon {
            position: absolute;
            right: 17px;
            top: 50%;
            transform: translateY(-50%);
            color: #607d91;
            cursor: pointer;
            font-size: 18px;
        }

        /* Button */
        button {
            width: 100%;
            height: 55px;
            margin-top: 10px;
            border: none;
            border-radius: 11px;
            background: linear-gradient(135deg, #009da2, #00b1ac);
            color: white;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(0, 157, 162, 0.25);
        }

        /* Login link */
        .login-text {
            margin-top: 25px;
            color: #71899a;
            font-size: 15px;
        }

        .login-text a {
            color: #009da2;
            font-weight: bold;
            text-decoration: none;
        }

        .login-text a:hover {
            text-decoration: underline;
        }

        /* Mobile */
        @media (max-width: 900px) {

            .left-text,
            .right-text {
                display: none;
            }

            .box {
                width: 90%;
                max-width: 500px;
                padding: 35px 28px;
            }
        }

        @media (max-width: 500px) {

            body {
                padding: 15px;
            }

            .box {
                width: 100%;
                padding: 30px 22px;
            }

            .logo-name {
                font-size: 28px;
            }

            .logo-icon {
                width: 52px;
                height: 52px;
                font-size: 32px;
            }

            h2 {
                font-size: 27px;
            }
        }
    </style>
</head>

<body>

<!-- Left Side -->
<div class="left-text">
    <h1>Better Health<br>Brighter Tomorrow</h1>
    <p>Smart solutions for your pharmacy</p>
</div>

<!-- Right Side -->
<div class="right-text">
    <h1>Your Health<br>Our Priority</h1>

    <div class="icons">
        💊 💉
    </div>
</div>


<!-- Sign In Box -->
<div class="box">

    <div class="logo">
        <div class="logo-icon">+</div>

        <div class="logo-name">
            Pharma<span>Hub</span>
        </div>
    </div>

    <div class="tagline">
        Smart Pharmacy
    </div>

    <h2>Sign in</h2>

    <p class="subtitle">
        Access your pharmacy account
    </p>


    <form action="signin.php" method="post">

    <!-- Full Name -->
    <div class="input-group">
        <span class="input-icon">👤</span>

        <input
            type="text"
            name="fullname"
            placeholder="Full Name"
            required
        >
    </div>

    <!-- Email -->
    <div class="input-group">
        <span class="input-icon">✉</span>

        <input
            type="email"
            name="email"
            placeholder="Email"
            required
        >
    </div>

    <!-- Username -->
    <div class="input-group">
        <span class="input-icon">👤</span>

        <input
            type="text"
            name="username"
            placeholder="Username"
            required
        >
    </div>

    <!-- Password -->
    <div class="input-group">
        <span class="input-icon">🔒</span>

        <input
            type="password"
            name="password"
            id="password"
            placeholder="Password"
            required
        >

        <span class="password-icon" onclick="togglePassword()">👁</span>
    </div>

    <!-- Create Account -->
    <button type="submit">
        Create Account
    </button>

</form>


    <div class="login-text">
        Already have an account?
        <a href="login.php">Login</a>
    </div>

</div>


<script>

function togglePassword() {

    var password = document.getElementById("password");

    if (password.type === "password") {
        password.type = "text";
    } else {
        password.type = "password";
    }

}

</script>

</body>
</html>