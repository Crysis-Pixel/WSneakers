<?php
include("product.php");
class ProductRepo{

    //contains all the code through which PHP will access database.
    //Added Exception Handling to prevent code from stopping at a particular point.

    //will return the array of all the colours of a product available in products_colour table
    public function getProductColours(int $ProductID){
        try{
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con, "Select * FROM product_colour WHERE ProductID = {$ProductID}");
            return $result;
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage() . "<br>";
            return null;
        }
    }

    //will return the array of all the sizes of a product available in products_size table
    public function getProductSizes(int $ProductID){
        try{
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con, "Select * FROM product_size WHERE ProductID = {$ProductID}");
            return $result;
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage() . "<br>";
            return null;
        }
    }

    //will return the array of all the products available in products table
    public function getAllProducts() : mysqli_result {
        try{
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con, "Select * FROM product");
            return $result;
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage() . "<br>";
            return null;
        }
    }

    //will search a given product by name. If available, will return the result
    public function SearchProduct(String $productname) {
        try{
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con, "Select * FROM product WHERE ProductName LIKE '%{$productname}%'");
            if (mysqli_num_rows($result) > 0) {
                return $result;
            }
            else return null;
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    //will add product to a table,  will return true if successfully added
    public function AddProduct(Product $p) : bool{
        try{
            $con = Db::getInstance()->getConnection();
            $productName = $p->getProductName();
            $price = $p->getPrice();
            $quantity = $p->getQuantity();
            $image = $p->getImage();
            $productDescription = $p->getDesc();
            $result = mysqli_query($con, "INSERT INTO product (ProductName, Price, Quantity, Image, ProductDesc)
                        VALUES('$productName','$price','$quantity','$image','$productDescription')");
            if ($result){
                $lastID = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM product ORDER BY ProductID DESC LIMIT 1;"))["ProductID"];
                echo $lastID;
                foreach ((array)$p->getColours() as $colour){
                    try{
                        
                        $colourresult = mysqli_query($con, "INSERT INTO product_colour (ProductID, Colour)
                                        VALUES('$lastID', '$colour');");
                    }
                    catch(Exception $e){
                        echo "Colour Error: ". $e->getMessage(). "<br>";
                        $faileddelete = mysqli_query($con, "DELETE FROM product WHERE ProductID = {$lastID}");
                        return false;
                        $con->close();
                    }
                    
                }

                foreach ((array)$p->getSizes() as $size){
                    try{
                        $sizeresult = mysqli_query($con, "INSERT INTO product_size (ProductID, size)
                                        VALUES({$lastID}, {$size});");
                    }
                    catch(Exception $e){
                        echo "Size Error: ". $e->getMessage(). "<br>";
                        $faileddelete = mysqli_query($con, "DELETE FROM product WHERE ProductID = {$lastID}");
                        return false;
                    }
                }
            }
            
            return true;
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    //will remove a specific product by ID,  will return true if successfully removed
    public function RemoveProduct(int $ProductID) : bool{
        try{
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con, "DELETE FROM product WHERE ProductID = {$ProductID}");

            return true;
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }


    //Updates any specific record, will return true if successfully updated
    public function UpdateProduct(Product $p, int $productID) : bool{
        
        try{
            $con = Db::getInstance()->getConnection();
            $productName = $p->getProductName();
            $price = $p->getPrice();
            $quantity = $p->getQuantity();
            $image = $p->getImage();
            $productDescription = $p->getDesc();
            $result = mysqli_query($con, 
            "UPDATE product SET 
            ProductName = '$productName', 
            Price = '$price', 
            Quantity = '$quantity', 
            Image = '$image', 
            ProductDesc = '$productDescription'
            WHERE ProductID = {$productID};");

            //had to delete first then insert as updating directly made same changes to all rows with same productID
            $colourresult = mysqli_query($con, "DELETE FROM product_colour WHERE ProductID = {$productID};");
            foreach((array)$p->getColours() as $colour){
                $colourresult = mysqli_query($con, "INSERT INTO product_colour (ProductID, Colour)
                                        VALUES('$productID', '$colour');");
            }

            //had to delete first then insert as updating directly made same changes to all rows with same productID
            $sizeresult = mysqli_query($con, "DELETE FROM product_size WHERE ProductID = {$productID};");
            foreach((array)$p->getSizes() as $size){
                $sizeresult = mysqli_query($con, "INSERT INTO product_size (ProductID, size)
                                        VALUES({$productID}, {$size});");
            }

            return true;
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }
}
?>