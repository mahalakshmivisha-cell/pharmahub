<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Dashboard - PharmaHub</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f8fb;
            color: #333;
        }

        .header {
            background: linear-gradient(135deg, #2196F3, #4CAF50);
            color: white;
            padding: 22px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo {
            background: white;
            color: #2196F3;
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            font-weight: bold;
        }

        .brand h1 {
            margin: 0;
        }

        .brand p {
            margin: 3px 0 0;
        }

        .logout {
            text-decoration: none;
            background: white;
            color: #2196F3;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: bold;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .welcome {
            margin-bottom: 30px;
        }

        .welcome h2 {
            margin-bottom: 5px;
            color: #1b5e20;
        }

        .welcome p {
            color: #666;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.08);
            text-decoration: none;
            color: #333;
            transition: 0.2s;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .icon {
            font-size: 38px;
            margin-bottom: 12px;
        }

        .card h3 {
            margin: 5px 0;
            color: #1b5e20;
        }

        .card p {
            color: #666;
            line-height: 1.5;
        }

        @media (max-width: 700px) {

            .grid {
                grid-template-columns: 1fr;
            }

            .header {
                padding: 20px;
            }

        }

    </style>

</head>

<body>

<header class="header">

    <div class="brand">

        <div class="logo">✚</div>

        <div>
            <h1>PharmaHub</h1>
            <p>Customer Portal</p>
        </div>

    </div>

    <a href="logout.php" class="logout">
        Logout
    </a>

</header>


<div class="container">

    <div class="welcome">

        <h2>
            Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?> 👋
        </h2>

        <p>
            Search medicines and purchase the medicines you need.
        </p>

    </div>


    <div class="grid">

        <!-- Search Medicine -->

        <a href="search.php" class="card">

            <div class="icon">🔍</div>

            <h3>Search Medicine</h3>

            <p>
                Search for a medicine and add it to your bill.
            </p>

        </a>


        <!-- View Medicines -->

        <a href="user_medicines.php" class="card">

            <div class="icon">💊</div>

            <h3>View Medicines</h3>

            <p>
                View available medicines, prices, stock and expiry information.
            </p>

        </a>

    </div>

</div>


</body>

</html>