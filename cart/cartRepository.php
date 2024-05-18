<?php
class CartRepo
{
    public static $instance;
    //contains all the code through which PHP will access database.
    //Added Exception Handling to prevent code from stopping at a particular point.

    //will add product to a table,  will return true if successfully added
    public function AddCart(Cart $cart): bool
    {

        try {
            $con = Db::getInstance()->getConnection();
            $customerID = $cart->getCustomerID();

            $result = mysqli_query($con, "INSERT INTO cart(CustomerID)
                                    VALUES('$customerID')");

            return $result === true;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    public function AddToConsistsOf(Cart $cart, Product $product): bool
    {

        try {
            $con = Db::getInstance()->getConnection();
            $cartID = $cart->getCartID();
            $productID = $product->getProductID();
            $result = mysqli_query($con, "INSERT INTO consists_of(CartID, ProductID)
                                    VALUES('$cartID', '$productID')");

            return $result === true;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }


    public function getCartID($customerID): int
    {
        try {
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con, "select CartID FROM cart WHERE CustomerID = '$customerID'");
            if ($result) {
                $row  = $result->fetch_assoc();

                return $row["CartID"];
            }
            echo "cart access failed";
            return false;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }
    public function getCartProductIDs($cartID)
    {
        try {
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con, "select CartID FROM consists_of WHERE CartID = '$cartID'");
            if ($result) {
                return $result;
            }
            echo "cart product access failed";
            return false;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }
    public function getCart($customerID): Cart
    {
        try {
            $cartID = $this->getCartID($customerID);
            if ($cartID) {
                $productsResult = $this->getCartProductIDs($cartID);
                $cart = Cart::create()
                    ->setCustomerID($customerID)
                    ->setCartID($cartID["CartID"]);
                while($row = $productsResult->fetch_assoc())
                {
                    $cart->addProductID($row["ProductID"]);
                }
                return $cart;
            }
            echo "cart access failed";
            return false;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }
    //Below Work Left
    public function getCartCount()
    {
        try {
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con, "select count(1) FROM cart");
            $row = mysqli_fetch_array($result);
            return $row[0];
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return null;
        }
    }

    public function getAllCartsWithProducts()
    {
        try {
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con, "SELECT c.CartID, c.CustomerID, co.ProductID FROM cart AS c INNER JOIN consists_of AS co WHERE c.CartID = co.CartID");
            return $result;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return null;
        }
    }

    //will search a given product by name. If available, will return the result
    public function SearchCart(String $customerName)
    {
        try {
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con, "SELECT ca.CartID, ca.CustomerID, c.Username
                                        FROM cart ca
                                        INNER JOIN customer c ON c.CustomerID=ca.CustomerID
                                        WHERE c.Username = '$customerName%';");
            return $result;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }



    public function RemoveCart(int $CartID): bool
    {
        try {
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con, "DELETE FROM cart WHERE CartID = {$CartID}");
            $result1 = mysqli_query($con, "DELETE FROM consists_of WHERE CartID = {$CartID}");
            return ($result === true && $result1 === true);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    public static function getInstance(): CartRepo
    {
        if (!isset(CartRepo::$instance)) {
            CartRepo::$instance = new CartRepo();
        }

        return CartRepo::$instance;
    }
}
