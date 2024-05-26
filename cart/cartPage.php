<?php
include("../database/db.php");
include("./cart.php");
include("./cartRepository.php");
include("./cartService.php");
include("../customers/customerSessionAccess.php");
include("../header.html");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../adminPage/customerTable.css">
</head>

<body>
    <table>
        <caption>Cart</caption>

        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total (Product x Quantity) </th>
            </tr>
        </thead>

        <tbody>
            <?php

            $cart = Cart::create()->retrieveOldCart($_SESSION["CustomerID"]);
            CartService::getInstance()->CartRetrievePrice($cart);
            CartService::getInstance()->CartRetrieveName($cart);
            $productIDs = $cart->getProductIDs();
            $prices = $cart->getPriceOfProduct();
            $names = $cart->getProductName();
            $quantity = $cart->getQuantity();
            $total = 0;
            foreach ($productIDs as $productID) {
                echo "<tbody>";
                echo "<tr>";
                echo "<th>" . $productID . "</th>";
                echo "<td>" . $names[$productID] . "</td>";
                echo "<td>" . $prices[$productID] . "</td>";
                echo "<td>" . $quantity[$productID] . "</td>";
                echo "<td>" . $prices[$productID] * $quantity[$productID] . "</td>";
                echo "</td></tr>";
                echo "</tbody>";
                $total += $prices[$productID] * $quantity[$productID];
            }

            ?>
        </tbody>
        <table>
            <?php
            echo "<h1 style = 'text-transform: uppercase; display: flex; justify-content: right; padding-right: 18%;'>";
            echo "Total = $total";
            echo "</h1>";
            ?>
            <form action="../order/orderPage.php" method="post">
                <div class="submitDiv">
                    <input type="hidden" value="<?php $total ?>">
                    <input type="submit" class="submit" name="Order">
                </div>
            </form>
</body>

</html>