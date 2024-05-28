<?php
include("../database/db.php");
$con = db::getInstance()->getConnection();
session_start();
include("../customers/customerSessionAccess.php");

$CustomerID = $_SESSION['CustomerID'];
$ProductID = $_POST['product_id'];

$sql = "INSERT INTO wishlist (CustomerID, ProductID) VALUES ($CustomerID, $ProductID)";
mysqli_query($con, $sql);

header("Location: ../products/customerproductpage.php");
exit();
