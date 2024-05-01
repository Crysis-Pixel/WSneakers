<?php
    include("brand.php");
    
    class BrandRepo{

        public function getBrand(int $BrandID){
            try{
                $con = Db::getInstance()->getConnection();
                $result = mysqli_query($con,"select * FROM brand WHERE BrandID = {$BrandID}");
                return $result;
            }
            catch(Exception $e){
                echo "Error getBrand: " . $e->getMessage() . "<br>";
                return null;
            }
        }

        public function getBrandCount(){
            try{
                $con = Db::getInstance()->getConnection();
                $result = mysqli_query($con,"select count(1) FROM brand");
                $row = mysqli_fetch_array($result);
                return $row[0];
            }
            catch(Exception $e){
                echo "Error: " . $e->getMessage() . "<br>";
                return null;
            }
        }

        public function getAllBrands(){
            try{
                $con = Db::getInstance()->getConnection();
                $result = mysqli_query($con, "Select * FROM brand");
                return $result;
            }
            catch(Exception $e){
                echo "Error: " . $e->getMessage() . "<br>";
                return null;
            }
        }

        public function SearchBrand(String $BrandName){
            try{
                $con = Db::getInstance()->getConnection();
                $result = mysqli_query($con, "Select * FROM brand WHERE Name LIKE '%{$BrandName}%'");
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

        public function AddBrand(Brand $b) : bool{
            $con = Db::getInstance()->getConnection();
            
            try{
                $Name = $b->getName();
                $result = mysqli_query($con, "INSERT INTO brand(Name) VALUES('$Name')");
                return true;
            }
            catch(Exception $e){
                echo "Error: " . $e->getMessage() . "<br>";
                return false;
            }
        }

        public function RemoveBrand(int $BrandID) : bool{
            try{
                $con = Db::getInstance()->getConnection();
                $result = mysqli_query($con, "DELETE FROM brand WHERE BrandID = {$BrandID}");
                return true;
            }
            catch(Exception $e){
                echo "Error: " . $e->getMessage() . "<br>";
                return false;
            }
        }

        public function UpdateBrand(Brand $b, int $BrandID) : bool{

            $con = Db::getInstance()->getConnection();
    
            try{
                $Name = $b->getName();
                
                $result = mysqli_query($con, 
                "UPDATE brand SET 
                Name = '$Name'
                WHERE BrandID = {$BrandID};");
                return true;
            }
            catch(Exception $e){
                echo "Error: " . $e->getMessage() . "<br>";
                return false;
            }
        }
    }
?>