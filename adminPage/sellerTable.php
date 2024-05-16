<!DOCTYPE html>
<html lang="en">

<?php
include("../sellers/sellerRepository.php");
include("../database/db.php");
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="sellerTable.css">
  <title>Seller List</title>
  <a class="admin" href="./adminPage.html">Admin</a>
  <br><br>
</head>

<body>
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
      if (mysqli_num_rows($result) > 0) {
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
          echo "<div>
                  <form action='editSeller.php' method='post'>
                    <input type='hidden' name='sellerID' value='" . $row['SellerID'] . "'>
                    <input class='edit' type='submit' name='editBtn' value='Edit'>
                  </form>        
                </div>";
          echo "<div>
                  <form action='deleteSeller.php' method='post'>
                    <input type='hidden' name='sellerID' value='" . $row['SellerID'] . "'>
                    <input class='delete' type='submit' name='deleteBtn' value='Delete'>
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