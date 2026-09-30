<?php

session_start();

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

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql = "SELECT * FROM users
            WHERE username = '$username'
            AND password = '$password'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        $_SESSION['username'] = $user['username'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {

            header("Location: admin.php");
            exit();

        } else {

            header("Location: user.php");
            exit();
        }

    } else {

        echo "<script>
            alert('Invalid Username or Password');
        </script>";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>PharmaHub Login</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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

        /* Background circles */
        body::before {
            content: "";
            position: absolute;
            width: 500px;
            height: 500px;
            left: -180px;
            bottom: -180px;
            background: #d9f3f3;
            border-radius: 50%;
        }

        body::after {
            content: "";
            position: absolute;
            width: 450px;
            height: 450px;
            right: -180px;
            top: -170px;
            background: #dff7f6;
            border-radius: 50%;
        }

        /* Top Logo */
        .top-logo {
            position: absolute;
            top: 35px;
            left: 5%;
            display: flex;
            align-items: center;
            gap: 15px;
            z-index: 2;
        }

        .top-icon {
            width: 65px;
            height: 65px;
            background: linear-gradient(135deg, #009da2, #00b1ac);
            color: white;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            font-weight: bold;
        }

        .top-name {
            font-size: 34px;
            font-weight: bold;
            color: #153b59;
        }

        .top-name span {
            color: #00a6a6;
        }

        .top-tagline {
            font-size: 16px;
            color: #54758a;
            margin-top: 3px;
        }

        /* Left Side */
        .left-content {
            position: absolute;
            left: 5%;
            top: 28%;
            z-index: 1;
        }

        .left-content h1 {
            font-size: 34px;
            color: #149ba0;
            font-style: italic;
            line-height: 1.25;
        }

        .left-content p {
            margin-top: 12px;
            color: #607d91;
            font-size: 16px;
        }

        .medicine {
            margin-top: 35px;
            font-size: 65px;
        }

        /* Right Side */
        .right-content {
            position: absolute;
            right: 5%;
            top: 25%;
            text-align: center;
            z-index: 1;
        }

        .right-content h1 {
            font-size: 32px;
            color: #149ba0;
            font-style: italic;
            line-height: 1.25;
        }

        .health-icons {
            margin-top: 35px;
            font-size: 48px;
            line-height: 2;
            letter-spacing: 12px;
        }

        /* Login Card */
        .login-box {
            width: 650px;
            background: rgba(255, 255, 255, 0.97);
            padding: 45px 55px;
            border-radius: 22px;
            box-shadow: 0 15px 45px rgba(30, 90, 110, 0.16);
            text-align: center;
            position: relative;
            z-index: 5;
        }

        /* Card Logo */
        .card-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-bottom: 5px;
        }

        .card-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #009da2, #00b1ac);
            color: white;
            border-radius: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 38px;
            font-weight: bold;
        }

        .card-name {
            font-size: 36px;
            font-weight: bold;
            color: #153b59;
        }

        .card-name span {
            color: #00a6a6;
        }

        .card-tagline {
            color: #5d7890;
            font-size: 17px;
            margin-bottom: 25px;
        }

        /* Login Heading */
        h2 {
            font-size: 34px;
            color: #153b59;
            margin-bottom: 10px;
        }

        .welcome {
            color: #547d9a;
            font-size: 16px;
            margin-bottom: 28px;
        }

        /* Input */
        .input-group {
            position: relative;
            margin: 18px 0;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: #5c7d91;
        }

        input {
            width: 100%;
            height: 58px;
            padding: 0 55px;
            border: 1px solid #cbdde5;
            border-radius: 11px;
            background: #fbfdfe;
            outline: none;
            font-size: 16px;
            color: #173b59;
            transition: 0.3s;
        }

        input::placeholder {
            color: #91a5b1;
        }

        input:focus {
            border-color: #00a6a6;
            background: white;
            box-shadow: 0 0 0 3px rgba(0, 166, 166, 0.10);
        }

        /* Password eye */
        .eye {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 19px;
            color: #607d91;
            cursor: pointer;
        }

        /* Login Button */
        button {
            width: 100%;
            height: 58px;
            margin-top: 12px;
            background: linear-gradient(135deg, #009da2, #27bd91);
            color: white;
            border: none;
            border-radius: 11px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 157, 162, 0.25);
        }

        /* Bottom */
        .bottom-text {
            margin-top: 25px;
            color: #71899a;
            font-size: 15px;
        }

        .bottom-text a {
            color: #009da2;
            font-weight: bold;
            text-decoration: none;
        }

        .bottom-text a:hover {
            text-decoration: underline;
        }

        /* Mobile */
        @media (max-width: 1000px) {

            .left-content,
            .right-content,
            .top-logo {
                display: none;
            }

            .login-box {
                width: 90%;
                max-width: 650px;
            }
        }

        @media (max-width: 500px) {

            body {
                padding: 15px;
            }

            .login-box {
                width: 100%;
                padding: 35px 25px;
            }

            .card-name {
                font-size: 29px;
            }

            .card-icon {
                width: 52px;
                height: 52px;
                font-size: 32px;
            }

            h2 {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>

<!-- Top PharmaHub Logo -->
<div class="top-logo">

    <div class="top-icon">+</div>

    <div>
        <div class="top-name">
            Pharma<span>Hub</span>
        </div>

        <div class="top-tagline">
            Smart Pharmacy
        </div>
    </div>

</div>


<!-- Left Content -->
<div class="left-content">

    <h1>
        Better Health<br>
        Brighter Tomorrow
    </h1>

    <p>
        Smart solutions for your pharmacy
    </p>

    <div class="medicine">
        💊 💊
    </div>

</div>


<!-- Right Content -->
<div class="right-content">

    <h1>
        Your Health<br>
        Our Priority
    </h1>

    <div class="health-icons">
        💊 💉<br>
        ❤️ 🛡️
    </div>

</div>


<!-- Login Card -->
<div class="login-box">

    <div class="card-logo">

        <div class="card-icon">+</div>

        <div class="card-name">
            Pharma<span>Hub</span>
        </div>

    </div>

    <div class="card-tagline">
        Smart Pharmacy
    </div>


    <h2>Login</h2>

    <p class="welcome">
        Welcome back! Please login to your account
    </p>


    <!-- IMPORTANT:
         Backend action and input names are unchanged
    -->

    <form action="login.php" method="post">

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

            <span
                class="eye"
                onclick="togglePassword()"
            >
                👁
            </span>

        </div>


        <button type="submit">
            Login &nbsp; →
        </button>

    </form>


    <div class="bottom-text">
        Secure access to your pharmacy system
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