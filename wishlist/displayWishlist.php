<?php
include("../header.html");
include("../database/db.php");
$mainImageDIR = "../ProductImages/";
$con = db::getInstance()->getConnection();
session_start();

$CustomerID = $_SESSION['CustomerID'];

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
    <link rel="stylesheet" href="displayWishlist.css">
</head>

<body>
    <h2>Wishlist</h2>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Image</th>
            <th>Description</th>
            <th></th>
            <th></th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['ProductName'] . "</td>";
            echo "<td>" . $row['Price'] . "</td>";
            echo "<td>" . $row['Quantity'] . "</td>";
            $image = $mainImageDIR . $row["Image"];
            echo "<td><img src='" . $image . "' alt='Product Image' height='100' ></td>";
            echo "<td>" . $row['ProductDesc'] . "</td>";

            echo "<td>
                    <form action='deleteWishlist.php' method='post'>
                        <input type='hidden' name='WishlistID' value='" . $row['WishlistID'] . "'>
                        <button class = 'Button' type='submit'>Remove</button>
                    </form>
                </td>";
            echo "<td>
                    <form action='../products/singleproductpage.php' method='post'>
                        <input type='hidden' name='product_id' value='" . $row["ProductID"] . "'>
                        <button class = 'Button' type='submit'>See Item</button>
                    </form>
                </td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>

</html>