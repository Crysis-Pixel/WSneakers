
<?php
    //a lot of help taken from customer files to match code
    //contains all the code to follow basic funtionalities: Create, Read, Update, Delete
    //Create - Insert function
    //Read - Search and getAll function
    //Update - Update function
    //Delete - Delete function

    include("productRepository.php");
    
    class ProductService{
        private ProductRepo $productRepo;
        public function __construct(){
            $this->productRepo = new ProductRepo();
        }

        public function UpdateProductQuantity($productID, $quantity){
            if ($this->productRepo->UpdateProductQuantity($productID, $quantity)){
                echo "<br> Quantity updated successfully! <br>";
            }
            else{
                echo "<br> Failed to update quantity. <br>";
            }
        }

        public function Insert(Product $p){
            if ($this->productRepo->AddProduct($p)){
                echo "Product added successfully! <br>";
            }
            else{
                echo "<br> Failed to add product. <br>";
            }
        }

        public function DeleteProduct(int $ProductID){
            if ($this->productRepo->RemoveProduct($ProductID)){
                echo "Product deleted successfully! <br>";
            }
            else{
                echo "Failed to delete product. <br>";
            }
        }

        //go to RemoveProduct in ProductRepository.php for details
        public function DeleteProductColour(int $ProductID, string $colour){
            if ($this->productRepo->DeleteProductColour($ProductID, $colour)){
                echo "<h3>Product deleted successfully! </h3><br>";
            }
            else{
                echo "<h3>Failed to delete product colour. </h3><br>";
            }
        }

        public function DeleteProductSize(int $ProductID, int $size){
            if ($this->productRepo->DeleteProductSize($ProductID, $size)){
                echo "Product deleted successfully! <br>";
            }
            else{
                echo "Failed to delete product size. <br>";
            }
        }

        //go to UpdateProduct in ProductRepository.php for details
        public function UpdateProduct(Product $p, int $ProductID){
            if ($this->productRepo->UpdateProduct($p, $ProductID)){
                echo "Product updated successfully! <br>";
            }
            else{
                echo "Failed to update product. <br>";
            }
        }

        public function AddProductSize(int $ProductID, int $size){
            if ($this->productRepo->AddProductSize($ProductID, $size)){
                echo "Product updated successfully! <br>";
            }
            else{
                echo "Failed to update product. <br>";
            }
        }

        public function AddProductColour(int $ProductID, string $colour){
            if ($this->productRepo->AddProductColour($ProductID, $colour)){
                echo "Product updated successfully! <br>";
            }
            else{
                echo "Failed to update product. <br>";
            }
        }

        public function UpdateProductColour(Product $p, int $ProductID){
            if ($this->productRepo->UpdateProduct($p, $ProductID)){
                echo "Product updated successfully! <br>";
            }
            else{
                echo "Failed to update product. <br>";
            }
        }

        //go to SearchProduct in ProductRepository.php for details
        public function Search(string $ProductName, int $size, string $colour, string $category, string $brand){
            $result = $this->productRepo->SearchProduct($ProductName, $size, $colour, $category, $brand);
            return $result;
        }

        //go to SearchProduct in ProductRepository.php for details
        public function SearchofSeller(string $ProductName, int $size, string $colour, string $category, string $brand, string $seller){
            $result = $this->productRepo->SearchProductofSeller($ProductName, $size, $colour, $category, $brand, $seller);
            return $result;
        }

        //go to getAllProducts in ProductRepository.php for details
        public function GetAllProducts(){
            $result = $this->productRepo->getAllProducts();
            return $result;
        }

        public function GetAllProductColours(int $ProductID){
            $result = $this->productRepo->getProductColours($ProductID);
            return $result;
        }

        public function GetAllProductSizes(int $ProductID){
            $result = $this->productRepo->getProductSizes($ProductID);
            return $result;
        }

        public function GetAllDistinctColours(){
            $result = $this->productRepo->GetAllDistinctColours();
            return $result;
        }

        public function GetAllDistinctSizes(){
            $result = $this->productRepo->GetAllDistinctSizes();
            return $result;
        }

        public function GetProductCount(){
            return $this->productRepo->getProductCount();
        }

        public function GetProduct($productID){
            return $this->productRepo->getProduct($productID);
        }

        public function GetLastID(){
            return $this->productRepo->getLastID();
        }
    }

?>