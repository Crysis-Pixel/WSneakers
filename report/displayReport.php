<?php
session_start();
include("../sellers/sellerSessionAccess.php");
include("../header.html");
include('report.php');
include("../database/db.php");
$con = db::getInstance()->getConnection();

$SellerID = $_SESSION['SellerID'];

$sql = "SELECT 
            c.Username, 
            p.ProductName, 
            r.Text
        FROM 
        report r JOIN product p ON r.ProductID = p.ProductID
        JOIN customer c ON r.CustomerID = c.CustomerID
        WHERE r.SellerID = $SellerID";

$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html>

<head>
  <title>Your Product Reports</title>
  <link rel="stylesheet" href="displayReport.css">
</head>

<body>
  <form action='../sellerProfile/sellerProfile.php'>
    <button class="Button" type="submit">Go back</button>
  </form>
  <h2>Reports</h2>
  <table>
    <tr>
      <th>Reported by</th>
      <th>Comments</th>
    </tr>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>";
      echo $row['ProductName'];
      echo " was reported by ";
      echo $row['Username'];
      echo "</td>";
      echo "<td>" . $row['Text'] . "</td>";
      echo "</tr>";
    }
    ?>
  </table>
</body>

</html>