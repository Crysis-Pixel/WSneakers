<?php
include("../database/db.php");
include("../cart/cart.php");
include("../cart/cartRepository.php");
include("../cart/cartService.php");
include("../customers/customerSessionAccess.php");
include("../header.html");
include("../coupon/couponRepo.php");
include("./orderRepo.php");
include("./order.php");
$isCoupon = false;
if (isset($_POST['couponbutton'])) {
    if (!empty($_POST["Coupon"])) {
        $couponRepo = CouponRepo::getInstance();
        $coupon = $_POST["Coupon"];
        $c = $couponRepo->getPercentage($coupon);
        if ($c) {
            echo "<h3> Coupon Applied! <h3>";
            echo "Percentage Discount: " . $c . "%";
            $isCoupon = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="orderPage.css">

</head>

<body>
    <div class="table-wrapper">
        <table>
            <caption>Items in Cart</caption>

            <thead>
                <tr>
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
                    echo "<tr>";
                    echo "<td data-label='Product Name'>" . $names[$productID] . "</td>";
                    echo "<td data-label='Price'>" . $prices[$productID] . "tk</td>";
                    echo "<td data-label='Quantity'>" . $quantity[$productID] . "</td>";
                    echo "<td data-label='Total'>" . $prices[$productID] * $quantity[$productID] . "</td>";
                    echo "</tr>";
                    $total += $prices[$productID] * $quantity[$productID];
                }

                ?>
            </tbody>
        </table>
    </div>
    <h1 style="text-transform: uppercase; display: flex; justify-content: right; padding-right: 18%;">
        Total = <?php echo $total; ?> tk
        <?php
        $finalPrice = $total;
        if ($isCoupon) {
            echo "<br>New Price: " . $total - ($total * $c / 100.0) . " tk";
            $finalPrice = $total - ($total * $c / 100.0);
        }
        ?>

    </h1>
    <form action="orderPage.php" method="post">
        Coupon:<input type='text' name="Coupon" placeholder="Enter coupon">
        <button type='submit' class='Button' name='couponbutton' style='padding:1%;width:10%;'>Add coupon</button><br><br>
    </form>
    <form action="orderPage.php" method="post">
    Delivery Address:<br><textarea type='text' name="Address" rows="2" cols="30"><?php echo $_SESSION["Address"] ?></textarea>
        <div class="payment-options" style='display: flex; justify-content: center; padding-bottom:2%'>
            Payment Options:
            <div class="payment-option">
                <input type="radio" id="bkash" name="payment" value="bkash" checked>
                <img src="../PaymentLogos/bkash.png" alt="bkash Logo" height="20">
                <label for="bkash">bkash</label>
            </div>&nbsp;&nbsp;&nbsp;
            <div class="payment-option">
                <input type="radio" id="nagad" name="payment" value="nagad">
                <img src="../PaymentLogos/nagad.png" alt="nagad Logo" height="20">
                <label for="nagad">nagad</label>
            </div>&nbsp;&nbsp;&nbsp;
            <div class="payment-option">
                <input type="radio" id="mastercard" name="payment" value="MasterCard">
                <img src="../PaymentLogos/mastercard.png" alt="MasterCard Logo" height="20">
                <label for="mastercard">MasterCard</label>
            </div>&nbsp;&nbsp;&nbsp;
            <div class="payment-option">
                <input type="radio" id="visa" name="payment" value="Visa">
                <img src="../PaymentLogos/visa.png" alt="Visa Logo" height="20">
                <label for="visa">Visa</label>
            </div>&nbsp;&nbsp;&nbsp;
        </div>

        <div class="submitDiv">
            <?php echo "<input type='hidden' name='Total' value='$total'>"; ?>
            <input type="submit" class="Button" name="Order" value="Place Order" style="padding: 1%">
        </div>
    </form>
</body>

</html>

<?php
if (isset($_POST["couponbutton"])) {
    if (!empty($coupon)) { //To store CouponID if used
        $_SESSION["CouponID"] = $couponRepo->getCouponID($coupon);
    }
}
if (isset($_POST["Order"])) {
    $orderRepo = OrderRepo::getInstance();
    $order = Order::create()
        ->setStatus("pending")
        ->setCustomerID($_SESSION["CustomerID"])
        ->setTotalPrice($finalPrice)
        ->setAddress(filter_input(INPUT_POST, "Address", FILTER_SANITIZE_SPECIAL_CHARS))
        ->setOrderCart($cart)
        ->setPayment_type($_POST["payment"]);

        if(isset($_SESSION["CouponID"])) // To use the stored CouponID. Used session because value is lost when coupon form submitted
        {
            $order->setCouponID($_SESSION["CouponID"]);
            unset($_SESSION["CouponID"]);
        } else
        {
            $order->setCouponID(-1);
        }
        if($orderRepo->placeOrder($order))  //Check if Order Confirmed
        {
            ///Javascript added by Mostakim
            echo "<script type='text/javascript'>
                alert('Order Confirmed!');
                window.location.href = '../products/customerproductpage.php';
              </script>";
            ///
            CartService::getInstance()->RemoveCart($cart->getCartID());     //Remove Cart When Order Confirmed
        } else
        {           
            echo "Order Failed!";
        }
}
?>