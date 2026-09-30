<?php

include 'db.php';

// ================= TOTAL MEDICINES =================

$result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM medicines"
);

$row = mysqli_fetch_assoc($result);
$totalMedicines = $row['total'];


// ================= LOW STOCK MEDICINES =================

$result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS low_stock
     FROM medicines
     WHERE quantity <= 10"
);

$row = mysqli_fetch_assoc($result);
$lowStock = $row['low_stock'];


// ================= TODAY'S SALES =================

$result = mysqli_query(
    $conn,
    "SELECT COALESCE(SUM(total), 0) AS today_sales
     FROM sales
     WHERE sale_date = CURDATE()"
);

$row = mysqli_fetch_assoc($result);
$todaySales = $row['today_sales'];


// ================= TOTAL SALES =================

$result = mysqli_query(
    $conn,
    "SELECT COALESCE(SUM(total), 0) AS total_sales
     FROM sales"
);

$row = mysqli_fetch_assoc($result);
$totalSales = $row['total_sales'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>PharmaHub Dashboard</title>

    <link rel="stylesheet" href="dashboard.css">

</head>

<body>

<header class="top-header">

    <div class="brand">

        <div class="brand-logo">
            ✚
        </div>

        <div>
            <h1>PharmaHub</h1>
            <p>Smart Pharmacy</p>
        </div>

    </div>

    <div class="date-time">

        <div>
            📅 <span id="currentDate"></span>
        </div>

        <div class="divider"></div>

        <div>
            🕐 <span id="currentTime"></span>
        </div>

    </div>

</header>


<div class="dashboard-wrapper">


    <!-- ================= SIDEBAR ================= -->

    <aside class="sidebar">

        <a href="dashboard.php" class="side-link active">
            <span class="side-icon">⌂</span>
            <span>Dashboard</span>
        </a>

        <a href="add_medicine.php" class="side-link">
            <span class="side-icon">⚕</span>
            <span>Add Medicine</span>
        </a>

        <a href="view_medicines.php" class="side-link">
            <span class="side-icon">☷</span>
            <span>View Medicines</span>
        </a>

        <a href="search.php" class="side-link">
            <span class="side-icon">⌕</span>
            <span>Search Medicine</span>
        </a>

        <a href="reorder_report.php" class="side-link">
            <span class="side-icon">▣</span>
            <span>Daily Reorder Report</span>
        </a>

        <a href="sales_report.php" class="side-link">
            <span class="side-icon">▥</span>
            <span>Sales Report</span>
        </a>


        <div class="sidebar-info">

            <div class="info-icon">
                ✓
            </div>

            <h3>PharmaHub</h3>

            <p>
                Your trusted partner in better
                health and better care.
            </p>

        </div>


        <div class="copyright">

            © 2026 PharmaHub<br>
            All rights reserved.

        </div>

    </aside>


    <!-- ================= MAIN CONTENT ================= -->

    <main class="main-content">


        <!-- WELCOME -->

        <section class="welcome-card">

            <div>

                <h2>
                    Welcome to PharmaHub 👋
                </h2>

                <p>
                    Manage your pharmacy operations
                    easily and efficiently.
                </p>

            </div>

            <div class="medicine-illustration">
                💊
            </div>

        </section>


        <!-- ================= STAT CARDS ================= -->

        <section class="stats-grid">


            <!-- TOTAL MEDICINES -->

            <div class="stat-card">

                <div class="stat-icon medicine">
                    ⚕
                </div>

                <div>

                    <p>Total Medicines</p>

                    <h2>
                        <?php echo $totalMedicines; ?>
                    </h2>

                    <span>
                        Available in inventory
                    </span>

                </div>

            </div>


            <!-- TODAY'S SALES -->

            <div class="stat-card">

                <div class="stat-icon sales">
                    🛒
                </div>

                <div>

                    <p>Today's Sales</p>

                    <h2>
                        ₹<?php echo number_format($todaySales, 2); ?>
                    </h2>

                    <span>
                        Total sales today
                    </span>

                </div>

            </div>


            <!-- LOW STOCK -->

            <div class="stat-card">

                <div class="stat-icon low">
                    ↗
                </div>

                <div>

                    <p>Low Stock Items</p>

                    <h2>
                        <?php echo $lowStock; ?>
                    </h2>

                    <span>
                        Need to reorder
                    </span>

                </div>

            </div>


            <!-- TOTAL SALES -->

            <div class="stat-card">

                <div class="stat-icon total">
                    ▣
                </div>

                <div>

                    <p>Total Sales</p>

                    <h2>
                        ₹<?php echo number_format($totalSales, 2); ?>
                    </h2>

                    <span>
                        Total sales
                    </span>

                </div>

            </div>


        </section>


        <!-- ================= QUICK ACTIONS ================= -->

        <section class="quick-section">

            <div class="section-title">

                <span>ϟ</span>

                <h2>Quick Actions</h2>

            </div>


            <div class="quick-grid">


                <a href="add_medicine.php"
                   class="quick-card">

                    <div class="quick-icon green">
                        ⚕
                    </div>

                    <div>

                        <h3>Add Medicine</h3>

                        <p>
                            Add new medicine to
                            your inventory
                        </p>

                    </div>

                    <span class="arrow">
                        →
                    </span>

                </a>


                <a href="view_medicines.php"
                   class="quick-card">

                    <div class="quick-icon blue">
                        ☷
                    </div>

                    <div>

                        <h3>View Medicines</h3>

                        <p>
                            View and manage
                            all medicines
                        </p>

                    </div>

                    <span class="arrow">
                        →
                    </span>

                </a>


                <a href="search.php"
                   class="quick-card">

                    <div class="quick-icon teal">
                        ⌕
                    </div>

                    <div>

                        <h3>Search Medicine</h3>

                        <p>
                            Search medicine
                            by name
                        </p>

                    </div>

                    <span class="arrow">
                        →
                    </span>

                </a>


                <a href="reorder_report.php"
                   class="quick-card">

                    <div class="quick-icon yellow">
                        ▣
                    </div>

                    <div>

                        <h3>Daily Reorder Report</h3>

                        <p>
                            View medicines
                            that need reorder
                        </p>

                    </div>

                    <span class="arrow">
                        →
                    </span>

                </a>


                <a href="sales_report.php"
                   class="quick-card">

                    <div class="quick-icon purple">
                        ▥
                    </div>

                    <div>

                        <h3>Sales Report</h3>

                        <p>
                            View your sales
                            and analytics
                        </p>

                    </div>

                    <span class="arrow">
                        →
                    </span>

                </a>


            </div>

        </section>


        <!-- ================= BOTTOM INFO ================= -->

        <section class="inventory-tip">

            <div class="tip-icon">
                ✓
            </div>

            <div class="tip-content">

                <h3>
                    Keep Your Inventory Healthy
                </h3>

                <p>
                    Regularly update your stock and
                    reorder medicines in time to
                    avoid shortages.
                </p>

            </div>

            <a href="reorder_report.php"
               class="report-button">

                View Reports

            </a>

        </section>


    </main>

</div>


<!-- ================= DATE & TIME ================= -->

<script>

function updateDateTime() {

    const now = new Date();

    const dateOptions = {
        day: "2-digit",
        month: "short",
        year: "numeric"
    };

    document.getElementById("currentDate").textContent =
        now.toLocaleDateString("en-IN", dateOptions);

    document.getElementById("currentTime").textContent =
        now.toLocaleTimeString("en-IN", {
            hour: "2-digit",
            minute: "2-digit",
            hour12: true
        });

}

updateDateTime();

setInterval(updateDateTime, 1000);

</script>

</body>

</html>