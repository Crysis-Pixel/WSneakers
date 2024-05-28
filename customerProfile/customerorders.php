<?php
include("../database/db.php");
session_start();
include("../customers/customerSessionAccess.php");
include("../header.html");
include("../order/orderRepo.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="customerProfile.css">
    <style>
        .product-row td {
            border: 1px solid black;
        }
        .total-row td, .delivered-row td {
            border: none;
            text-align: center;
        }
        .delivered-row p {
            background-color: #27b41a;
            color: white;
            display: inline-block;
            padding: 5px 10px;
            margin: 10px 0;
        }
        .pending-row p {
            background-color: #bd0101;
            color: white;
            display: inline-block;
            padding: 5px 10px;
            margin: 10px 0;
        }
        .shipped-row p {
            background-color: #ffbc02;
            color: white;
            display: inline-block;
            padding: 5px 10px;
            margin: 10px 0;
        }
        .order-separator {
            height: 20px;
        }

        /* Responsive styles */
        @media screen and (max-width: 768px) {
            table {
                width: 100%;
                border-collapse: collapse;
            }
            thead {
                display: none;
            }
            tr {
                display: block;
                margin-bottom: 15px;
            }
            td {
                display: block;
                text-align: right;
                position: relative;
                padding-left: 50%;
            }
            td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                padding-left: 15px;
                font-weight: bold;
                text-align: left;
            }
            .delivered-row p {
                width: 100%;
                text-align: center;
            }
            .pending-row p {
                width: 100%;
                text-align: center;
            }
            .shipped-row p {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <form action='customerProfile.php'>
        <button class="Button" type="submit">Go back</button>
    </form>

    <table>
        <h2>Your Current Orders</caption>
        <thead>
            <tr>
                <th>OrderID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total (Price x Quantity)</th>
                <th>Order Date</th>
                <th>Payment Method</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $o = OrderRepo::getInstance();
            $currorders = $o->getCurrentOrders($_SESSION['CustomerID']);
            
            $previousOrderID = null;
            $total = 0;
            $laststatus = null;
            while ($row = $currorders->fetch_assoc()){
                $currentOrderID = $row["OrderID"];
                if ($previousOrderID !== null && $currentOrderID != $previousOrderID) {
                    echo "<tr class='total-row'><td colspan='5' data-label='Total'>Total for this order: ".$total." tk</td></tr>";
                    if ($laststatus==='pending'){
                        echo "<tr class='pending-row'><td colspan='5' data-label='Status'><p>PENDING</p></td></tr>";
                    }
                    elseif($laststatus==='shipped'){
                        echo "<tr class='shipped-row'><td colspan='5' data-label='Status'><p>SHIPPED</p></td></tr>";
                    }
                    echo "<tr class='order-separator'><td colspan='5'></td></tr>";
                    $total = 0;
                }

                echo "<tr class='product-row'>";
                echo "<td data-label='OrderID'>" . $currentOrderID . "</td>";
                echo "<td data-label='Product Name'>" . $row["ProductName"] . "</td>";
                echo "<td data-label='Price'>" . $row["Price"] . "</td>";
                echo "<td data-label='Quantity'>" . $row["Quantity"] . "</td>";
                $total += $row["total"];
                echo "<td data-label='Total'>" . $row["total"] . " tk</td>";
                echo "<td data-label='OrderDate'>" . $row["Date"] . "</td>";
                echo "<td data-label='PaymentType'>" . $row["Payment_Type"] . "</td>";
                echo "<td data-label='Address'>" . $row["Address"] . "</td>";
                echo "<td>
                        <form action='../products/singleproductpage.php' method='post'>
                            <input type='hidden' name='product_id' value='".$row["ProductID"]."'>
                            <button class='Button' type='submit' name='SeeItem'>See item</button>
                        </form>
                      </td>";
                echo "</tr>";
                $previousOrderID = $currentOrderID;
                $laststatus = $row["Status"];
            }

            if ($previousOrderID !== null) {
                echo "<tr class='total-row'><td colspan='5' data-label='Total'>Total for this order: ".$total." tk</td></tr>";
                if (strcmp($laststatus,'pending')==0){
                    echo "<tr class='pending-row'><td colspan='5' data-label='Status'><p>PENDING</p></td></tr>";
                }
                elseif(strcmp($laststatus,'shipped')==0){
                    echo "<tr class='shipped-row'><td colspan='5' data-label='Status'><p>SHIPPED</p></td></tr>";
                }
            }
        ?>
        </tbody>
    </table>

    <table>
        <h2>Your Previous Orders</caption>
        <thead>
            <tr>
                <th>OrderID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total (Price x Quantity)</th>
                <th>Order Date</th>
                <th>Payment Method</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $o = OrderRepo::getInstance();
            $oldorder = $o->getOldOrders($_SESSION['CustomerID']);
            
            $previousOrderID = null;
            $total = 0;

            while ($row = $oldorder->fetch_assoc()){
                $currentOrderID = $row["OrderID"];
                if ($previousOrderID !== null && $currentOrderID != $previousOrderID) {
                    
                    echo "<tr class='total-row'><td colspan='5' data-label='Total'>Total for this order: ".$total." tk</td></tr>";
                    echo "<tr class='delivered-row'><td colspan='5' data-label='Status'><p>DELIVERED</p></td></tr>";
                    echo "<tr class='order-separator'><td colspan='5'></td></tr>";
                    $total = 0;
                }
                echo "<tr class='product-row'>";
                echo "<td data-label='OrderID'>" . $currentOrderID . "</td>";
                echo "<td data-label='Product Name'>" . $row["ProductName"] . "</td>";
                echo "<td data-label='Price'>" . $row["Price"] . "</td>";
                echo "<td data-label='Quantity'>" . $row["Quantity"] . "</td>";
                $total += $row["total"];
                echo "<td data-label='Total'>" . $row["total"] . " tk</td>";
                echo "<td data-label='OrderDate'>" . $row["Date"] . "</td>";
                echo "<td data-label='PaymentType'>" . $row["Payment_Type"] . "</td>";
                echo "<td data-label='Address'>" . $row["Address"] . "</td>";
                echo "<td>
                        <form action='../reviews/reviewpage.php' method='post'>
                            <input type='hidden' name='product_id' value='".$row["ProductID"]."'>
                            <button class='Button' type='submit' name='ReviewItem'>Write Review</button>
                        </form>
                    </td>";
                echo "<td>
                        <form action='../products/singleproductpage.php' method='post'>
                            <input type='hidden' name='product_id' value='".$row["ProductID"]."'>
                            <button class='Button' type='submit' name='SeeItem'>See item</button>
                        </form>
                      </td>";
                echo "</tr>";
                $previousOrderID = $currentOrderID;
            }

            if ($previousOrderID !== null) {
                echo "<tr class='total-row'><td colspan='5' data-label='Total'>Total for this order: ".$total." tk</td></tr>";
                echo "<tr class='delivered-row'><td colspan='5' data-label='Status'><p>DELIVERED</p></td></tr>";
            }
        ?>
        </tbody>
    </table>
</body>

</html>
