<?php

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

$id = $_GET['id'];

if(isset($_POST['update'])){

    $add = $_POST['add_stock'];

    $result = mysqli_query($conn,"SELECT quantity FROM medicines WHERE id='$id'");
    $row = mysqli_fetch_assoc($result);

    $newqty = $row['quantity'] + $add;

    mysqli_query($conn,"UPDATE medicines SET quantity='$newqty' WHERE id='$id'");

    echo "<script>alert('Stock Updated Successfully');window.location='view_medicines.php';</script>";
}
?>

<form method="POST">
<h2>Add Stock</h2>

Enter Quantity to Add:
<input type="number" name="add_stock" required>

<input type="submit" name="update" value="Update Stock">
</form>