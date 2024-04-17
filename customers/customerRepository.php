<?php
class CustomerRepo
{
  public static $instance;

  public function GetAllCustomers()
  {
    $con = Db::getInstance()->getConnection();
    $result = mysqli_query($con, "Select * FROM customer");
    return $result;
  }

  public function GetAllID()
  {
    $con = Db::getInstance()->getConnection();
    $result = mysqli_query($con, "Select CustomerID FROM customer");
    while ($row = $result->fetch_assoc()) {
      $customerID[] = $row["CustomerID"];
    }

    return $customerID;
  }

  public function GetAllUsername()
  {
    $con = Db::getInstance()->getConnection();
    $result = mysqli_query($con, "Select Username FROM customer");
    while ($row = $result->fetch_assoc()) {
      $customerUsername[] = $row["Username"];
    }

    return $customerUsername;
  }
  public function GetCustomerCount()
  {
    $con = Db::getInstance()->getConnection();
    $result = mysqli_query($con, "select CustomerID FROM customer");

    return mysqli_num_rows($result);
  }

  public function GetAllPassword()
  {
    $con = Db::getInstance()->getConnection();
    $result = mysqli_query($con, "Select Password FROM customer");
    while ($row = $result->fetch_assoc()) {
      $customerPassword[] = $row["Password"];
    }

    return $customerPassword;
  }

  public function Insert(Customer $customer): Customer
  {
    $con = Db::getInstance()->getConnection();

    return $customer;
  }

  public function FindByUsername($username): ?Customer
  {
    $con = Db::getInstance()->getConnection();
    $result = mysqli_query($con, "SELECT * FROM customer WHERE `Username` = '$username' LIMIT 1");

    //echo mysqli_error($con);

    if (mysqli_num_rows($result) > 0) {
      // output data of each row
      if ($row = mysqli_fetch_assoc($result)) {
        $customer = Customer::create()
          ->setCustomerID($row["CustomerID"])
          ->setUsername($row["Username"])
          ->setPassword($row["Password"])
          ->setAddress($row["Address"])
          ->setPhone($row["Phone"]);
        return $customer;
      }
    } else {
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
