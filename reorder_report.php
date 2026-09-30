<?php

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "pharmacy_inventory");

if (!$conn) {
    die("Database connection failed");
}

$result = mysqli_query($conn,
"SELECT * FROM medicines
WHERE quantity <= reorder_level");
?>

<!DOCTYPE html>
<html>
<head>
<title>Daily Reorder Report</title>
<link rel="stylesheet"href="reorder.css">
</head>
<body>

<h2>Daily Reorder Report</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Medicine Name</th>
    <th>Quantity</th>
    <th>Reorder Level</th>
    <th>Status</th>
</tr>

<?php
while($row = mysqli_fetch_assoc($result)){
?>
<tr>
    <td><?php echo $row['medicine_name']; ?></td>
    <td><?php echo $row['quantity']; ?></td>
    <td><?php echo $row['reorder_level']; ?></td>
    <td style="color:red;">
        ⚠ Reorder Required
    </td>
</tr>
<?php
}
?>

</table>

</body>
</html>