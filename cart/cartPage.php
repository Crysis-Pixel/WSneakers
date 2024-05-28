<?php
include("../database/db.php");
include("./cart.php");
include("./cartRepository.php");
include("./cartService.php");
include("../customers/customerSessionAccess.php");
include("../header.html");

if (isset($_POST['Order'])){
    if (empty($_POST['Total'])){
        echo '<h3>Cart is empty!</h3>'; 
    }
    else{
        header("location: ../order/orderPage.php");
        exit();
    }
}

if (isset($_POST['deleteItem'])){
    $c = CartService::getInstance();
    if (!empty($_POST['cart_product']) && !empty($_POST['cart_id'])){
        $c->RemoveCartItem($_POST['cart_id'],$_POST['cart_product']);
    }
}

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
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php

            $cart = Cart::create()->retrieveOldCart($_SESSION["CustomerID"]);
            CartService::getInstance()->CartRetrievePrice($cart);
            CartService::getInstance()->CartRetrieveName($cart);

            ///Added by Mostakim///
            $cartID = $cart->getCartID();

            $productIDs = $cart->getProductIDs();
            $prices = $cart->getPriceOfProduct();
            $names = $cart->getProductName();
            $quantity = $cart->getQuantity();
            $total = 0.0;
            foreach ($productIDs as $productID) {
                echo "<tbody>";
                echo "<tr>";
                echo "<th>" . $productID . "</th>";
                echo "<td>" . $names[$productID] . "</td>";
                echo "<td>" . $prices[$productID] . "</td>";
                echo "<td>" . $quantity[$productID] . "</td>";
                echo "<td>" . $prices[$productID] * $quantity[$productID] . "</td>";
                echo "</td>
                <td>
                <form action='cartPage.php' method='post'>
                    <input type='hidden' name='cart_product' value='$productID'>
                    <input type='hidden' name='cart_id' value='$cartID'>
                    <button class='Button' type='submit' name='deleteItem'>Remove</button>
                </form>
                </td>
                </tr>";
                echo "</tbody>";
                $total += $prices[$productID] * $quantity[$productID];
            }

            ?>
        </tbody>
        <table>
            <?php
            echo "<h1 style = 'text-transform: uppercase; display: flex; justify-content: right; padding-right: 18%;'>";
            echo "Total = $total tk";
            echo "</h1>";
            ?>
            <form action="cartPage.php" method="post">
                <div class="submitDiv">
                    <?php
                        echo "<input type='hidden' name = 'Total' value='$total'>"
                    ?>
                    <input type="submit" class="submit" value="Checkout" name="Order">
                </div>
            </form>
</body>

</html>