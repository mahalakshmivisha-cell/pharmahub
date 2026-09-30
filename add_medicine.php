<?php

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

if (isset($_POST['add'])) {

    $medicine_name = mysqli_real_escape_string($conn, $_POST['medicine_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    $expiry_date = mysqli_real_escape_string($conn, $_POST['expiry_date']);
    $supplier = mysqli_real_escape_string($conn, $_POST['supplier']);
    $minimum_level = (int)$_POST['minimum_level'];
    $reorder_level = (int)$_POST['reorder_level'];

    $sql = "INSERT INTO medicines 
        (medicine_name, category, quantity, price, expiry_date, supplier, minimum_level, reorder_level)
        VALUES 
        ('$medicine_name', '$category', '$quantity', '$price', '$expiry_date', '$supplier', '$minimum_level', '$reorder_level')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Medicine Added Successfully');</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Medicine - PharmaHub</title>

    <link rel="stylesheet" href="add_medicine.css">

</head>

<body>

<div class="page-container">

    <!-- Brand -->

    <div class="brand">

        <div class="brand-icon">
            ✚
        </div>

        <div>
            <h1>PharmaHub</h1>
            <p>Smart Pharmacy</p>
        </div>

    </div>


    <!-- Main Card -->

    <div class="medicine-card">

        <!-- Heading -->

        <div class="page-heading">

            <div class="heading-icon">
                💊
            </div>

            <div>
                <h2>Add Medicine</h2>
                <p>Enter the medicine details to add it to your inventory.</p>
            </div>

        </div>


        <div class="divider"></div>


        <!-- Form -->

        <form method="POST">

            <div class="form-grid">


                <!-- Medicine Name -->

                <div class="form-group">

                    <label>
                        Medicine Name <span>*</span>
                    </label>

                    <div class="input-box">

                        <div class="input-icon">
                            💊
                        </div>

                        <input
                            type="text"
                            name="medicine_name"
                            placeholder="Enter medicine name"
                            required
                        >

                    </div>

                </div>


                <!-- Supplier -->

                <div class="form-group">

                    <label>
                        Supplier <span>*</span>
                    </label>

                    <div class="input-box">

                        <div class="input-icon">
                            🏢
                        </div>

                        <input
                            type="text"
                            name="supplier"
                            placeholder="Enter supplier name"
                            required
                        >

                    </div>

                </div>


                <!-- Category -->

                <div class="form-group">

                    <label>
                        Category <span>*</span>
                    </label>

                    <div class="input-box">

                        <div class="input-icon">
                            ▦
                        </div>

                        <input
                            type="text"
                            name="category"
                            placeholder="Enter category"
                            required
                        >

                    </div>

                </div>


                <!-- Reorder Level -->

                <div class="form-group">

                    <label>
                        Reorder Level <span>*</span>
                    </label>

                    <div class="input-box">

                        <div class="input-icon">
                            ⟳
                        </div>

                        <input
                            type="number"
                            name="reorder_level"
                            placeholder="Enter reorder level"
                            required
                        >

                    </div>

                </div>


                <!-- Quantity -->

                <div class="form-group">

                    <label>
                        Quantity <span>*</span>
                    </label>

                    <div class="input-box">

                        <div class="input-icon">
                            📦
                        </div>

                        <input
                            type="number"
                            name="quantity"
                            placeholder="Enter quantity"
                            required
                        >

                    </div>

                </div>


                <!-- Minimum Level -->

                <div class="form-group">

                    <label>
                        Minimum Level <span>*</span>
                    </label>

                    <div class="input-box">

                        <div class="input-icon">
                            🛡
                        </div>

                        <input
                            type="number"
                            name="minimum_level"
                            placeholder="Enter minimum level"
                            required
                        >

                    </div>

                </div>


                <!-- Price -->

                <div class="form-group">

                    <label>
                        Price (₹) <span>*</span>
                    </label>

                    <div class="input-box">

                        <div class="input-icon rupee">
                            ₹
                        </div>

                        <input
                            type="number"
                            step="0.01"
                            name="price"
                            placeholder="Enter price"
                            required
                        >

                    </div>

                </div>


                <!-- Expiry Date -->

                <div class="form-group">

                    <label>
                        Expiry Date <span>*</span>
                    </label>

                    <div class="input-box">

                        <div class="input-icon">
                            📅
                        </div>

                        <input
                            type="date"
                            name="expiry_date"
                            required
                        >

                    </div>

                </div>


            </div>


            <!-- Buttons -->

            <div class="form-actions">

                <button
                    type="reset"
                    class="reset-btn"
                >
                    ↻ &nbsp; Reset
                </button>


                <button
                    type="submit"
                    name="add"
                    value="Add Medicine"
                    class="add-btn"
                >
                    ＋ &nbsp; Add Medicine
                </button>

            </div>

        </form>


        <!-- Back -->

        <a href="index.php" class="back-link">
            ← &nbsp; Back to Home
        </a>

    </div>

</div>

</body>
</html>