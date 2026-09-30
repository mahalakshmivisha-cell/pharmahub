<?php

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM medicines WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: view_medicines.php");
        exit();
    } else {
        echo "Error deleting medicine: " . mysqli_error($conn);
    }
} else {
    echo "No medicine selected.";
}
?>