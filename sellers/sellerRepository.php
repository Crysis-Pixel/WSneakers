<?php

class SellerRepo{
    //Function to get all sellers detail
    function getAllSellers()
    {
      $getAllSellers = "SELECT * FROM seller";

      $con = db::getInstance()->getConnection();

      $result = mysqli_query($con, $getAllSellers);

      return $result;

      while ($row = mysqli_fetch_assoc($result)) {
        echo '<br>';
        echo $row['SellerID'];
        echo $row['Username'];
        echo $row['Phone'];
      }
    }

    //Function to get all sellers ID
    function getAllSellersID()
    {
      $getAllSellersID = "SELECT SellerID FROM seller";

      $con = db::getInstance()->getConnection();

      $result = mysqli_query($con, $getAllSellersID);

      while ($row = mysqli_fetch_assoc($result)) {
        echo '<br>';
        echo $row['SellerID'];
      }
    }

    //Function to get sellers Username
    function getAllSellersUsername()
    {
      $getAllSellersUsername = "SELECT Username FROM seller";

      $con = db::getInstance()->getConnection();

      $result = mysqli_query($con, $getAllSellersUsername);

      while ($row = mysqli_fetch_assoc($result)) {
        echo '<br>';
        echo $row['Username'];
      }
    }

    //Function to get all sellers Phone
    function getAllSellersPhone()
    {
      $getAllSellersPhone = "SELECT Phone FROM seller";

      $con = db::getInstance()->getConnection();

      $result = mysqli_query($con, $getAllSellersPhone);

      while ($row = mysqli_fetch_assoc($result)) {
        echo '<br>';
        echo $row['Phone'];
      }
    }

    //Function to get all sellers Password Hashed
    function getAllSellersPassword()
    {
      $getAllSellersPassword = "SELECT Pwd FROM seller";

      $con = db::getInstance()->getConnection();
      $result = mysqli_query($con, $getAllSellersPassword);

      while ($row = mysqli_fetch_assoc($result)) {
        echo '<br>';
        echo $row['Pwd'] . '<br>';
      }
    }

    // Function to get the number of sellers
    function getSellersCount()
    {
      $getSellersCount = "SELECT COUNT(*) AS count FROM seller";

      $con = db::getInstance()->getConnection();
      $result = mysqli_query($con, $getSellersCount);

      $row = mysqli_fetch_assoc($result);
      echo $row['count'];
    }


    ///Added by Mostakim
    function getSellerbyID(int $SellerID){
      $getSellerIDQuery ="SELECT * FROM seller WHERE seller.SellerID = {$SellerID}";

      $con = db::getInstance()->getConnection();

      $result = mysqli_query($con, $getSellerIDQuery);

      if (mysqli_num_rows($result)==0){
        return false;
      }
      return $result;

    }

    function verifySeller(string $username, string $password){
      $verifySellerQuery ="SELECT * FROM seller WHERE seller.Username = '{$username}' AND seller.Pwd = '{$password}'";

      $con = db::getInstance()->getConnection();

      $result = mysqli_query($con, $verifySellerQuery);

      if (mysqli_num_rows($result)==0){
        return false;
      }
      return $result;
    }
    ///
  }