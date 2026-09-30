<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

include 'db.php';

$search = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];

    $sql = "SELECT * FROM medicines
            WHERE medicine_name LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM medicines";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>

    <title>View Medicines - PharmaHub</title>

    <link rel="stylesheet" href="medicines.css">

</head>

<body>

<div class="page-container">

    <div class="brand">

        <div class="brand-icon">
            ✚
        </div>

        <div>
            <h1>PharmaHub</h1>
            <p>Smart Pharmacy</p>
        </div>

    </div>


    <div class="page-heading">

        <div class="heading-icon">
            💊
        </div>

        <div>
            <h2>Available Medicines</h2>
            <p>View available medicines and stock information.</p>
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

    </form>


    <!-- Medicine Table -->

    <div class="table-card">

        <div class="table-wrapper">

            <table>

                <thead>

                <tr>
                    <th>ID</th>
                    <th>Medicine Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Price (₹)</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                </tr>

                </thead>

                <tbody>

<?php

while ($row = mysqli_fetch_assoc($result)) {

?>

                <tr>

                    <td>
                        <?php echo $row['id']; ?>
                    </td>

                    <td class="medicine-name">
                        <?php echo htmlspecialchars($row['medicine_name']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['category']); ?>
                    </td>

                    <td>
                        <?php echo $row['quantity']; ?>
                    </td>

                    <td>
                        ₹<?php echo $row['price']; ?>
                    </td>

                    <td>
                        <?php echo $row['expiry_date']; ?>
                    </td>

                    <td>

<?php

if ($row['quantity'] <= $row['reorder_level']) {

    echo "<span class='status reorder'>⚠ Reorder Required</span>";

} else {

    echo "<span class='status available'>✓ Available</span>";

}

?>

                    </td>

                </tr>

<?php

}

?>

                </tbody>

            </table>

        </div>

    </div>

    <br>

    <a href="user.php">⬅ Back to Dashboard</a>

</div>

</body>

</html>