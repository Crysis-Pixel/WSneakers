<!DOCTYPE html>
<html lang="en">

<?php
session_start();
include("./adminSessionAccess.php");
include("../sellers/sellerRepository.php");
include("../database/db.php");
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="sellerTable.css">
  <title>Seller List</title>
  <a class="admin" href="adminPage.php">Admin</a>
  <br><br>
</head>

<body>

  <form action="sellerTable.php" method="post">
    <div class="sel">

      <label>Search By: </label>
      <input type="text" name="searchUser" placeholder="username">
      <input type="text" name="phone" placeholder="phone">
      <label>Sort By: </label>
      <select name="select" value="ID ASC">
        <option value="ID ASC">ID ASC</option>
        <option value="ID DESC">ID DESC</option>
        <option value="Username ASC">Username ASC</option>
        <option value="Username DESC">Username DESC</option>
      </select>
      <input type="submit" name="searchBtn" value="Search">
    </div>
  </form>

  <table>
    <caption>Seller List (
      <?php
      $count = new SellerRepo();
      $count->getSellersCount();
      ?>
      )</caption>
    <thead>
      <tr>
        <th>SellerID</th>
        <th>Username</th>
        <th>Phone</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $s = new SellerRepo();
      $result = $s->getAllSellers();

      if (isset($_POST["searchBtn"])) {
        if (isset($_POST["searchUser"])) {
          $username = $_POST["searchUser"];
        } else {
          $username = '';
        }

        if (isset($_POST["phone"])) {
          $phone = $_POST["phone"];
        } else {
          $phone = '';
        }

        if (isset($_POST["select"])) {
          $sortType = $_POST["select"];
        } else {
          $sortType = 'ID ASC';
        }

        $result = $s->searchLike($username, $phone, $sortType);
      }

      if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tbody>";
          echo '<tr>';
          echo '<td>' . $row['SellerID'] . '</td>';
          echo '<td>' . $row['Username'] . '</td>';

          $Sphone = "SELECT Phone_Number FROM seller_phonenumbers WHERE SellerID = '" . $row['SellerID'] . "'";
          $con = db::getInstance()->getConnection();
          $phoneResult = mysqli_query($con, $Sphone);
          $arr = mysqli_fetch_assoc($phoneResult);

          echo '<td>' . $arr['Phone_Number'] . '</td>';
          echo '<td>';
          echo "<div>";
          echo "<div class = 'but1'>
                  <form action='editSeller.php' method='post'>
                    <input type='hidden' name='sellerID' value='" . $row['SellerID'] . "'>
                    <input class='Button' type='submit' name='editBtn' value='Edit'>
                  </form>        
                </div>";
          echo "<div class = 'but2'>
                  <form action='deleteSeller.php' method='post'>
                    <input type='hidden' name='sellerID' value='" . $row['SellerID'] . "'>
                    <input class='Button' type='submit' name='deleteBtn' value='Delete'>
                  </form>
                </div>";
          echo "</div>";
          echo "</td></tr>";
          echo "</tbody>";
        }
      }
      ?>
    </tbody>
  </table>
</body>

</html>