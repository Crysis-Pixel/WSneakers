<?php
class CartRepo
{
    public static $instance;
    //contains all the code through which PHP will access database.
    //Added Exception Handling to prevent code from stopping at a particular point.

    //will add product to a table,  will return true if successfully added
    public function Add(Cart $cart, $productID): bool
    {
        $isSuccessful = $this->AddCart($cart);
        // if ($isSuccessful) echo "True";
        // else echo "is Successful is False";
        $isSuccessful = $this->AddToCartItems($cart, $productID);
        // if ($isSuccessful) echo "True";
        // else echo "isSuccessful is False";
        return $isSuccessful;
    }
    public function AddCart(Cart $cart): bool
    {
        try {
            $con = Db::getInstance()->getConnection();
            $customerID = $cart->getCustomerID();

            $result = mysqli_query($con, "INSERT INTO cart(CustomerID)
                                    VALUES('$customerID')");

            return $result === true;
        } catch (Exception $e) {
            //echo "cart available";
            return false;
        }
    }

    public function AddToCartItems(Cart $cart, $productID): bool
    {

        try {
            $con = Db::getInstance()->getConnection();
            $cartID = $this->getCartID($cart->getCustomerID());
            $cart->setCartID($cartID);
            $productQuantities = $cart->getQuantity();
            $quantity = $productQuantities[$productID];
            $result = mysqli_query($con, "INSERT INTO cart_items (CartID, ProductID, Quantity)
                                            VALUES ('$cartID', '$productID', '$quantity')
                                            ON DUPLICATE KEY UPDATE Quantity = '$quantity'");
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
    public function getCartProduct($cartID)
    {
        try {
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con, "select ProductID, Quantity FROM cart_items WHERE CartID = '$cartID'");
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

    public function GetCartProductPrices($cart, $productIDs)
    {
        $con = Db::getInstance()->getConnection();
        $result = mysqli_query($con, "SELECT c.ProductID, p.Price FROM cart_items AS c 
            INNER JOIN product AS p ON c.ProductID = p.ProductID");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                if (array_search($row["ProductID"], $productIDs) !== false) {
                    $prices[$row["ProductID"]] = $row["Price"];
                }
            }
            if (!empty($prices)) {
                return $prices;
            } else return false;
        }
        echo "Price Error! ";
        return false;
    }
    public function GetCartProductNames($productIDs)
    {
        $con = Db::getInstance()->getConnection();
        $result = mysqli_query($con, "SELECT c.ProductID, p.ProductName FROM cart_items AS c 
            INNER JOIN product AS p ON c.ProductID = p.ProductID");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                if (array_search($row["ProductID"], $productIDs) !== false) {
                    $names[$row["ProductID"]] = $row["ProductName"];
                }
            }
            if (!empty($names)) {
                return $names;
            } else return false;
        }
        echo "Name Error! ";
        return false;
    }

    public function checkCustomerHasCart($customerID)
    {
        $con = Db::getInstance()->getConnection();
        $result = mysqli_query($con, "SELECT Count(CustomerID) as c FROM cart  
            WHERE CustomerID = $customerID");
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                if ($row["c"] > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        }
        return false;
    }
    
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
    //Get Product info currently in Cart
    public function getAllCartsWithProducts()
    {
        try {
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con, "SELECT c.CartID, c.CustomerID, co.ProductID FROM cart AS c INNER JOIN cart_items AS co WHERE c.CartID = co.CartID");
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


    //Removes the whole cart
    public function RemoveCart(int $CartID): bool
    {
        try {
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con, "DELETE FROM cart WHERE CartID IN ($CartID)");
            return ($result === true);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }
    //Singleton
    public static function getInstance(): CartRepo
    {
        if (!isset(CartRepo::$instance)) {
            CartRepo::$instance = new CartRepo();
        }

        return CartRepo::$instance;
    }


    ///Added by Mostakim///
    public function RemoveCartItem(int $CartID, int $ProductID): bool
    {
        try {
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con, "DELETE FROM cart_items WHERE CartID = {$CartID} AND ProductID = {$ProductID}");
            return $result;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }
}
