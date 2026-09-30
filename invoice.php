<?php
$conn = mysqli_connect("localhost","root","","pharmacy_inventory");

$customer = $_POST['customername'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$medicine = $_POST['medicine'] ?? '';
$amount = $_POST['amount'] ?? '';
$payment = $_POST['payment'] ?? '';

date_default_timezone_set("Asia/Kolkata");

$result = mysqli_query($conn, "SELECT MAX(bill_no) AS last_bill FROM bill_history");
$row = mysqli_fetch_assoc($result);

$billno = $row['last_bill'];

$date = date("d-m-y");
$time = date("h:i A");
?>
<!DOCTYPE html>
<html>
<head>
<title>PharmaHub Invoice</title>

<style>
body{
    font-family: Courier New, monospace;
    background:#f5f5f5;
}
.invoice{
    width:500px;
    margin:30px auto;
    background:#fff;
    border:2px solid #000;
    padding:20px;
}
h2,h3{
    text-align:center;
    margin:0;
}
hr{
    border:1px dashed black;
}
button{
    padding:10px 20px;
    font-size:16px;
}
@media print{
button{
display:none;
}
}
</style>

</head>
<body>

<div class="invoice">

<h2>PHARMAHUB</h2>
<h3>Pharmacy Management System</h3>
<p><strong>Customer Name:</strong> <?php echo  $customer; ?></p>
<p><strong>Mobile Number:</strong> <?php echo $mobile; ?></p>


<p><b>Bill No :</b> <?php echo $billno; ?></p>

<p><b>Date :</b> <?php echo $date; ?></p>

<p><b>Time :</b> <?php echo $time; ?></p>

<p><b>Payment :</b> <?php echo $payment; ?></p>

<hr>

<table width="100%">
<tr>
<th align="left">Medicine</th>
<th align="right">Price</th>
</tr>

<tr>
<td><?php echo $medicine; ?></td>
<td align="right">₹<?php echo $amount; ?></td>
</tr>
</table>

<hr>

<h3>Total Amount : ₹<?php echo $amount; ?></h3>

<hr>

<center>
<b>Thank You for Visiting!</b><br>
Get Well Soon!
</center>

<br>

<center>
<button onclick="window.print()">Print Bill</button>
</center>
<br>

</div>

</body>
</html>