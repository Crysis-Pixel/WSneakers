<?php
include("../database/db.php");
$con = db::getInstance()->getConnection();
session_start();

$username = $_SESSION['Username'];
$ProductID = $_POST['product_id'];

$sql = "SELECT CustomerID FROM customer WHERE Username = '$username'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$CustomerID = $row['CustomerID'];

$sql2 = "INSERT INTO wishlist (CustomerID, ProductID) VALUES ($CustomerID, $ProductID)";
mysqli_query($con, $sql2);

header("Location: ../products/customerproductpage.php");
exit();
