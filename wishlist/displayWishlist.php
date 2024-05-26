<?php
include("../header.html");
include("../database/db.php");
$mainImageDIR = "../ProductImages/";
$con = db::getInstance()->getConnection();
session_start();

$username = $_SESSION['Username'];

$sql = "SELECT CustomerID FROM customer WHERE Username = '$username'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$CustomerID = $row['CustomerID'];

$sql = "SELECT 
            w.WishlistID, 
            w.CustomerID, 
            w.ProductID, 
            p.ProductName, 
            p.Price, 
            p.Quantity, 
            p.Image, 
            p.ProductDesc, 
            p.SellerID, 
            p.BrandID, 
            p.CategoryID
        FROM 
        wishlist AS w INNER JOIN product AS p 
        ON w.ProductID = p.ProductID 
        WHERE w.CustomerID = $CustomerID";

$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Wishlist</title>
</head>

<body>
    <h2>Wishlist</h2>
    <table border="1">
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Image</th>
            <th>Description</th>
            <th></th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['ProductName'] . "</td>";
            echo "<td>" . $row['Price'] . "</td>";
            echo "<td>" . $row['Quantity'] . "</td>";
            $image = $mainImageDIR . $row["Image"];
            echo "<td><img src='" . $image. "' alt='Product Image' height='100' ></td>";
            echo "<td>" . $row['ProductDesc'] . "</td>";

            echo "<td><form action='deleteWishlist.php' method='post'>";
            echo "<input type='hidden' name='WishlistID' value='" . $row['WishlistID'] . "'>";
            echo "<button type='submit'>Remove</button>";
            echo "</form></td>";

            echo "</tr>";
        }
        ?>
    </table>
</body>

</html>