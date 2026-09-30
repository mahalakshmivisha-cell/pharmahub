<?php

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

$conn = mysqli_connect("localhost", "root", "", "pharmacy_inventory");

if (!$conn) {
    die("Database connection failed");
}

$from_date = $_GET['from_date'] ?? '';
$to_date = $_GET['to_date'] ?? '';

/* Group medicines belonging to the same bill */

$query = "
SELECT
    bill_no,
    customer_name,
    GROUP_CONCAT(medicine_name SEPARATOR ', ') AS medicines,
    GROUP_CONCAT(quantity SEPARATOR ', ') AS quantities,
    SUM(total) AS total_amount,
    payment_method AS payment,
    sale_date AS bill_date
FROM sales
";

/* Date filter */

if (!empty($from_date) && !empty($to_date)) {

    $query .= "
    WHERE DATE(sale_date)
    BETWEEN '$from_date' AND '$to_date'
    ";

}

$query .= "
GROUP BY
    bill_no,
    customer_name,
    payment_method,
    sale_date
ORDER BY CAST(bill_no AS UNSIGNED) ASC
";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sales Report - PharmaHub</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f9fb;
            color: #173f59;
        }

        .page-container {
            width: 96%;
            max-width: 1400px;
            margin: 20px auto;
            background: white;
            padding: 28px;
            border-radius: 12px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.07);
        }


        /* BRAND */

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 28px;
        }

        .brand-icon {
            width: 50px;
            height: 50px;
            background: #19a5b4;
            color: white;
            border-radius: 10px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 29px;
            font-weight: bold;
        }

        .brand h1 {
            color: #124b6a;
            font-size: 27px;
        }

        .brand p {
            color: #7d94a3;
            font-size: 14px;
            margin-top: 3px;
        }


        /* HEADING */

        .heading {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 25px;
        }

        .heading-icon {
            width: 60px;
            height: 60px;

            background: #e1f7fa;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 27px;
        }

        .heading h2 {
            font-size: 29px;
            color: #143f5b;
        }

        .heading p {
            margin-top: 5px;
            color: #7d94a3;
            font-size: 14px;
        }


        /* DATE FILTER */

        .filter-card {
            background: #f8fcfd;

            border: 1px solid #dceaf0;

            border-radius: 10px;

            padding: 20px;

            margin-bottom: 24px;
        }

        .filter-title {
            font-size: 15px;
            font-weight: bold;
            color: #174d6c;
            margin-bottom: 14px;
        }

        .filter-form {
            display: flex;
            align-items: end;
            gap: 15px;
        }

        .date-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .date-group label {
            font-size: 13px;
            font-weight: bold;
            color: #41677c;
        }

        .date-group input {
            height: 44px;

            width: 190px;

            border: 1px solid #cbdfe8;

            border-radius: 7px;

            padding: 0 12px;

            color: #315a70;

            background: white;

            outline: none;
        }

        .date-group input:focus {
            border-color: #19a5b4;
        }


        /* GENERATE */

        .generate-btn {
            height: 44px;

            padding: 0 22px;

            border: none;

            border-radius: 7px;

            background: #13a3a4;

            color: white;

            font-weight: bold;

            cursor: pointer;
        }

        .generate-btn:hover {
            background: #078b8d;
        }


        /* RESET */

        .reset-btn {
            height: 44px;

            padding: 0 18px;

            border-radius: 7px;

            border: 1px solid #cbdfe8;

            background: white;

            color: #42687c;

            text-decoration: none;

            display: flex;

            align-items: center;
        }


        /* TABLE */

        .table-card {
            border: 1px solid #dceaf0;

            border-radius: 10px;

            overflow: hidden;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;

            min-width: 950px;

            border-collapse: collapse;
        }

        th {
            background: #edf9fb;

            color: #164a68;

            padding: 15px 12px;

            font-size: 13px;

            border-bottom: 1px solid #dceaf0;

            white-space: nowrap;
        }

        td {
            padding: 14px 12px;

            text-align: center;

            color: #315a73;

            font-size: 13px;

            border-bottom: 1px solid #e5eef2;

            white-space: nowrap;
        }

        tbody tr:hover {
            background: #f8fcfd;
        }


        .bill-no {
            font-weight: bold;
            color: #147f93;
        }

        .customer {
            font-weight: bold;
            color: #31566e;
        }

        .amount {
            font-weight: bold;
            color: #16825d;
        }


        /* PAYMENT */

        .payment {
            display: inline-block;

            padding: 6px 11px;

            border-radius: 15px;

            background: #e9f5ff;

            color: #2872a7;

            font-size: 12px;

            font-weight: bold;
        }


        /* BOTTOM */

        .bottom {
            padding: 16px 20px;

            background: #f8fcfd;

            color: #718b9a;

            font-size: 13px;
        }


        /* MOBILE */

        @media (max-width: 700px) {

            .page-container {
                width: 94%;
                padding: 20px;
            }

            .filter-form {
                flex-direction: column;
                align-items: stretch;
            }

            .date-group input {
                width: 100%;
            }

            .generate-btn,
            .reset-btn {
                width: 100%;
                justify-content: center;
            }

        }

    </style>

</head>


<body>

<div class="page-container">


    <!-- BRAND -->

    <div class="brand">

        <div class="brand-icon">
            ✚
        </div>

        <div>
            <h1>PharmaHub</h1>
            <p>Smart Pharmacy</p>
        </div>

    </div>


    <!-- HEADING -->

    <div class="heading">

        <div class="heading-icon">
            📊
        </div>

        <div>

            <h2>Sales Report</h2>

            <p>
                View and generate sales reports between selected dates.
            </p>

        </div>

    </div>


    <!-- DATE FILTER -->

    <div class="filter-card">

        <div class="filter-title">
            📅 Select Date Range
        </div>

        <form method="GET" class="filter-form">


            <div class="date-group">

                <label>From Date</label>

                <input
                    type="date"
                    name="from_date"
                    value="<?php echo htmlspecialchars($from_date); ?>"
                    required
                >

            </div>


            <div class="date-group">

                <label>To Date</label>

                <input
                    type="date"
                    name="to_date"
                    value="<?php echo htmlspecialchars($to_date); ?>"
                    required
                >

            </div>


            <button
                type="submit"
                class="generate-btn"
            >
                🔍 Generate Report
            </button>


            <a
                href="sales_report.php"
                class="reset-btn"
            >
                Reset
            </a>


        </form>

    </div>


    <!-- TABLE -->

    <div class="table-card">

        <div class="table-wrapper">

            <table>

                <tr>

                    <th>Bill No</th>

                    <th>Customer</th>

                    <th>Medicine</th>

                    <th>Quantity</th>

                    <th>Total</th>

                    <th>Payment Method</th>

                    <th>Date</th>

                </tr>


<?php

$count = 0;

while ($row = mysqli_fetch_assoc($result)) {

    $count++;

?>

                <tr>

                    <td class="bill-no">
                        <?php echo htmlspecialchars($row['bill_no']); ?>
                    </td>


                    <td class="customer">
                        <?php echo htmlspecialchars($row['customer_name']); ?>
                    </td>


                    <td>
                        <?php echo htmlspecialchars($row['medicines']); ?>
                    </td>


                    <td>
                        <?php echo htmlspecialchars($row['quantities']); ?>
                    </td>


                    <td class="amount">
                        ₹<?php echo number_format($row['total_amount'], 2); ?>
                    </td>


                    <td>

                        <span class="payment">
                            <?php echo htmlspecialchars($row['payment']); ?>
                        </span>

                    </td>


                    <td>
                        <?php echo htmlspecialchars($row['bill_date']); ?>
                    </td>

                </tr>

<?php

}

?>

            </table>

        </div>


        <div class="bottom">

<?php

if (!empty($from_date) && !empty($to_date)) {

    echo "Showing sales from " .
         htmlspecialchars($from_date) .
         " to " .
         htmlspecialchars($to_date) .
         " — " .
         $count .
         " bill(s) found.";

} else {

    echo "Showing all sales — " . $count . " bill(s) found.";

}

?>

        </div>

    </div>


</div>

</body>

</html>