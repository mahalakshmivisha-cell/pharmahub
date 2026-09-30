<?php

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

$search = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM medicines WHERE medicine_name LIKE '%$search%'";
}else {
    $sql = "SELECT * FROM medicines";
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>

    <title>Medicine List - PharmaHub</title>

    <!-- Existing style.css irundha idha keep pannalaam -->
    <link rel="stylesheet" href="medicines.css">

</head>

<body>

<div class="page-container">

    <!-- PharmaHub Brand -->

    <div class="brand">

        <div class="brand-icon">
            ✚
        </div>

        <div>
            <h1>PharmaHub</h1>
            <p>Smart Pharmacy</p>
        </div>

    </div>


    <!-- Page Heading -->

    <div class="page-heading">

        <div class="heading-icon">
            💊
        </div>

        <div>
            <h2>Medicine List</h2>
            <p>View and manage your medicines, stock levels and expiry dates.</p>
        </div>

    </div>


    <!-- Summary Cards -->

    <div class="summary-grid">

        <div class="summary-card blue">

            <div class="summary-icon">
                💊
            </div>

            <div>
                <h3 id="totalCount">0</h3>
                <p>Total Medicines</p>
            </div>

        </div>


        <div class="summary-card red">

            <div class="summary-icon">
                ⚠
            </div>

            <div>
                <h3 id="lowCount">0</h3>
                <p>Low Stock</p>
            </div>

        </div>


        <div class="summary-card orange">

            <div class="summary-icon">
                ⟳
            </div>

            <div>
                <h3 id="reorderCount">0</h3>
                <p>Reorder Required</p>
            </div>

        </div>


        <div class="summary-card green">

            <div class="summary-icon">
                ✓
            </div>

            <div>
                <h3 id="availableCount">0</h3>
                <p>Available</p>
            </div>

        </div>

    </div>


    <!-- Search -->

    <form method="GET" class="search-row">

        <div class="search-box">

            <span>⌕</span>

            <input
                type="text"
                name="search"
                placeholder="Search medicine by name..."
                value="<?php echo htmlspecialchars($search); ?>"
            >

        </div>

        <button type="submit" class="search-btn">
            Search
        </button>

        <a href="add_medicine.php" class="add-btn">
            <span>＋</span>
            Add Medicine
        </a>

    </form>


    <!-- Medicine Table -->

    <div class="table-card">

        <div class="table-wrapper">

            <table id="medicineTable">

                <thead>

                <tr>

                    <th>ID</th>

                    <th>Medicine Name</th>

                    <th>Category</th>

                    <th>Quantity</th>

                    <th>Price (₹)</th>

                    <th>Expiry Date</th>

                    <th>Supplier</th>

                    <th>Reorder<br>Level</th>

                    <th>Minimum<br>Level</th>

                    <th>Status</th>

                    <th>Action</th>

                </tr>

                </thead>


                <tbody>

<?php
if (isset($_GET['search']) && $_GET['search'] != "") {
    $search = $_GET['search'];
    $sql = "SELECT * FROM medicines WHERE medicine_name LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM medicines";
}

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
?>

                <tr>

                    <td>
                        <?php echo $row['id']; ?>
                    </td>


                    <td class="medicine-name">
                        <?php echo $row['medicine_name']; ?>
                    </td>


                    <td>
                        <?php echo $row['category']; ?>
                    </td>


                    <td class="quantity-cell">
                        <?php echo $row['quantity']; ?>
                    </td>


                    <td>
                        <?php echo $row['price']; ?>
                    </td>


                    <td>
                        <?php echo $row['expiry_date']; ?>
                    </td>


                    <td>
                        <?php echo $row['supplier']; ?>
                    </td>


                    <!-- Reorder Level -->

                    <td>
                        <?php echo $row['reorder_level']; ?>
                    </td>


                    <!-- Minimum Level -->

                    <td>
                        <?php echo $row['minimum_level']; ?>
                    </td>


                    <!-- Status -->

                    <td class="status-cell">

<?php
if ($row['quantity'] <= $row['reorder_level']) {
    echo "<span class='status reorder'>⚠ Reorder Required</span>";
} else {
    echo "<span class='status available'>✓ Stock Available</span>";
}
?>

                    </td>


                    <!-- Action -->

                    <td>

                        <div class="actions">

                            <a
                                href="edit_medicine.php?id=<?php echo $row['id']; ?>"
                                class="action edit"
                                title="Edit"
                            >
                                ✎
                            </a>


                            <a
                                href="delete_medicine.php?id=<?php echo $row['id']; ?>"
                                class="action delete"
                                title="Delete"
                            >
                                🗑
                            </a>


                            <a
                                href="billing.php?medicine=<?php echo urlencode($row['medicine_name']); ?>&price=<?php echo $row['price']; ?>"
                                class="action billing"
                                title="Billing"
                            >
                                ▣
                            </a>


                            <a
                                href="update_medicine.php?id=<?php echo $row['id']; ?>"
                                class="action stock"
                                title="Update Stock"
                            >
                                📦
                            </a>

                        </div>

                    </td>

                </tr>

<?php
}
?>

                </tbody>

            </table>

        </div>


        <!-- Bottom -->

        <div class="table-bottom">

            <span id="entryText">
                Showing medicines
            </span>

            <div class="pagination">

                <button disabled>‹</button>

                <button class="active">1</button>

                <button disabled>›</button>

            </div>

        </div>

    </div>

</div>


<script>

/* --------------------------------
   Summary Card Count
   PHP / Database untouched
-------------------------------- */

const rows = document.querySelectorAll(
    "#medicineTable tbody tr"
);

let total = rows.length;
let low = 0;
let reorder = 0;
let available = 0;

rows.forEach(function(row) {

    const status = row.querySelector(".status");

    if (!status) return;

    const text = status.innerText.toLowerCase();

    if (text.includes("reorder")) {
        reorder++;
    }

    if (text.includes("available")) {
        available++;
    }

    if (text.includes("low")) {
        low++;
    }

});

document.getElementById("totalCount").innerText = total;
document.getElementById("lowCount").innerText = low;
document.getElementById("reorderCount").innerText = reorder;
document.getElementById("availableCount").innerText = available;

document.getElementById("entryText").innerText =
    "Showing 1 to " + total + " of " + total + " entries";


/* --------------------------------
   Delete Confirmation
-------------------------------- */

const deleteButtons = document.querySelectorAll(".delete");

deleteButtons.forEach(function(button) {

    button.addEventListener("click", function(event) {

        const confirmDelete = confirm(
            "Are you sure you want to delete this medicine?"
        );

        if (!confirmDelete) {
            event.preventDefault();
        }

    });

});

</script>


</body>
</html>