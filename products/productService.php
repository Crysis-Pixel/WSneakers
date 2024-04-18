<?php
    //a lot of help taken from customer files to match code
    //contains all the code to follow basic funtionalities: Create, Read, Update, Delete
    //Create - Insert function
    //Read - Search and getAll function
    //Update - Update function
    //Delete - Delete function

    include("productRepository.php");
    $mainImageDIR = "/WSneakers/ProductImages/"; //directory where images are present
    class ProductService{
        private ProductRepo $productRepo;
    
        public function __construct(){
            $this->productRepo = new ProductRepo();
        }

        //go to AddProduct in ProductRepository.php for details
        public function Insert(Product $p){
            if ($this->productRepo->AddProduct($p)){
                echo "Product added successfully! <br>";
            }
            else{
                echo "<br> Failed to add product. <br>";
            }
        }

        //go to RemoveProduct in ProductRepository.php for details
        public function Delete(int $ProductID){
            if ($this->productRepo->RemoveProduct($ProductID)){
                echo "Product deleted successfully! <br>";
            }
            else{
                echo "Failed to delete product. <br>";
            }
        }

        //go to UpdateProduct in ProductRepository.php for details
        public function Update(Product $p, int $ProductID){
            if ($this->productRepo->UpdateProduct($p, $ProductID)){
                echo "Product updated successfully! <br>";
            }
            else{
                echo "Failed to update product. <br>";
            }
        }

        //go to SearchProduct in ProductRepository.php for details
        public function Search(string $ProductName){
            $result = $this->productRepo->SearchProduct($ProductName);
            if ($result){
                echo "<h2>Product List</h2>";
                echo "<table border='1'>";
                echo "<tr><th>Product ID</th><th>Product Name</th><th>Price</th><th>Quantity</th><th>Image</th><th>Sizes</th><th>Colours</th><th>Product Description</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row["ProductID"]."</td>";
                    echo "<td>".$row["ProductName"]."</td>";
                    echo "<td>".$row["Price"]."tk</td>";
                    echo "<td>".$row["Quantity"]."</td>";
                    $image = $GLOBALS['mainImageDIR'].$row["Image"];
                    echo 
                        "<td>".
                            '<img src="'.$image.'" height = "100"/><br />'  
                        ."</td>"
                    ;
                    $sizeresult = $this->productRepo->getProductSizes($row["ProductID"]);
                    if(!$sizeresult){
                        echo "Failed to get product colours. <br>";
                    }
                    else{
                        $sizestring = "";
                        while($sizerow = $sizeresult->fetch_assoc()){
                            $sizestring = $sizestring . $sizerow["size"] . "<br>";
                        }
                        echo "<td>".$sizestring."</td>";
                    }

                    $colourresult = $this->productRepo->getProductColours($row["ProductID"]);
                    if(!$colourresult){
                        echo "Failed to get product colours. <br>";
                    }
                    else{
                        $colourstring = "";
                        while($colourrow = $colourresult->fetch_assoc()){
                            $colourstring = $colourstring . $colourrow["Colour"] . "<br>";
                        }
                        echo "<td>".$colourstring."</td>";
                    }
                    echo "<td>".$row["ProductDesc"]."</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            else{
                echo "No product found. <br>";
            }
        }

        //go to getAllProducts in ProductRepository.php for details
        public function GetAll(){
            $result = $this->productRepo->getAllProducts();
            if ($result){

                //added html code through PHP's echo function
                echo "<h2>Product List</h2>";
                echo "<table border='1'>";
                echo "<tr><th>Product ID</th><th>Product Name</th><th>Price</th><th>Quantity</th><th>Image</th><th>Sizes</th><th>Colours</th><th>Product Description</th></tr>";
                
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row["ProductID"]."</td>";
                    echo "<td>".$row["ProductName"]."</td>";
                    echo "<td>".$row["Price"]."tk</td>";
                    echo "<td>".$row["Quantity"]."</td>";
                    $image = $GLOBALS['mainImageDIR'].$row["Image"];
                    echo 
                        "<td>".
                            '<img src="'.$image.'" height = "100"/><br />'  
                        ."</td>"
                    ;

                    $sizeresult = $this->productRepo->getProductSizes($row["ProductID"]);
                    if(!$sizeresult){
                        echo "Failed to get product colours. <br>";
                    }
                    else{
                        $sizestring = "";
                        while($sizerow = $sizeresult->fetch_assoc()){
                            $sizestring = $sizestring . $sizerow["size"] . "<br>";
                        }
                        echo "<td>".$sizestring."</td>";
                    }

                    $colourresult = $this->productRepo->getProductColours($row["ProductID"]);
                    if(!$colourresult){
                        echo "Failed to get product colours. <br>";
                    }
                    else{
                        $colourstring = "";
                        while($colourrow = $colourresult->fetch_assoc()){
                            $colourstring = $colourstring . $colourrow["Colour"] . "<br>";
                        }
                        echo "<td>".$colourstring."</td>";
                    }
                    echo "<td>".$row["ProductDesc"]."</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            else{
                echo "No products available. <br>";
            }
        }

    }
?>