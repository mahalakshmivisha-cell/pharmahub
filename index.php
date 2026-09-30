<!DOCTYPE html>
<html>
<head>
    <title>PharmaHub</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            overflow: hidden;
            position: relative;

            background:
                radial-gradient(circle at 10% 15%, #dff8f0 0, transparent 25%),
                radial-gradient(circle at 90% 10%, #dff8f6 0, transparent 28%),
                linear-gradient(135deg, #f5fffd, #eefcf9);
        }

        /* =========================
           Decorative Background
           ========================= */

        .circle-one {
            position: absolute;
            width: 450px;
            height: 450px;
            left: -230px;
            top: -200px;
            background: #d9f5ed;
            border-radius: 50%;
            opacity: 0.75;
        }

        .circle-two {
            position: absolute;
            width: 520px;
            height: 520px;
            right: -250px;
            bottom: -270px;
            background: #d7f5ed;
            border-radius: 50%;
            opacity: 0.8;
        }

        /* =========================
           Header
           ========================= */

        .header {
            width: 100%;
            padding: 38px 55px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            position: relative;
            z-index: 5;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .brand-icon {
            width: 68px;
            height: 68px;

            display: flex;
            justify-content: center;
            align-items: center;

            background: linear-gradient(
                135deg,
                #17bda4,
                #08a89c
            );

            color: white;
            border-radius: 16px;

            font-size: 42px;
            font-weight: bold;

            box-shadow:
                0 8px 20px rgba(0, 170, 150, 0.20);
        }

        .brand-name {
            font-size: 42px;
            font-weight: bold;
            color: #124c6b;
        }

        .brand-name span {
            color: #16a58e;
        }

        .brand-subtitle {
            color: #78909c;
            font-size: 17px;
            margin-top: 5px;
        }

        .divider {
            width: 2px;
            height: 45px;
            background: #b7cbd0;
            margin-left: 20px;
        }

        .header-message {
            color: #16a58e;
            font-size: 18px;
            font-weight: bold;

            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-icon {
            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;
            background: #32b7a3;
            color: white;
            font-size: 22px;
        }

        /* =========================
           Main Area
           ========================= */

        .main {
            min-height: calc(100vh - 150px);

            display: flex;
            justify-content: center;
            align-items: center;

            position: relative;
            z-index: 3;
        }

        /* =========================
           Left Slogan
           ========================= */

        .left-content {
            position: absolute;
            left: 4%;
            top: 17%;

            z-index: 2;
        }

        .slogan {
            color: #159d8c;
            font-size: 30px;
            font-style: italic;
            font-weight: 500;
            line-height: 1.25;
        }

        .slogan-line {
            width: 180px;
            height: 3px;
            background: #45bfa7;
            margin-top: 12px;
            transform: rotate(-8deg);
            border-radius: 5px;
        }

        /* Pharmacy bottle decoration */
        .bottles {
            position: absolute;
            left: -20px;
            top: 210px;
            display: flex;
            align-items: flex-end;
            gap: 15px;
        }

        .bottle {
            width: 105px;
            height: 145px;
            background: rgba(255, 255, 255, 0.88);
            border-radius: 15px 15px 20px 20px;
            box-shadow: 0 8px 20px rgba(50, 130, 110, 0.12);
            position: relative;
        }

        .bottle.small {
            width: 75px;
            height: 110px;
        }

        .bottle::before {
            content: "";
            position: absolute;
            width: 62%;
            height: 22px;
            left: 19%;
            top: -15px;
            background: #f5f7f6;
            border-radius: 7px 7px 4px 4px;
            box-shadow: 0 -3px 0 #dfe8e5;
        }

        .bottle.small::before {
            height: 18px;
            top: -12px;
        }

        .cross {
            position: absolute;
            top: 55px;
            left: 36px;
            color: #19ad92;
            font-size: 48px;
            font-weight: bold;
        }

        .bottle.small .cross {
            left: 23px;
            top: 40px;
            font-size: 35px;
        }

        /* =========================
           Center Card
           ========================= */

        .card {
            width: 730px;
            min-height: 410px;

            background: rgba(255, 255, 255, 0.95);

            border-radius: 25px;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

            padding: 55px;

            box-shadow:
                0 20px 55px rgba(37, 116, 110, 0.13);

            position: relative;
            z-index: 10;
        }

        .card-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 25px;
        }

        /* Capsule */
        .capsule {
            width: 80px;
            height: 40px;
            border-radius: 30px;

            background: linear-gradient(
                90deg,
                #f5a1bd 50%,
                #ed4d8b 50%
            );

            transform: rotate(-45deg);
            box-shadow: 0 5px 12px rgba(220, 70, 130, 0.16);
        }

        .card-title {
            font-size: 52px;
            font-weight: bold;
            color: #124c6b;
        }

        .card-title span {
            color: #16a58e;
        }

        .card-text {
            margin-top: 25px;
            margin-bottom: 45px;

            color: #78909c;
            font-size: 21px;
        }

        /* =========================
           Dashboard Button
           ========================= */

        .dashboard-btn {
            width: 100%;
            max-width: 615px;

            height: 80px;

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 22px;

            background: linear-gradient(
                135deg,
                #1ab69f,
                #26bd99
            );

            color: white;
            text-decoration: none;

            border-radius: 13px;

            font-size: 25px;
            font-weight: bold;

            box-shadow:
                0 10px 22px rgba(25, 177, 150, 0.22);

            transition: 0.3s;
        }

        .dashboard-btn:hover {
            transform: translateY(-3px);

            box-shadow:
                0 15px 28px rgba(25, 177, 150, 0.30);
        }

        .dashboard-icon {
            font-size: 28px;
        }

        .arrow {
            font-size: 35px;
        }

        /* =========================
           Right Decoration
           ========================= */

        .right-decoration {
            position: absolute;
            right: 5%;
            top: 25%;

            text-align: center;
            color: #b7e8db;

            z-index: 1;
        }

        .plus {
            font-size: 95px;
            font-weight: bold;
        }

        .heart {
            margin-top: 25px;
            font-size: 75px;
        }

        /* Leaves */
        .leaves {
            position: absolute;
            right: 0;
            bottom: -30px;

            font-size: 90px;
            transform: rotate(-15deg);
            opacity: 0.85;
        }

        /* =========================
           Responsive
           ========================= */

        @media (max-width: 1100px) {

            .left-content,
            .right-decoration {
                display: none;
            }

            .card {
                width: 80%;
                max-width: 730px;
            }
        }

        @media (max-width: 700px) {

            body {
                overflow-y: auto;
            }

            .header {
                padding: 25px;
            }

            .brand-name {
                font-size: 30px;
            }

            .brand-icon {
                width: 52px;
                height: 52px;
                font-size: 32px;
            }

            .brand-subtitle,
            .divider,
            .header-message {
                display: none;
            }

            .main {
                min-height: calc(100vh - 100px);
                padding: 20px;
            }

            .card {
                width: 100%;
                min-height: 350px;
                padding: 35px 25px;
            }

            .card-title {
                font-size: 36px;
            }

            .capsule {
                width: 58px;
                height: 30px;
            }

            .card-text {
                font-size: 16px;
                text-align: center;
            }

            .dashboard-btn {
                height: 65px;
                font-size: 19px;
            }
        }
    </style>
</head>

<body>

<!-- Background Decorations -->
<div class="circle-one"></div>
<div class="circle-two"></div>


<!-- Header -->
<header class="header">

    <div class="brand">

        <div class="brand-icon">
            +
        </div>

        <div>
            <div class="brand-name">
                Pharma<span>Hub</span>
            </div>

            <div class="brand-subtitle">
                Smart Pharmacy
            </div>
        </div>

        <div class="divider"></div>

        <div class="brand-subtitle">
            Manage your medicines easily
        </div>

    </div>


    <div class="header-message">

        <div class="user-icon">
            👤
        </div>

        Welcome Back!

    </div>

</header>


<!-- Main -->
<main class="main">


    <!-- Left Side -->
    <div class="left-content">

        <div class="slogan">
            Healthy People<br>
            Healthy Tomorrow
        </div>

        <div class="slogan-line"></div>


        <div class="bottles">

            <div class="bottle">

                <div class="cross">+</div>

            </div>

            <div class="bottle small">

                <div class="cross">+</div>

            </div>

        </div>

    </div>


    <!-- Center Card -->
    <div class="card">

        <div class="card-logo">

            <div class="capsule"></div>

            <div class="card-title">
                Pharma<span>Hub</span>
            </div>

        </div>


        <p class="card-text">
            Manage your medicines easily
        </p>


        <!-- SAME LINK AS OLD CODE -->
        <a href="dashboard.php" class="dashboard-btn">

            <span class="dashboard-icon">
                📊
            </span>

            <span>
                Dashboard
            </span>

            <span class="arrow">
                →
            </span>

        </a>

    </div>


    <!-- Right Side -->
    <div class="right-decoration">

        <div class="plus">
            +
        </div>

        <div class="heart">
            ♡
        </div>

    </div>


    <!-- Leaves -->
    <div class="leaves">
        🌿
    </div>

</main>

</body>
</html>