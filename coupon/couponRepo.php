<?php
    class CouponRepo{

        public static $instance;

        public function checkAvailable($code){
            $con = Db::getInstance()->getConnection();

            $sql = "SELECT COUNT(c.CouponID) AS `Count` 
                    FROM coupons as c 
                    INNER JOIN seller s ON s.SellerID=c.SellerID 
                    WHERE c.Name='$code';";

            $result = mysqli_query($con, $sql);

            if ($result){
                $row = $result->fetch_assoc();
                if ($row["Count"] > 0){
                    return true;
                }
                else return false;
            }
            else return false;
        }

        public function getPercentage($code){

            if (!$this->checkAvailable($code)) return false;

            $con = Db::getInstance()->getConnection();

            $sql = "SELECT c.Percentage_Discount 
                    FROM coupons as c 
                    WHERE c.Name='$code';";

            $result = mysqli_query($con, $sql);

            if ($result){
                $row = $result->fetch_assoc();
                    return $row["Percentage_Discount"];
            }
            else return false;
        }

        public static function getInstance(): CouponRepo
        {
            if (!isset(CouponRepo::$instance)) {
                CouponRepo::$instance = new CouponRepo();
            }

            return CouponRepo::$instance;
        }

        public static function getCoupons($seller){
            $con = Db::getInstance()->getConnection();

            $sql = "SELECT c.CouponID,c.Name,c.Percentage_Discount
                    FROM coupons as c 
                    INNER JOIN seller s ON s.SellerID=c.SellerID 
                    WHERE s.Username LIKE '$seller%';";

            $result = mysqli_query($con, $sql);

            if ($result) return $result;
            else return false;
        }

        public static function DeleteCoupon($couponID){
            $con = Db::getInstance()->getConnection();

            $sql = "DELETE FROM coupons WHERE CouponID = '$couponID';";

            $result = mysqli_query($con, $sql);

            if ($result) return $result;
            else return false;
        }

        public static function UpdateCoupon($couponID, $code, $percentage){
            $con = Db::getInstance()->getConnection();

            $sql = "UPDATE coupons SET
                    Name = '$code',
                    Percentage_Discount = '$percentage'
                    WHERE CouponID = '$couponID'";

            $result = mysqli_query($con, $sql);

            if ($result) return $result;
            else return false;
        }

        public static function AddCoupon($code, $percentage){
            $con = Db::getInstance()->getConnection();

            $sellerID = $_SESSION['SellerID'];

            $sql = "INSERT INTO coupons(Name, Percentage_Discount, SellerID)
                    VALUES('$code','$percentage','$sellerID')";

            $result = mysqli_query($con, $sql);

            if ($result) return $result;
            else return false;
        }
    }

    
?>