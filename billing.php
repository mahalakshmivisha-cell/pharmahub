<?php
include 'db.php';

$medicine = $_GET['medicine'] ?? '';

$result = mysqli_query($conn, "SELECT * FROM medicines");

$medicines = [];

while ($row = mysqli_fetch_assoc($result)) {
    $medicines[] = [
    'name' => $row['medicine_name'],
    'price' => $row['price'],
    'stock' => $row['quantity']
];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PharmaHub - Pharmacy Billing</title>

    <link rel="stylesheet" href="billing.css">
</head>

<body>

<!-- ================= HEADER ================= -->

<header class="billing-header">

    <div class="brand">

        <div class="logo">
            ✚
        </div>

        <div>
            <h2>PharmaHub</h2>
            <span>Smart Pharmacy</span>
        </div>

    </div>


    <div class="page-title">

        <div class="title-icon">
            🧾
        </div>

        <div>
            <h1>PHARMACY BILLING</h1>
            <p>Add Medicines and Generate Bill</p>
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

<div class="billing-container">

<form action="payment.php"
      method="POST"
      onsubmit="prepareBill()">


<!-- ================= CUSTOMER DETAILS ================= -->

<section class="billing-card">

    <div class="section-title">

        <span>♙</span>

        <h3>CUSTOMER DETAILS</h3>

    </div>

    <div class="customer-row">

        <div class="input-group">

            <label>Customer Name</label>

            <div class="input-wrapper">
                <span>♙</span>

                <input
                    type="text"
                    name="customername"
                    placeholder="Enter Customer Name"
                    required
                >

            </div>

        </div>


        <div class="input-group">

            <label>Mobile Number</label>

            <div class="input-wrapper">

                <span>☎</span>

                <input
                    type="text"
                    name="mobile"
                    placeholder="Enter Mobile Number"
                    maxlength="10"
                    required
                >

            </div>

        </div>

    </div>

</section>



<!-- ================= MEDICINES ================= -->

<section class="billing-card">

    <div class="section-title">

        <span>💊</span>

        <h3>MEDICINES</h3>

    </div>


    <div class="medicine-table">

        <!-- TABLE HEADER -->

        <div class="table-header">

            <div>S.No.</div>
            <div>Medicine</div>
            <div>Price (₹)</div>
            <div>Quantity</div>
            <div>Total (₹)</div>
            <div>Action</div>

        </div>


        <!-- ITEMS -->

        <div id="items">

            <div class="medicine-row">

                <div class="serial">
                    1
                </div>


                <div>

                    <select
                        class="medicine"
                        onchange="calculateTotal()"
                    >

                        <?php foreach ($medicines as $med): ?>

                            <option
    value="<?php echo htmlspecialchars($med['name']); ?>"
    data-price="<?php echo $med['price']; ?>"
    data-stock="<?php echo $med['stock']; ?>"
                                <?php
                                if ($med['name'] == $medicine) {
                                    echo "selected";
                                }
                                ?>
                            >

                                <?php echo htmlspecialchars($med['name']); ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <div>

                    <input
                        type="text"
                        class="price"
                        readonly
                    >

                </div>


                <div class="quantity-control">

    <button type="button"
            onclick="decreaseQuantity(this.nextElementSibling)">
        -
    </button>

    <input type="number"
       class="quantity"
       value="1"
       min="1"
       oninput="calculateTotal();">

    <button type="button"
            onclick="increaseQuantity(this.previousElementSibling)">
        +
    </button>

</div>


                <div class="row-total">
                    ₹0.00
                </div>


                <div>

                    <button
                        type="button"
                        class="delete-btn"
                        onclick="deleteItem(this)"
                    >
                        🗑
                    </button>

                </div>

            </div>

        </div>


        <!-- ADD MEDICINE -->

        <button
            type="button"
            class="add-medicine"
            onclick="addItem()"
        >

            ＋ Add Another Medicine

        </button>

    </div>

</section>



<!-- ================= BILL SUMMARY ================= -->

<section class="summary-card">

    <div class="total-section">

        <div class="receipt-icon">
            ₹
        </div>

        <div>

            <p>TOTAL AMOUNT</p>

            <h1>
                ₹ <span id="grandTotal">0.00</span>
            </h1>

        </div>

    </div>


    <div class="bill-summary">

        <h3>Bill Summary</h3>

        <div class="summary-line">

            <span>Total Items</span>

            <span id="totalItems">1</span>

        </div>


        <div class="summary-line">

            <span>Total Quantity</span>

            <span id="totalQuantity">1</span>

        </div>


        <div class="summary-line grand">

            <span>Grand Total</span>

            <span>₹ <span id="summaryTotal">0.00</span></span>

        </div>

    </div>

</section>



<!-- ================= HIDDEN DATA ================= -->

<input
    type="hidden"
    name="medicine"
    id="medicineData"
>

<input
    type="hidden"
    name="quantity"
    id="quantityData"
>

<input
    type="hidden"
    name="amount"
    id="amount"
>



<!-- ================= BUTTONS ================= -->

<div class="bottom-buttons">

    <button
        type="button"
        class="reset-btn"
        onclick="resetBill()"
    >

        ⓧ &nbsp; Reset

    </button>


    <button
        type="submit"
        class="payment-btn"
    >

        ➜ &nbsp; Proceed to Payment

    </button>

</div>


</form>

</div>



<script>

/* ================= DATE & TIME ================= */

function updateDateTime() {

    const now = new Date();

    const date =
        now.toLocaleDateString('en-IN', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });

    const time =
        now.toLocaleTimeString('en-IN', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        });

    document.getElementById("currentDate").innerText = date;

    document.getElementById("currentTime").innerText = time;
}

updateDateTime();

setInterval(updateDateTime, 1000);



/* ================= CALCULATE TOTAL ================= */

function calculateTotal() {

    const rows =
        document.querySelectorAll(".medicine-row");

    let grandTotal = 0;
    let totalQuantity = 0;

    rows.forEach(function(row) {

        const medicine =
            row.querySelector(".medicine");

        const quantity =
            row.querySelector(".quantity");

        const priceInput =
            row.querySelector(".price");

        const rowTotal =
            row.querySelector(".row-total");


        const price =
            parseFloat(
                medicine.options[
                    medicine.selectedIndex
                ].getAttribute("data-price")
            ) || 0;


        const stock =
    parseInt(
        medicine.options[
            medicine.selectedIndex
        ].getAttribute("data-stock")
    ) || 0;

quantity.max = stock;

let qty =
    parseInt(quantity.value) || 1;

if (stock > 0 && qty > stock) {
    qty = stock;
    quantity.value = stock;
}

if (stock === 0) {
    quantity.value = 0;
    quantity.disabled = true;
} else {
    quantity.disabled = false;
}


        priceInput.value =
            price.toFixed(2);


        const total =
            price * qty;


        rowTotal.innerText =
            "₹" + total.toFixed(2);


        grandTotal += total;

        totalQuantity += qty;

    });


    document.getElementById("grandTotal").innerText =
        grandTotal.toFixed(2);


    document.getElementById("summaryTotal").innerText =
        grandTotal.toFixed(2);


    document.getElementById("amount").value =
        grandTotal.toFixed(2);


    document.getElementById("totalItems").innerText =
        rows.length;


    document.getElementById("totalQuantity").innerText =
        totalQuantity;
}



/* ================= CHANGE QUANTITY ================= */

function changeQuantity(button, change) {

    const row =
        button.closest(".medicine-row");

    const quantity =
        row.querySelector(".quantity");

    let value =
        parseInt(quantity.value) || 1;


    value += change;


    if (value < 1) {
        value = 1;
    }


    quantity.value = value;

    calculateTotal();
}



/* ================= ADD MEDICINE ================= */

function addItem() {

    const items =
        document.getElementById("items");

    const firstRow =
        document.querySelector(".medicine-row");

    const newRow =
        firstRow.cloneNode(true);


    newRow.querySelector(".quantity").value = 1;

    newRow.querySelector(".price").value = "";

    newRow.querySelector(".row-total").innerText =
        "₹0.00";


    items.appendChild(newRow);


    updateSerialNumbers();

    calculateTotal();
}



/* ================= DELETE MEDICINE ================= */

function deleteItem(button) {

    const rows =
        document.querySelectorAll(".medicine-row");


    if (rows.length === 1) {

        alert("At least one medicine is required.");

        return;
    }


    button.closest(".medicine-row").remove();


    updateSerialNumbers();

    calculateTotal();
}



/* ================= SERIAL NUMBERS ================= */

function updateSerialNumbers() {

    const rows =
        document.querySelectorAll(".medicine-row");


    rows.forEach(function(row, index) {

        row.querySelector(".serial").innerText =
            index + 1;

    });
}



/* ================= PREPARE BILL ================= */

function prepareBill() {

    const rows =
        document.querySelectorAll(".medicine-row");

    let medicines = [];
    let quantities = [];

    rows.forEach(function(row) {

        const medicine =
            row.querySelector(".medicine").value;

        const quantity =
            parseInt(row.querySelector(".quantity").value) || 1;

        medicines.push(medicine);

        quantities.push(quantity);
    });

    document.getElementById("medicineData").value =
        medicines.join(", ");

    document.getElementById("quantityData").value =
        quantities.join(", ");

    calculateTotal();
}



/* ================= RESET ================= */

function resetBill() {

    if (!confirm("Are you sure you want to reset the bill?")) {
        return;
    }


    const items =
        document.getElementById("items");


    const rows =
        document.querySelectorAll(".medicine-row");


    rows.forEach(function(row, index) {

        if (index > 0) {
            row.remove();
        }

    });


    document.querySelector(
        'input[name="customername"]'
    ).value = "";


    document.querySelector(
        'input[name="mobile"]'
    ).value = "";


    const firstRow =
        document.querySelector(".medicine-row");


    firstRow.querySelector(".quantity").value = 1;


    updateSerialNumbers();

    calculateTotal();
}



/* ================= INITIAL CALCULATION ================= */

calculateTotal();

</script>

<script>
function increaseQuantity(input) {

    let qty = parseInt(input.value) || 1;

    let maxStock = parseInt(input.max) || 1;

    if (qty < maxStock) {
        input.value = qty + 1;
    }

    calculateTotal();
}

function decreaseQuantity(input) {
    let qty = parseInt(input.value) || 1;

    if (qty > 1) {
        input.value = qty - 1;
    }

    calculateTotal();
}
</script>

</body>

</html>