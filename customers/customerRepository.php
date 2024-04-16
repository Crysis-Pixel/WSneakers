<?php
class CustomerRepo
{
  public static $instance;

  public function GetAllCustomers(): void
  {
    $con = Db::getInstance()->getConnection();
    $result = mysqli_query($con, "Select * FROM customer");

  }

  public function GetAllID()
  {
    $con = Db::getInstance()->getConnection();
    $result = mysqli_query($con, "Select customerID FROM customer");
    while($row = $result->fetch_assoc())
    {
      $customerID[] = $row["customerID"];
    }

    return $customerID;
  
  }

  public function GetAllUsername()
  {
    $con = Db::getInstance()->getConnection();
    $result = mysqli_query($con, "Select username FROM customer");
    while($row = $result->fetch_assoc())
    {
      $customerUsername[] = $row["username"];
    }

    return $customerUsername;
  
  }
  public function GetCustomerCount()
  {
    $con = Db::getInstance()->getConnection();
    $result = mysqli_query($con, "select customerID FROM customer");

    return mysqli_num_rows($result);
  
  }

  public function GetAllPassword()
  {
    $con = Db::getInstance()->getConnection();
    $result = mysqli_query($con, "Select password FROM customer");
    while($row = $result->fetch_assoc())
    {
      $customerPassword[] = $row["password"];
    }

    return $customerPassword;
  
  }
/*
  public function GetAllLoginCredentials():Customer
  {
    $con = Db::getInstance()->getConnection();
    //$numberOfCustomers = mysqli_query($con, "count(customerID) FROM customer");
    $result = mysqli_query($con, "Select customerID, username, password FROM customer");
    while($row = $result->fetch_assoc())
    {
      $customer[$row["customerID"]] = Customer::create()
          ->setUsername($row["username"])
          ->setPassword($row["password"]);          //This is hashed password.
    }

    return $customer;
  
  }
*/
  public function Insert(Customer $customer): Customer
  {
    $con = Db::getInstance()->getConnection();
    
    return $customer;
  }

  public function FindByUsername(Customer $customer): Customer
  {
    $con = Db::getInstance()->getConnection();
    $result = mysqli_query($con, "Select * FROM customer where username =" . $customer->getUsername());

    if (mysqli_num_rows($result) > 0) {
      // output data of each row
      if ($row = mysqli_fetch_assoc($result)) {
        $customer = Customer::create()
          ->setUsername($row["Username"])
          ->setPassword($row["Password"])
          ->setAddress($row["Address"])
          ->setPhone($row["Phone"]);
        return $customer;
      }
    } else {
      echo "0 results";
      return null;
    }
  }

  public static function getInstance(): CustomerRepo
  {
    if (!isset(CustomerRepo::$instance)) {
      CustomerRepo::$instance = new CustomerRepo();
    }

    return CustomerRepo::$instance;
  }
}
