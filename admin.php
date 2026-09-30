<?php

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "pharmacy_inventory"
);

if (!$conn) {
    die("Database connection failed");
}

/* Today's Sales */
$today_query = mysqli_query(
    $conn,
    "SELECT COALESCE(SUM(total), 0) AS today_sales
     FROM sales
     WHERE DATE(sale_date) = CURDATE()"
);

$today_row = mysqli_fetch_assoc($today_query);
$today_sales = $today_row['today_sales'];

/* Total Sales */
$total_query = mysqli_query(
    $conn,
    "SELECT COALESCE(SUM(total), 0) AS total_sales
     FROM sales"
);

$total_row = mysqli_fetch_assoc($total_query);
$total_sales = $total_row['total_sales'];

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - PharmaHub</title>

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
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .welcome {
            margin-bottom: 30px;
        }

        .sales-summary {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 22px;
    margin-bottom: 30px;
}

.sales-card {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    gap: 20px;
}

.sales-icon {
    font-size: 38px;
}

.sales-card p {
    margin: 0 0 5px;
    color: #666;
    font-size: 14px;
}

.sales-card h2 {
    margin: 0;
    color: #1565c0;
    font-size: 28px;
}

.sales-card span {
    color: #888;
    font-size: 13px;
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
            padding: 28px;
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
            font-size: 35px;
            margin-bottom: 12px;
        }

        .card h3 {
            margin: 5px 0;
            color: #1b5e20;
        }

        .card p {
            color: #666;
            margin-bottom: 0;
        }

        @media (max-width: 700px) {
            .sales-summary {
    grid-template-columns: 1fr;
}
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
            <p>Admin Panel</p>
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
            Manage medicines, stock, reports and pharmacy operations.
        </p>

    </div>

    <div class="sales-summary">

    <div class="sales-card">

        <div class="sales-icon">🛒</div>

        <div>
            <p>Today's Sales</p>

            <h2>
                ₹<?php echo number_format($today_sales, 2); ?>
            </h2>

            <span>Total sales today</span>
        </div>

    </div>


    <div class="sales-card">

        <div class="sales-icon">📊</div>

        <div>
            <p>Total Sales</p>

            <h2>
                ₹<?php echo number_format($total_sales, 2); ?>
            </h2>

            <span>Total sales</span>
        </div>

    </div>

</div>


    <div class="grid">

        <a href="add_medicine.php" class="card">

            <div class="icon">💊</div>

            <h3>Add Medicine</h3>

            <p>Add new medicines to the pharmacy inventory.</p>

        </a>


        <a href="view_medicines.php" class="card">

            <div class="icon">📋</div>

            <h3>Manage Medicines</h3>

            <p>View, edit, delete and update medicine stock.</p>

        </a>


        <a href="reorder_report.php" class="card">

            <div class="icon">⚠️</div>

            <h3>Daily Reorder Report</h3>

            <p>Check medicines that need to be reordered.</p>

        </a>


        <a href="sales_report.php" class="card">

            <div class="icon">📊</div>

            <h3>Sales Report</h3>

            <p>View pharmacy sales and transaction details.</p>

        </a>

    </div>

</div>

</body>

</html>