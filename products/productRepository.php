<?php
include("product.php");
class ProductRepo{

    //contains all the code through which PHP will access database.
    //Added Exception Handling to prevent code from stopping at a particular point.

    public function getProduct($productID){
        try{
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con,"select * FROM product WHERE ProductID = {$productID}");
            return $result;
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage() . "<br>";
            return null;
        }
    }

    //returns number of products in product table
    public function getProductCount(){
        try{
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con,"select count(1) FROM product");
            $row = mysqli_fetch_array($result);
            return $row[0];
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage() . "<br>";
            return null;
        }
    }

    //will return the array of all the colours of a product available in products_colour table
    public function getProductColours(int $ProductID){
        try{
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con, "Select Colour FROM product_colour WHERE ProductID = {$ProductID}");
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
            $result = mysqli_query($con, "Select size FROM product_size WHERE ProductID = {$ProductID}");
            return $result;
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage() . "<br>";
            return null;
        }
    }

    //will return the array of all the products available in products table
    public function getAllProducts(){
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
    public function SearchProduct(String $productname, int $size, string $colour, string $category, string $brand){
        try{
            $con = Db::getInstance()->getConnection();
            if ($size==-1){
                $result = mysqli_query($con, "SELECT DISTINCT(p.ProductID), p.ProductName, p.Price, p.Quantity, p.Image, p.ProductDesc, p.SellerID, p.BrandID, p.CategoryID
                FROM product AS p
                LEFT JOIN product_size ON p.ProductID = product_size.ProductID
                LEFT JOIN product_colour ON p.ProductID = product_colour.ProductID
                INNER JOIN category ON p.CategoryID=category.CategoryID
                INNER JOIN brand ON p.BrandID=brand.BrandID
                WHERE (product_colour.Colour LIKE '{$colour}%' or product_colour.Colour IS NULL) and p.ProductName LIKE '{$productname}%' and category.Type LIKE '{$category}%' and brand.Name LIKE '{$brand}%';");
            }
            else{
                $result = mysqli_query($con, "SELECT DISTINCT(p.ProductID), p.ProductName, p.Price, p.Quantity, p.Image, p.ProductDesc, p.SellerID, p.BrandID, p.CategoryID
                FROM product AS p
                LEFT JOIN product_size ON p.ProductID = product_size.ProductID
                LEFT JOIN product_colour ON p.ProductID = product_colour.ProductID
                INNER JOIN category ON p.CategoryID=category.CategoryID
                INNER JOIN brand ON p.BrandID=brand.BrandID
                WHERE (product_size.size = {$size} or product_size.size IS NULL) and (product_colour.Colour LIKE '{$colour}%' or product_colour.Colour IS NULL) and p.ProductName LIKE '{$productname}%' and category.Type LIKE '{$category}%' and brand.Name LIKE '{$brand}%';");
            }
            return $result;
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    //will search a given product by name. If available, will return the result
    public function SearchProductofSeller(String $productname, int $size, string $colour, string $category, string $brand, string $seller){
        try{
            $con = Db::getInstance()->getConnection();
            if ($size==-1){
                $result = mysqli_query($con, "SELECT DISTINCT(p.ProductID), p.ProductName, p.Price, p.Quantity, p.Image, p.ProductDesc, p.SellerID, p.BrandID, p.CategoryID
                FROM product AS p
                LEFT JOIN product_size ON p.ProductID = product_size.ProductID
                LEFT JOIN product_colour ON p.ProductID = product_colour.ProductID
                INNER JOIN category ON p.CategoryID=category.CategoryID
                INNER JOIN brand ON p.BrandID=brand.BrandID
                INNER JOIN seller ON p.SellerID=seller.SellerID
                WHERE seller.SellerID = {$seller} and (product_colour.Colour LIKE '{$colour}%' or product_colour.Colour IS NULL) and p.ProductName LIKE '{$productname}%' and category.Type LIKE '{$category}%' and brand.Name LIKE '{$brand}%';");
            }
            else{
                $result = mysqli_query($con, "SELECT DISTINCT(p.ProductID), p.ProductName, p.Price, p.Quantity, p.Image, p.ProductDesc, p.SellerID, p.BrandID, p.CategoryID
                FROM product AS p
                LEFT JOIN product_size ON p.ProductID = product_size.ProductID
                LEFT JOIN product_colour ON p.ProductID = product_colour.ProductID
                INNER JOIN category ON p.CategoryID=category.CategoryID
                INNER JOIN brand ON p.BrandID=brand.BrandID
                INNER JOIN seller ON p.SellerID=seller.SellerID
                WHERE seller.SellerID = {$seller} and (product_size.size = {$size} or product_size.size IS NULL) and (product_colour.Colour LIKE '{$colour}%' or product_colour.Colour IS NULL) and p.ProductName LIKE '{$productname}%' and category.Type LIKE '{$category}%' and brand.Name LIKE '{$brand}%';");
            }
            return $result;
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    //will add product to a table,  will return true if successfully added
    public function AddProduct(Product $p) : bool{
        $con = Db::getInstance()->getConnection();
        
        try{
            $productName = $p->getProductName();
            $price = $p->getPrice();
            $quantity = $p->getQuantity();
            $image = $p->getImage();
            $productDescription = $p->getDesc();
            $BrandID = $p->getBrandID();
            $CategoryID = $p->getCategoryID();
            $SellerID = $p->getSellerID();
            $result = mysqli_query($con, "INSERT INTO product (ProductName, Price, Quantity, Image, ProductDesc, BrandID, CategoryID, SellerID)
                        VALUES('$productName','$price','$quantity','$image','$productDescription', '$BrandID', '$CategoryID', '$SellerID')");
            if ($result){
                $lastID = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM product ORDER BY ProductID DESC LIMIT 1;"))["ProductID"];

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
            $productImage = $this->getProduct($ProductID)->fetch_assoc()['Image'];
            $imageloc = "../ProductImages/".$productImage;
            unlink($imageloc);
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

        $con = Db::getInstance()->getConnection();

        try{
            $productName = $p->getProductName();
            $price = $p->getPrice();
            $quantity = $p->getQuantity();
            $image = $p->getImage();
            $productDescription = $p->getDesc();
            $BrandID = $p->getBrandID();
            $CategoryID = $p->getCategoryID();
            $SellerID = $p->getSellerID();
            
            $result = mysqli_query($con, 
            "UPDATE product SET 
            ProductName = '$productName', 
            Price = '$price', 
            Quantity = '$quantity', 
            Image = '$image', 
            ProductDesc = '$productDescription',
            BrandID = '$BrandID',
            CategoryID = '$CategoryID',
            SellerID = '$SellerID'
            WHERE ProductID = {$productID};");
            return true;
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    public function AddProductSize(int $productID, int $size):bool{

        $con = Db::getInstance()->getConnection();

        try{
            //had to delete first then insert as updating directly made same changes to all rows with same productID
            $sizeresult = mysqli_query($con, "SELECT size FROM product_size 
            WHERE ProductID = {$productID} AND size = {$size};");
            if (mysqli_num_rows($sizeresult) == 0) {
                $sizeresult = mysqli_query($con, "INSERT INTO product_size(ProductID, size)
                VALUES({$productID}, {$size});");
                return true;
            }
            else{
                echo "<h3> Product size already in product. </h3>";
                return false;
            }
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    public function AddProductColour(int $productID, string $colour):bool{

        $con = Db::getInstance()->getConnection();

        try{
            //had to delete first then insert as updating directly made same changes to all rows with same productID
            $colourresult = mysqli_query($con, "SELECT Colour FROM product_colour 
            WHERE ProductID = {$productID} AND Colour = '{$colour}';");
            if (mysqli_num_rows($colourresult) == 0) {
                $colourresult = mysqli_query($con, "INSERT INTO product_colour(ProductID, Colour)
                VALUES({$productID}, '{$colour}');");
                return true;
            }
            else{
                echo "<h3> Product colour already in product. </h3>";
                return false;
            }
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    public function DeleteProductSize(int $productID, int $size):bool{

        $con = Db::getInstance()->getConnection();

        try{
            //had to delete first then insert as updating directly made same changes to all rows with same productID
            $sizeresult = mysqli_query($con, "DELETE FROM product_size WHERE ProductID = {$productID} AND size = {$size};");
            return true;
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    public function UpdateProductColour(int $productID, string $oldcolour, string $newcolour):bool{

        $con = Db::getInstance()->getConnection();

        try{
            //had to delete first then insert as updating directly made same changes to all rows with same productID
            $colourresult = mysqli_query($con, "UPDATE product_colour SET
            Colour = {$newcolour}
            WHERE ProductID = {$productID} AND Colour = {$oldcolour};");
            return true;
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    public function DeleteProductColour(int $productID, string $colour):bool{

        $con = Db::getInstance()->getConnection();

        try{
            //had to delete first then insert as updating directly made same changes to all rows with same productID
            $colourresult = mysqli_query($con, "DELETE FROM product_colour WHERE ProductID = {$productID} AND Colour = '{$colour}';");
            return true;
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    public function getLastID() {
        $con = Db::getInstance()->getConnection();
        $result = mysqli_query($con, "SELECT ProductID FROM product ORDER BY ProductID DESC LIMIT 1");

        if ($result){
            $row = mysqli_fetch_assoc($result);
            return (int)$row['ProductID'];
        }
        else return null;
    }

    public function SearchbyBrand(string $Brand){
        try{
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con, "SELECT p.ProductID, p.ProductName, p.Price, p.Quantity, p.Image, p.ProductDesc, p.SellerID, b.BrandID, p.CategoryID
                                        FROM product AS p 
                                        INNER JOIN brand AS b ON p.BrandID=b.BrandID
                                        WHERE p.BrandID LIKE {$Brand}");
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

    public function GetAllDistinctColours(){
        try{
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con, "SELECT DISTINCT(Colour) FROM product_colour");
            return $result;
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage() . "<br>";
            return null;
        }

    }

    public function GetAllDistinctSizes(){
        try{
            $con = Db::getInstance()->getConnection();
            $result = mysqli_query($con, "SELECT DISTINCT(size) FROM product_size");
            return $result;
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage() . "<br>";
            return null;
        }

    }

}
?>