<?php

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = mysqli_query($conn, "SELECT * FROM medicines WHERE id='$id'");
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {

    $medicine_name = $_POST['medicine_name'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $expiry_date = $_POST['expiry_date'];
    $supplier = $_POST['supplier'];

    $sql = "UPDATE medicines SET
            medicine_name='$medicine_name',
            category='$category',
            quantity='$quantity',
            price='$price',
            expiry_date='$expiry_date',
            supplier='$supplier'
            WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: view_medicines.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Medicine</title>
</head>
<body>

<h2>Edit Medicine</h2>

<form method="POST">

<label>Medicine Name:</label><br>
<input type="text" name="medicine_name" value="<?php echo $row['medicine_name']; ?>" required><br><br>

<label>Category:</label><br>
<input type="text" name="category" value="<?php echo $row['category']; ?>" required><br><br>

<label>Quantity:</label><br>
<input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" required><br><br>

<label>Price:</label><br>
<input type="number" step="0.01" name="price" value="<?php echo $row['price']; ?>" required><br><br>

<label>Expiry Date:</label><br>
<input type="date" name="expiry_date" value="<?php echo $row['expiry_date']; ?>" required><br><br>

<label>Supplier:</label><br>
<input type="text" name="supplier" value="<?php echo $row['supplier']; ?>" required><br><br>

<input type="submit" name="update" value="Update Medicine">

</form>

</body>
</html>