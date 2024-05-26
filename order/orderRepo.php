<?php
    include("../database/db.php");
    include("../cart/cart.php");
    include("../cart/cartRepository.php");
    include("../cart/cartService.php");
    session_start();
    class OrderRepo{
        public function getTotalofCustomerCart(){
            $con = Db::getInstance()->getConnection();
            $customerID = $_SESSION['CustomerID'];
            try{
                $total = mysqli_query($con, "SELECT SUM(p.Price*ci.Quantity) as 'Total'
                                            FROM cart as c
                                            INNER JOIN cart_items ci ON ci.CartID=c.CartID
                                            INNER JOIN product p ON p.ProductID=ci.ProductID
                                            WHERE c.CustomerID=$customerID;");
                return $total["Total"];
            }
            catch(Exception $e){
                echo "Error: " . $e->getMessage() . "<br>";
                return false;
            }
        }
    }
?>