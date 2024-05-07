<?php
include("../sellers/sellerRepository.php");
include("../header.html");
include("../database/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sellerID'])) {
  $sellerID = $_POST['sellerID'];
  $con = db::getInstance()->getConnection();

  $query = "SELECT * FROM seller WHERE SellerID = $sellerID";
  $result = mysqli_query($con, $query);
  $seller = mysqli_fetch_assoc($result);

  if (isset($_POST['edit'])) {
    if (empty($_POST["phone"]) || empty($_POST["username"])) {
      echo "Please fillup the sign up form";
    } else {
      $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
      $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);

      $edit = "UPDATE seller SET Username = '$username', Phone = '$phone' WHERE SellerID = '$sellerID'";
      mysqli_query($con, $edit);

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
    <input type="hidden" name="sellerID" value="<?php echo $seller['SellerID']; ?>">
    <div class="username">
      <label for="username">
        Username:
      </label>
      <input type="text" id="username" name="username" value="<?php echo $seller['Username']; ?>"><br><br>
    </div>
    <div class="phone">
      <label for="phone">
        Phone:
      </label>
      <input type="text" id="phone" name="phone" value="<?php echo $seller['Phone']; ?>"><br><br>
    </div>
    <div>
      <input class="editBtn" type="submit" name="edit" value="Edit">
    </div>
  </form>
</body>

</html>