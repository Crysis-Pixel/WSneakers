<?php
include("../database/db.php");
$con = db::getInstance()->getConnection();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $productID = $_POST['product_id'];
  $customerID = $_SESSION['CustomerID'];
  $sellerID = $_POST['seller_id'];
  $reportText = $_POST['reportText'];

  $sql = "INSERT INTO report (Text, CustomerID, ProductID, SellerID) 
  VALUES ('$reportText', '$customerID', '$productID', '$sellerID')";

  mysqli_query($con, $sql);
  header("Location: ../products/singleproductpage.php");
}
