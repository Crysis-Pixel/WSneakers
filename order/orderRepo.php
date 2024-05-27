<?php
include("../products/productRepository.php");
class OrderRepo
{
    public static $instance;
    //Adds data to order Table and If Successful, Adds order_items
    public function placeOrder(Order $order)
    {
        $con = Db::getInstance()->getConnection();
        $status = $order->getStatus();
        $cartID = $order->getCartID();
        $customerID = $order->getCustomerID();
        $couponID = $order->getCouponID();
        $total_price = $order->getTotalPrice();
        $payment_type = $order->getPayment_type();
        $address = $order->getAddress();
        $date = date('Y-m-d');
        $orderCart = $order->getOrderCart();
        if($couponID == -1)//check if coupon used
        {
            $result = mysqli_query($con, "INSERT INTO `order` (`Status`, `CartID`, `CustomerID`, `CouponID`, `Total_Price`, `Date`, `Address`, `Payment_Type`) 
            VALUES ('$status', '$cartID', '$customerID', NULL , '$total_price', '$date', '$address', '$payment_type');");
        }else
        {
            $result = mysqli_query($con, "INSERT INTO `order` (`Status`, `CartID`, `CustomerID`, `CouponID`, `Total_Price`, `Date`, `Address`, `Payment_Type`) 
            VALUES ('$status', '$cartID', '$customerID', $couponID , '$total_price', '$date', '$address', '$payment_type');");
        }
        
        echo $con->error;
        if($result)
        {
            $this->storeOrderItems($orderCart);
            return true;
        } else
        {
            return false;
        }
    }
    //Adds data to order_items table from cart
    public function storeOrderItems(Cart $orderCart)
    {
        try {
            $con = Db::getInstance()->getConnection();
            $cartID = $orderCart->getCartID();
            $productIDs = $orderCart->getProductIDs();
            $productQuantities = $orderCart->getQuantity();
            $orderID = $this->getOrderID($cartID);
            $productRepo = new ProductRepo();
            foreach ($productIDs as $productID)
            {
                $quantity = $productQuantities[$productID];
                $result = $productRepo->getProduct($productID); 
                $row = $result->fetch_assoc();
                $productName = $row["ProductName"];
                $result = mysqli_query($con, "INSERT INTO `order_items` (`OrderID`, `ProductName`, `Quantity`) VALUES ('$orderID', '$productName', '$quantity');");
                if($result == false) break;
            }
            echo $con->error;
            return $result === true;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }
    //Total Amount in cart But didnt need it
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
            $result = mysqli_query($con, "SELECT OrderID FROM `order` WHERE CartID = '$cartID';");
            if($result)
            {
                $row = $result->fetch_assoc();
                return $row["OrderID"];
            }
            echo $con->error;
            return false;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }
    //Singleton
    public static function getInstance(): OrderRepo
    {
        if (!isset(OrderRepo::$instance)) {
            OrderRepo::$instance = new OrderRepo();
        }

        return OrderRepo::$instance;
    }
}
