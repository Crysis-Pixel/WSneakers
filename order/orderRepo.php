<?php
include("../database/db.php");
include("../cart/cart.php");
include("../cart/cartRepository.php");
include("../cart/cartService.php");
session_start();
class OrderRepo
{
    public static $instance;
    public function getTotalofCustomerCart()
    {
        $con = Db::getInstance()->getConnection();
        $customerID = $_SESSION['CustomerID'];
        try {
            $total = mysqli_query($con, "SELECT SUM(p.Price*ci.Quantity) as 'Total'
                                            FROM cart as c
                                            INNER JOIN cart_items ci ON ci.CartID=c.CartID
                                            INNER JOIN product p ON p.ProductID=ci.ProductID
                                            WHERE c.CustomerID=$customerID;");
            return $total["Total"];
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    public function CopyCart($customerID)
    {
        $cart = Cart::create()->retrieveOldCart($customerID);
    }

    public function getOrderID($cartID)
    {
        $con = Db::getInstance()->getConnection();
        try {
            $result = mysqli_query($con, "SELECT OrderID FROM 'order' WHERE CartID = $cartID;");
            return $result;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }
    public static function getInstance(): OrderRepo
    {
        if (!isset(OrderRepo::$instance)) {
            OrderRepo::$instance = new OrderRepo();
        }

        return OrderRepo::$instance;
    }
}
