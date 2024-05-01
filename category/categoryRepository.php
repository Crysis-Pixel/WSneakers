<?php
    include("category.php");
    
    class CategoryRepo{

        public function getCategory($CategoryID){
            try{
                $con = Db::getInstance()->getConnection();
                $result = mysqli_query($con,"select * FROM category WHERE CategoryID = {$CategoryID};");
                return $result;
            }
            catch(Exception $e){
                echo "Error: " . $e->getMessage() . "<br>";
                return null;
            }
        }

        public function getCategoryCount(){
            try{
                $con = Db::getInstance()->getConnection();
                $result = mysqli_query($con,"select count(1) FROM category;");
                $row = mysqli_fetch_array($result);
                return $row[0];
            }
            catch(Exception $e){
                echo "Error: " . $e->getMessage() . "<br>";
                return null;
            }
        }

        public function getAllCategories(){
            try{
                $con = Db::getInstance()->getConnection();
                $result = mysqli_query($con, "Select * FROM category;");
                return $result;
            }
            catch(Exception $e){
                echo "Error: " . $e->getMessage() . "<br>";
                return null;
            }
        }

        public function SearchCategory(String $Type){
            try{
                $con = Db::getInstance()->getConnection();
                $result = mysqli_query($con, "Select * FROM category WHERE Type LIKE '%{$Type}%'");
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

        public function AddCategory(Category $c) : bool{
            $con = Db::getInstance()->getConnection();
            
            try{
                $Type = $c->getType();
                $result = mysqli_query($con, "INSERT INTO category(Type) VALUES('$Type')");
                return true;
            }
            catch(Exception $e){
                echo "Error: " . $e->getMessage() . "<br>";
                return false;
            }
        }

        public function RemoveCategory(int $CategoryID) : bool{
            try{
                $con = Db::getInstance()->getConnection();
                $result = mysqli_query($con, "DELETE FROM category WHERE CategoryID = {$CategoryID}");
                return true;
            }
            catch(Exception $e){
                echo "Error: " . $e->getMessage() . "<br>";
                return false;
            }
        }

        public function UpdateCategory(Category $c, int $CategoryID) : bool{

            $con = Db::getInstance()->getConnection();
    
            try{
                $Type = $c->getType();
                
                $result = mysqli_query($con, 
                "UPDATE category SET 
                Type = '$Type'
                WHERE CategoryID = {$CategoryID};");
                return true;
            }
            catch(Exception $e){
                echo "Error: " . $e->getMessage() . "<br>";
                return false;
            }
        }
    }
?>