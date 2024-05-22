<?php
session_start();
include("./adminSessionAccess.php");
include("../sellers/sellerRepository.php");
include("../header.html");
include("../database/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sellerID'])) {
  $sellerID = $_POST['sellerID'];
  $con = db::getInstance()->getConnection();

  $query1 = "SELECT * FROM seller WHERE SellerID = $sellerID";
  $result1 = mysqli_query($con, $query1);
  $seller1 = mysqli_fetch_assoc($result1);

  $query2 = "SELECT * FROM seller_phonenumbers WHERE SellerID = $sellerID";
  $result2 = mysqli_query($con, $query2);
  $seller2 = mysqli_fetch_assoc($result2);

  if (isset($_POST['edit'])) {
    if (empty($_POST["phone"]) || empty($_POST["username"])) {
      echo "Please fillup the form";
    } else {
      $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
      $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);

      $editUsername = "UPDATE seller SET Username = '$username' WHERE SellerID = '$sellerID'";
      mysqli_query($con, $editUsername);

      $editPhone = "UPDATE seller_phonenumbers SET Phone_Number = '$phone' WHERE SellerID = '$sellerID'";
      mysqli_query($con, $editPhone);

      header('Location: sellerTable.php');
      exit;
    }
  }
} else {
  header('Location: sellerTable.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Edit Seller</title>
  <link rel="stylesheet" href="editSeller.css">
</head>

<body class="box">
  <h1 class="h1">Edit Seller Details</h1>
  <form action="" method="post">
    <input type="hidden" name="sellerID" value="<?php echo $seller1['SellerID']; ?>">
    <div class="username">
      <label for="username">
        Username:
      </label>
      <input type="text" id="username" name="username" value="<?php echo $seller1['Username']; ?>"><br><br>
    </div>
    <div class="phone">
      <label for="phone">
        Phone:
      </label>
      <input type="text" id="phone" name="phone" value="<?php echo $seller2['Phone_Number']; ?>"><br><br>
    </div>
    <div>
      <input class="editBtn" type="submit" name="edit" value="Edit">
    </div>
  </form>
</body>

</html>