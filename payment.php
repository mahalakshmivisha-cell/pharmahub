<?php

$customername = $_POST['customername'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$medicine = $_POST['medicine'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$amount = $_POST['amount'] ?? 0;


/* Medicine list */
$medicineList = array_values(
    array_filter(
        array_map('trim', explode(',', $medicine)),
        function($value) {
            return $value !== '';
        }
    )
);

$quantityList = array_values(
    array_map('trim', explode(',', $quantity))
);

/* Total Items */
$totalItems = count($medicineList);


/* Total Quantity */
$totalQuantity = 0;

foreach ($quantityList as $qty) {

    $totalQuantity += (int)$qty;

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>PharmaHub - Payment</title>

    <!-- Separate Payment CSS -->
    <link rel="stylesheet" href="payment.css">

</head>

<body>


<!-- ================= HEADER ================= -->

<header class="payment-header">

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
            📅 <span id="currentDate"></span>
        </div>

        <div>
            🕐 <span id="currentTime"></span>
        </div>

    </div>

</header>



<!-- ================= MAIN ================= -->

<div class="payment-container">


    <!-- PAGE TITLE -->

    <div class="page-heading">

        <h1>💳 Payment</h1>

        <p>
            Complete your payment to generate the bill
        </p>

    </div>



    <!-- TWO COLUMN -->

    <div class="payment-layout">


        <!-- ================= LEFT ================= -->

        <div class="payment-card">


            <!-- TOTAL AMOUNT -->

            <div class="total-box">

                <p>Total Amount</p>

                <h2>
                    ₹<?php echo number_format($amount, 2); ?>
                </h2>

            </div>



            <!-- PAYMENT FORM -->

            <form action="success.php" method="POST"autocomplete="off">


                <!-- CUSTOMER DATA -->

                <input
                    type="hidden"
                    name="customername"
                    value="<?php echo htmlspecialchars($customername); ?>"
                >

                <input
                    type="hidden"
                    name="mobile"
                    value="<?php echo htmlspecialchars($mobile); ?>"
                >

                <input
                    type="hidden"
                    name="medicine"
                    value="<?php echo htmlspecialchars($medicine); ?>"
                >

                <input
                    type="hidden"
                    name="quantity"
                    value="<?php echo htmlspecialchars($quantity); ?>"
                >

                <input
                    type="hidden"
                    name="amount"
                    value="<?php echo htmlspecialchars($amount); ?>"
                >



                <!-- PAYMENT TITLE -->

                <h2 class="payment-title">
                    Choose Payment Method
                </h2>



                <!-- CARD -->

                <label class="payment-option">

                    <input
                        type="radio"
                        name="payment"
                        value="Card"
                        onclick="showCard()"
                        required
                    >

                    <div class="payment-icon">
                        💳
                    </div>

                    <div class="payment-info">

                        <h3>Card</h3>

                        <p>
                            Pay using Debit / Credit Card
                        </p>

                    </div>

                </label>



                <!-- GPAY -->

                <label class="payment-option">

                    <input
                        type="radio"
                        name="payment"
                        value="GPay"
                        onclick="showGPay()"
                    >

                    <div class="payment-icon">
                        📱
                    </div>

                    <div class="payment-info">

                        <h3>GPay</h3>

                        <p>
                            Pay using Google Pay
                        </p>

                    </div>

                </label>



                <!-- ================= CARD DETAILS ================= -->

                <div
                    id="cardDetails"
                    class="details-box"
                    style="display: none;"
                >

                    <h3>💳 Card Details</h3>


                    <label>Card Number</label>

                    <input
                        type="text"
                        placeholder="Enter Card Number"
                        maxlength="16"
                    >


                    <label>Card Holder Name</label>

                    <input
                        type="text"
                        placeholder="Enter Card Holder Name"
                    >


                    <div class="small-inputs">

                        <div>

    <label>Expiry Date</label>

    <input
        type="text"
        name="expiry"
        placeholder="MM/YY"
        maxlength="5"
        value=""
        autocomplete="off"
    >

</div>


<div>

    <label>CVV</label>

    <input
        type="password"
        name="cvv"
        placeholder="CVV"
        maxlength="3"
        value=""
        autocomplete="new-password"
    >

</div>
                    </div>

                </div>



                <!-- ================= GPAY ================= -->

                <div
                    id="gpayDetails"
                    class="details-box"
                    style="display: none;"
                >

                    <h3>📱 GPay Payment</h3>

                    <p>
                        Scan the QR code to complete payment
                    </p>


                    <img
                        src="images/gpay_qr.jpeg"
                        class="gpay-qr"
                        alt="GPay QR Code"
                    >

                </div>


                <!-- SECURITY -->

                <div class="security-box">

                    🔒 Your payment information is secure and encrypted

                </div>


                <!-- BUTTONS -->

                <div class="button-area">

                    <button
                        type="button"
                        class="back-btn"
                        onclick="window.location.href='billing.php'"
                    >

                        ← Back to Billing

                    </button>


                    <button
                        type="submit"
                        class="pay-btn"
                    >

                        🔒 Pay Now &nbsp; →

                    </button>

                </div>


            </form>

        </div>



        <!-- ================= RIGHT ================= -->

        <div class="order-card">

            <h2>
                ☷ &nbsp; Order Summary
            </h2>


            <div class="summary-row">

    <span>Total Items</span>

    <strong>
        <?php echo $totalItems; ?>
    </strong>

</div>


<div class="summary-row">

    <span>Total Quantity</span>

    <strong>
        <?php echo $totalQuantity; ?>
    </strong>

</div>


            <div class="summary-row">

                <span>Total Amount</span>

                <strong>
                    ₹<?php echo number_format($amount, 2); ?>
                </strong>

            </div>


            <div class="summary-row total">

            <span>Amount Payable</span>

            <span>
                ₹<?php echo number_format($amount, 2); ?>
            </span>

        </div>

    </div>

</div>


<!-- ⭐ JAVASCRIPT HERE -->

<script>

function showCard() {

    document.getElementById("cardDetails").style.display = "block";

    document.getElementById("gpayDetails").style.display = "none";

}


function showGPay() {

    document.getElementById("cardDetails").style.display = "none";

    document.getElementById("gpayDetails").style.display = "block";

}

</script>


</body>
</html>