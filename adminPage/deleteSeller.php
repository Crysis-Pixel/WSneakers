<?php
include("../database/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sellerID'])) {
  $sellerID = $_POST['sellerID'];
  $con = db::getInstance()->getConnection();

  $deleteSeller = "DELETE FROM seller WHERE SellerID = $sellerID";
  mysqli_query($con, $deleteSeller);

  $deleteSellerPhone = "DELETE FROM seller_phonenumbers WHERE SellerID = $sellerID";
  mysqli_query($con, $deleteSellerPhone);

  header('Location: sellerTable.php');
  exit;
}
