<?php
    include("reviews.php");
    class ReviewsRepo{
        public function getReview(int $reviewID){
            try{
                $con = Db::getInstance()->getConnection();
                $result = mysqli_query($con,"select * FROM reviews WHERE ReviewID = {$reviewID}");
                return $result;
            }
            catch(Exception $e){
                echo "Error: " . $e->getMessage() . "<br>";
                return null;
            }
        }
    
        public function getReviewCount(){
            try{
                $con = Db::getInstance()->getConnection();
                $result = mysqli_query($con,"select count(1) FROM reviews");
                $row = mysqli_fetch_array($result);
                return $row[0];
            }
            catch(Exception $e){
                echo "Error: " . $e->getMessage() . "<br>";
                return null;
            }
        }

        public function SearchReview(String $CustomerUsername, string $productName){
            try{
                $con = Db::getInstance()->getConnection();
                $result = mysqli_query($con, "SELECT r.ReviewID, c.CustomerID, c.Username, p.ProductID, p.ProductName, r.Text
                FROM reviews r
                INNER JOIN customer c ON c.CustomerID=r.CustomerID
                INNER JOIN product p ON p.ProductID=r.ProductID
                WHERE p.ProductName LIKE '$productName%' and c.Username LIKE '$CustomerUsername%';");
                return $result;
            }
            catch(Exception $e){
                echo "Error: " . $e->getMessage() . "<br>";
                return false;
            }
        }

        public function AddReview(Reviews $r) : bool{
            $con = Db::getInstance()->getConnection();
            
            try{
                $text=$r->getText();
                $customerID=$r->getCustomerID();
                $productID=$r->getProductID();
                $result = mysqli_query($con, "INSERT INTO reviews (`Text`, ProductID, CustomerID)
                VALUES('$text','$productID','$customerID');");
                return true;
            }
            catch(Exception $e){
                echo "Error: " . $e->getMessage() . "<br>";
                return false;
            }
        }

        public function DeleteReview(int $reviewID) : bool{
            $con = Db::getInstance()->getConnection();
            try{
                $con = Db::getInstance()->getConnection();
                $result = mysqli_query($con, "DELETE FROM reviews WHERE ReviewID = {$reviewID}");
                return true;
            }
            catch(Exception $e){
                echo "Error: " . $e->getMessage() . "<br>";
                return false;
            }
        }

        public function UpdateReview(int $ReviewID, Reviews $r) : bool{

            $con = Db::getInstance()->getConnection();
    
            try{
                $text=$r->getText();
                $result = mysqli_query($con, 
                "UPDATE reviews SET 
                text = '$text'
                WHERE ReviewID = $ReviewID;");
                return true;
            }
            catch(Exception $e){
                echo "Error: " . $e->getMessage() . "<br>";
                return false;
            }
        }
    }
?>