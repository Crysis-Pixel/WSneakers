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
        $customerID = $order->getCustomerID();
        $couponID = $order->getCouponID();
        $total_price = $order->getTotalPrice();
        $payment_type = $order->getPayment_type();
        $address = $order->getAddress();
        $date = date('Y-m-d');
        $orderCart = $order->getOrderCart();
        if($couponID == -1)//check if coupon used
        {
            $result = mysqli_query($con, "INSERT INTO `order` (`Status`, `CustomerID`, `CouponID`, `Total_Price`, `Date`, `Address`, `Payment_Type`) 
            VALUES ('$status', '$customerID', NULL , '$total_price', '$date', '$address', '$payment_type');");
        }else
        {
            $result = mysqli_query($con, "INSERT INTO `order` (`Status`, `CustomerID`, `CouponID`, `Total_Price`, `Date`, `Address`, `Payment_Type`) 
            VALUES ('$status', '$customerID', $couponID , '$total_price', '$date', '$address', '$payment_type');");
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
            $orderID = mysqli_insert_id($con);
            $productRepo = new ProductRepo();
            foreach ($productIDs as $productID)
            {
                $quantity = $productQuantities[$productID];
                $result = $productRepo->getProduct($productID); 
                $row = $result->fetch_assoc();
                $productName = $row["ProductName"];
                $result = mysqli_query($con, "INSERT INTO `order_items` (`OrderID`, `ProductName`, `Quantity`) VALUES ('$orderID', '$productName', '$quantity');");
                
                ///Added by Mostakim////
                if (!$productRepo->UpdateProductQuantity($productID, $quantity)){
                    $result = false;
                }
                ////
                
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


    ///Added by Mostakim///
    public function getCurrentOrders($customerID){
        $con = Db::getInstance()->getConnection();
        try {
            $result = mysqli_query($con, "SELECT o.OrderID, p.ProductID, p.ProductName, p.Price, oi.Quantity, o.Date, o.Payment_Type, o.Address, (p.Price*oi.Quantity) as total, o.Status
                                            FROM `order` o
                                            INNER JOIN order_items oi on oi.OrderID=o.OrderID
                                            INNER JOIN product p on p.ProductName=oi.ProductName
                                            WHERE o.CustomerID='$customerID' AND (o.Status='pending' OR o.Status='shipped')
                                            ORDER BY o.OrderID DESC;");
            
            if($result) return $result;
            else return false;

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }
    public function getOldOrders($customerID){
        $con = Db::getInstance()->getConnection();
        try {
            $result = mysqli_query($con, "SELECT o.OrderID, p.ProductID, p.ProductName, p.Price, oi.Quantity, o.Date, o.Payment_Type, o.Address, (p.Price*oi.Quantity) as total, o.Status
                                            FROM `order` o
                                            INNER JOIN order_items oi on oi.OrderID=o.OrderID
                                            INNER JOIN product p on p.ProductName=oi.ProductName
                                            WHERE o.CustomerID='$customerID' AND o.Status='delivered'
                                            ORDER BY o.OrderID DESC;");
            
            if($result) return $result;
            else return false;

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }
    public function getCurrentOrdersforSeller($sellerID){
        $con = Db::getInstance()->getConnection();
        try {
            $result = mysqli_query($con, "SELECT o.OrderID, p.ProductID, p.ProductName, p.Price, oi.Quantity, o.Date, o.Payment_Type, o.Address, (p.Price*oi.Quantity) as total, o.Status
                                            FROM `order` o
                                            INNER JOIN order_items oi on oi.OrderID=o.OrderID
                                            INNER JOIN product p on p.ProductName=oi.ProductName
                                            WHERE p.SellerID='$sellerID' AND (o.Status='pending' OR o.Status='shipped')
                                            ORDER BY o.OrderID DESC;");
            
            if($result) return $result;
            else return false;

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }
    public function getOldOrdersforSeller($sellerID){
        $con = Db::getInstance()->getConnection();
        try {
            $result = mysqli_query($con, "SELECT o.OrderID, p.ProductID, p.ProductName, p.Price, oi.Quantity, o.Date, o.Payment_Type, o.Address, (p.Price*oi.Quantity) as total, o.Status
                                            FROM `order` o
                                            INNER JOIN order_items oi on oi.OrderID=o.OrderID
                                            INNER JOIN product p on p.ProductName=oi.ProductName
                                            WHERE p.SellerID='$sellerID' AND o.Status='delivered'
                                            ORDER BY o.OrderID DESC;");
            
            if($result) return $result;
            else return false;

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    public function UpdateOrderStatus($orderID, $status){
        $con = Db::getInstance()->getConnection();
        try {
            $result = mysqli_query($con, "UPDATE `order` SET
                                            `Status` = '$status'
                                            WHERE OrderID= $orderID;");
            
            if($result) return $result;
            else return false;

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }
    ///
}
