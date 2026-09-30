<?php
include 'db.php';

date_default_timezone_set('Asia/Kolkata');

$customername = $_POST['customername'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$medicine = $_POST['medicine'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$amount = $_POST['amount'] ?? 0;
$payment = $_POST['payment'] ?? '';
/* ================= SAVE SALES ================= */

/* ================= MEDICINE & QUANTITY LIST ================= */

$medicineList = array_values(
    array_filter(
        preg_split('/\s*,\s*/', trim($medicine)),
        function($value) {
            return $value !== '';
        }
    )
);

$quantityList = array_values(
    preg_split('/\s*,\s*/', trim($quantity))
);


$billResult = mysqli_query(
    $conn,
    "SELECT COALESCE(MAX(CAST(bill_no AS UNSIGNED)), 1000) AS max_bill
     FROM sales"
);

$billRow = mysqli_fetch_assoc($billResult);

$billNo = ((int)$billRow['max_bill']) + 1;


/* Save each medicine */

foreach ($medicineList as $index => $medicineName) {

    $qty = (int)($quantityList[$index] ?? 1);


    /* Get medicine price */

    $priceResult = mysqli_query(
        $conn,
        "SELECT price, quantity
         FROM medicines
         WHERE medicine_name = '" . mysqli_real_escape_string($conn, $medicineName) . "'"
    );

    $priceRow = mysqli_fetch_assoc($priceResult);


    if ($priceRow) {

        $price = (float)$priceRow['price'];

        $total = $price * $qty;


        /* Insert into sales table */

        $customerSafe =
            mysqli_real_escape_string($conn, $customername);

        $medicineSafe =
            mysqli_real_escape_string($conn, $medicineName);

        $paymentSafe =
            mysqli_real_escape_string($conn, $payment);


        mysqli_query(
            $conn,
            "INSERT INTO sales
            (bill_no, customer_name, medicine_name, quantity, total, payment_method, sale_date)
            VALUES
            (
                '$billNo',
                '$customerSafe',
                '$medicineSafe',
                '$qty',
                '$total',
                '$paymentSafe',
                CURDATE()
            )"
        );


        /* Update stock */

        mysqli_query(
            $conn,
            "UPDATE medicines
             SET quantity = quantity - $qty
             WHERE medicine_name = '$medicineSafe'"
        );

    }
}

/* Total Items */
$totalItems = count($medicineList);


/* Total Quantity */
$totalQuantity = 0;

foreach ($quantityList as $qty) {
    $totalQuantity += (int)$qty;
}


/* Transaction ID */
$transactionId = 'TXN' . date('YmdHis');


/* Date & Time */
$transactionDate = date('d M Y');
$transactionTime = date('h:i A');

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>PharmaHub - Payment Successful</title>

    <link rel="stylesheet" href="success.css">

</head>


<body>


<!-- ================= HEADER ================= -->

<header class="success-header">

    <div class="brand">

        <div class="logo">
            ✚
        </div>

        <div>

            <h2>PharmaHub</h2>

            <span>Smart Pharmacy</span>

        </div>

    </div>


    <div class="date-time">

        <div>
            📅 <?php echo $transactionDate; ?>
        </div>

        <div>
            🕐 <?php echo $transactionTime; ?>
        </div>

    </div>

</header>



<!-- ================= MAIN ================= -->

<main class="success-container">


    <!-- SUCCESS AREA -->

    <section class="success-box">


        <div class="success-icon">
            ✓
        </div>


        <h1>
            Payment Successful!
        </h1>


        <p class="success-message">
            Your payment has been completed successfully.
        </p>


        <!-- SECURITY LINE -->

        <div class="security-line">

            <span></span>

            🛡️

            <span></span>

        </div>


        <!-- TRANSACTION -->

        <div class="transaction-box">

            <p>Transaction ID</p>

            <strong>
                <?php echo htmlspecialchars($transactionId); ?>
            </strong>

        </div>


        <!-- BUTTONS -->

        <div class="success-buttons">

            <button
                class="invoice-btn"
                onclick="generateInvoice()"
            >
                🖨 Generate Invoice
            </button>


            <button
                class="dashboard-btn"
                onclick="window.location.href='billing.php'"
            >
                ⌂ Back to Dashboard
            </button>

        </div>


    </section>



    <!-- ================= PAYMENT SUMMARY ================= -->

    <section class="summary-card">


        <div class="summary-heading">

            <span class="summary-icon">
                ▣
            </span>

            <h2>
                Payment Summary
            </h2>

        </div>



        <div class="summary-content">


            <!-- LEFT -->

            <div class="customer-summary">

                <div class="detail-row">

                    <span>Customer Name</span>

                    <strong>
                        <?php echo htmlspecialchars($customername); ?>
                    </strong>

                </div>


                <div class="detail-row">

                    <span>Mobile Number</span>

                    <strong>
                        <?php echo htmlspecialchars($mobile); ?>
                    </strong>

                </div>


                <div class="detail-row">

                    <span>Payment Method</span>

                    <strong>
                        <?php echo htmlspecialchars($payment); ?>
                    </strong>

                </div>


                <div class="detail-row">

                    <span>Transaction Date</span>

                    <strong>
                        <?php echo $transactionDate; ?>
                    </strong>

                </div>


                <div class="detail-row">

                    <span>Transaction Time</span>

                    <strong>
                        <?php echo $transactionTime; ?>
                    </strong>

                </div>

            </div>



            <!-- RIGHT -->

            <div class="medicine-summary">

    <h3>Medicines Purchased</h3>

    <?php foreach ($medicineList as $index => $medicineName): ?>

        <div class="detail-row">

            <span>
                <?php echo htmlspecialchars($medicineName); ?>
            </span>

            <strong>
                Qty:
                <?php echo (int)($quantityList[$index] ?? 0); ?>
            </strong>

        </div>

    <?php endforeach; ?>

</div>

            <div class="amount-summary">


                <div class="detail-row">

                    <span>Total Items</span>

                    <strong>
                        <?php echo $totalItems; ?>
                    </strong>

                </div>


                <div class="detail-row">

                    <span>Total Quantity</span>

                    <strong>
                        <?php echo $totalQuantity; ?>
                    </strong>

                </div>


                <div class="detail-row">

                    <span>Total Amount</span>

                    <strong>
                        ₹<?php echo number_format($amount, 2); ?>
                    </strong>

                </div>


                <div class="amount-paid">

                    <span>Amount Paid</span>

                    <strong>
                        ₹<?php echo number_format($amount, 2); ?>
                    </strong>

                </div>


            </div>



            <!-- WALLET ICON -->

            <div class="wallet">

                💳

                <div class="wallet-shield">
                    ✓
                </div>

            </div>


        </div>

    </section>



    <!-- FOOTER MESSAGE -->

    <div class="thank-you">

        🔒

        <span>
            Thank you for shopping with PharmaHub.
            We care for your health!
        </span>

    </div>


</main>



<!-- ================= INVOICE ================= -->

<script>

function generateInvoice() {

    window.print();

}

</script>


</body>

</html>