<?php
include("../database/db.php");
session_start();
include("adminSessionAccess.php");
include("../header.html");
include("../order/orderRepo.php");
include("../sellers/sellerRepository.php");
$s = new SellerRepo();
$o = OrderRepo::getInstance();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['updatebtn']) && !empty($_POST['order_id'])){
        $status = $_POST['status'];
        $orderID = $_POST["order_id"];
        if (!$o->UpdateOrderStatus($orderID, $status)){
            echo "Failed to update status.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../customerProfile/customerProfile.css">
    <style>
        .product-row td {
            border: 1px solid black;
        }
        .total-row td, .delivered-row td {
            border: none;
            text-align: center;
        }

        /* Styles for status options */
        .status-option {
            display: inline-block;
            margin-right: 10px;
            cursor: pointer;
        }

        .status-option.selected {
            border: 2px solid black;
            color: white;
            display: inline-block;
            padding: 5px 10px;
            margin: 10px 0;
        }

        .status-option.pending {
            background-color: #bd0101;
            color: white;
            display: inline-block;
            padding: 5px 10px;
            margin: 10px 0;
        }

        .status-option.shipped {
            background-color: #ffbc02;
            color: white;
            display: inline-block;
            padding: 5px 10px;
            margin: 10px 0;
        }

        .status-option.delivered {
            background-color: #27b41a;
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
        }
    </style>
</head>

<body>
    <form action='adminPage.php'>
        <button class="Button" type="submit">Go back</button>
    </form>

    <table>
        <h2>Current Orders</caption>
        <thead>
            <tr>
                <th>OrderID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total (Price x Quantity)</th>
                <th>Order Date</th>
                <th>Payment Type</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
        <?php

            $sellerresult = $s->getAllSellersID();

            while ($row = $sellerresult->fetch_assoc()){
                $currorders = $o->getCurrentOrdersforSeller($row['SellerID']);
                $total = 0;
                $laststatus = null;
                $previousOrderID = null;
                $currentOrderID = null;
                while ($row = $currorders->fetch_assoc()){
                    $previousOrderID = $currentOrderID;
                    $currentOrderID = $row["OrderID"];
                    if ($previousOrderID!=null && $previousOrderID!=$currentOrderID){
                        echo "<tr class='total-row'><td colspan='5' data-label='Total'>Total for this order:".$total." tk</td></tr>";
                        if ($laststatus==='pending'){
                            echo "<tr><td>
                            <form action='sellerorders.php' method='post'>
                            <select name='status'>
                                // Dropdown options for status
                                <option value='pending' class='status-option pending' selected>Pending</option>
                                <option value='shipped' class='status-option shipped'>Shipped</option>
                                <option value='delivered' class='status-option delivered'>Delivered</option>
                            </select>
                            <input type='hidden' name='order_id' value='".$previousOrderID."'>
                            <button type='submit' name='updatebtn' class='Button' style='padding:2%;'>Update</button>
                            </form></td></tr>";
                        }
                        elseif($laststatus==='shipped'){
                            echo "<tr><td>
                            <form action='sellerorders.php' method='post'>
                            <select name='status'>
                                // Dropdown options for status
                                <option value='pending' class='status-option pending'>Pending</option>
                                <option value='shipped' class='status-option shipped' selected>Shipped</option>
                                <option value='delivered' class='status-option delivered'>Delivered</option>
                            </select>
                            <input type='hidden' name='order_id' value='".$previousOrderID."'>
                            <button type='submit' name='updatebtn' class='Button' style='padding:2%;'>Update</button>
                            </form></td></tr>";
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
                    echo "<td data-label='Total'>" . $row["total"] . "</td>";
                    echo "<td data-label='OrderDate'>" . $row["Date"] . "</td>";
                    echo "<td data-label='PaymentType'>" . $row["Payment_Type"] . "</td>";
                    echo "<td data-label='Address'>" . $row["Address"] . "</td>";
                    echo "</tr>";
                    $laststatus = $row["Status"];
                }

                if ($currentOrderID !== null) {
                    echo "<tr class='total-row'><td colspan='5' data-label='Total'>Total for this order:".$total." tk</td></tr>";
                    if ($laststatus==='pending'){
                        echo "<tr><td>
                            <form action='sellerorders.php' method='post'>
                            <select name='status'>
                                // Dropdown options for status
                                <option value='pending' class='status-option pending' selected>Pending</option>
                                <option value='shipped' class='status-option shipped'>Shipped</option>
                                <option value='delivered' class='status-option delivered'>Delivered</option>
                            </select>
                            <input type='hidden' name='order_id' value='".$currentOrderID."'>
                            <button type='submit' name='updatebtn' class='Button' style='padding:2%;'>Update</button>
                            </form></td></tr>";
                    }
                    elseif($laststatus==='shipped'){
                        echo "<tr><td>
                            <form action='sellerorders.php' method='post'>
                            <select name='status'>
                                // Dropdown options for status
                                <option value='pending' class='status-option pending'>Pending</option>
                                <option value='shipped' class='status-option shipped' selected>Shipped</option>
                                <option value='delivered' class='status-option delivered'>Delivered</option>
                            </select>
                            <input type='hidden' name='order_id' value='".$currentOrderID."'>
                            <button type='submit' name='updatebtn' class='Button' style='padding:2%;'>Update</button>
                            </form></td></tr>";
                    }
                }
            }
            
        ?>
        </tbody>
    </table>

    <table>
        <h2>Previous Orders</caption>
        <thead>
            <tr>
                <th>OrderID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total (Price x Quantity)</th>
                <th>Order Date</th>
                <th>Payment Type</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $sellerresult = $s->getAllSellersID();
            while ($row = $sellerresult->fetch_assoc()){
                $oldorders = $o->getOldOrdersforSeller($row['SellerID']);
                $total = 0;
                $laststatus = null;
                $previousOrderID = null;
                $currentOrderID = null;
                while ($row = $oldorders->fetch_assoc()){
                    $previousOrderID = $currentOrderID;
                    $currentOrderID = $row["OrderID"];
                    if ($previousOrderID!=null && $previousOrderID!=$currentOrderID){
                        echo "<tr class='total-row'><td colspan='5' data-label='Total'>Total for this order:".$total." tk</td></tr>";
                        if ($laststatus==='pending'){
                            echo "<tr><td>
                                <form action='sellerorders.php' method='post'>
                                <select name='status'>
                                    // Dropdown options for status
                                    <option value='pending' class='status-option pending' selected>Pending</option>
                                    <option value='shipped' class='status-option shipped'>Shipped</option>
                                    <option value='delivered' class='status-option delivered'>Delivered</option>
                                </select>
                                <input type='hidden' name='order_id' value='".$previousOrderID."'>
                                <button type='submit' name='updatebtn' class='Button' style='padding:2%;'>Update</button>
                                </form></td></tr>";
                        }
                        elseif($laststatus==='shipped'){
                            echo "<tr><td>
                                <form action='sellerorders.php' method='post'>
                                <select name='status'>
                                    // Dropdown options for status
                                    <option value='pending' class='status-option pending'>Pending</option>
                                    <option value='shipped' class='status-option shipped' selected>Shipped</option>
                                    <option value='delivered' class='status-option delivered'>Delivered</option>
                                </select>
                                <input type='hidden' name='order_id' value='".$previousOrderID."'>
                                <button type='submit' name='updatebtn' class='Button' style='padding:2%;'>Update</button>
                                </form></td></tr>";
                        }
                        elseif($laststatus==='delivered'){
                            echo "<tr><td>
                                <form action='sellerorders.php' method='post'>
                                <select name='status'>
                                    // Dropdown options for status
                                    <option value='pending' class='status-option pending'>Pending</option>
                                    <option value='shipped' class='status-option shipped' selected>Shipped</option>
                                    <option value='delivered' class='status-option delivered' selected>Delivered</option>
                                </select>
                                <input type='hidden' name='order_id' value='".$previousOrderID."'>
                                <button type='submit' name='updatebtn' class='Button' style='padding:2%;'>Update</button>
                                </form></td></tr>";
                                $total = 0;
                        }
                    }
                    echo "<tr class='product-row'>";
                    echo "<td data-label='OrderID'>" . $currentOrderID . "</td>";
                    echo "<td data-label='Product Name'>" . $row["ProductName"] . "</td>";
                    echo "<td data-label='Price'>" . $row["Price"] . "</td>";
                    echo "<td data-label='Quantity'>" . $row["Quantity"] . "</td>";
                    $total += $row["total"];
                    echo "<td data-label='Total'>" . $row["total"] . "</td>";
                    echo "<td data-label='OrderDate'>" . $row["Date"] . "</td>";
                    echo "<td data-label='PaymentType'>" . $row["Payment_Type"] . "</td>";
                    echo "<td data-label='Address'>" . $row["Address"] . "</td>";
                    echo "</tr>";
                    $laststatus = $row["Status"];
                }

                if ($currentOrderID !== null) {
                    echo "<tr class='total-row'><td colspan='5' data-label='Total'>Total for this order:".$total." tk</td></tr>";
                    if ($laststatus==='pending'){
                        echo "<tr><td>
                            <form action='sellerorders.php' method='post'>
                            <select name='status'>
                                // Dropdown options for status
                                <option value='pending' class='status-option pending' selected>Pending</option>
                                <option value='shipped' class='status-option shipped'>Shipped</option>
                                <option value='delivered' class='status-option delivered'>Delivered</option>
                            </select>
                            <input type='hidden' name='order_id' value='".$currentOrderID."'>
                            <button type='submit' name='updatebtn' class='Button' style='padding:2%;'>Update</button>
                            </form></td></tr>";
                    }
                    elseif($laststatus==='shipped'){
                        echo "<tr><td>
                            <form action='sellerorders.php' method='post'>
                            <select name='status'>
                                // Dropdown options for status
                                <option value='pending' class='status-option pending'>Pending</option>
                                <option value='shipped' class='status-option shipped' selected>Shipped</option>
                                <option value='delivered' class='status-option delivered'>Delivered</option>
                            </select>
                            <input type='hidden' name='order_id' value='".$currentOrderID."'>
                            <button type='submit' name='updatebtn' class='Button' style='padding:2%;'>Update</button>
                            </form></td></tr>";
                    }
                    elseif($laststatus==='delivered'){
                        echo "<tr><td>
                            <form action='sellerorders.php' method='post'>
                            <select name='status'>
                                // Dropdown options for status
                                <option value='pending' class='status-option pending'>Pending</option>
                                <option value='shipped' class='status-option shipped'>Shipped</option>
                                <option value='delivered' class='status-option delivered' selected>Delivered</option>
                            </select>
                            <input type='hidden' name='order_id' value='".$currentOrderID."'>
                            <button type='submit' name='updatebtn' class='Button' style='padding:2%;'>Update</button>
                            </form></td></tr>";
                    }
                }
            }
        ?>
        </tbody>
    </table>
</body>

</html>
