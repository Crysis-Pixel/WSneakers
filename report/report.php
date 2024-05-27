<?php
  class Report{
    
    public function sendReport(array $_POSTarr, array $_SESSIONarr): bool{

      $con = db::getInstance()->getConnection();
      $productID = $_POSTarr['product_id'];
      $customerID = $_SESSIONarr['CustomerID'];
      $sellerID = $_POSTarr['seller_id'];
      $reportText = $_POSTarr['reportText'];

      $sql = "INSERT INTO report (Text, CustomerID, ProductID, SellerID) 
      VALUES ('$reportText', '$customerID', '$productID', '$sellerID')";

      $result = mysqli_query($con, $sql);

      if ($result) return true;
      else return false;
    }

  }
?>
