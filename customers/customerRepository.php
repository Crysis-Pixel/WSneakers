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

  public function Insert(Customer $customer): bool
  {
    $con = Db::getInstance()->getConnection();

    $username = $customer->getUsername();
    $password = $customer->getPassword();
    $phone = $customer->getPhone();
    $birthdate = $customer->getBirthdate();
    $address = $customer->getAddress();

    $isSuccessful = mysqli_query($con, "INSERT INTO customer(Username, Password, Phone, Birthdate, Address) VALUES
    ('$username', '$password', '$phone', 
    '$birthdate', '$address')" );
    return $isSuccessful;
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
  public function FindByCustomerID($customerID): ?Customer
  {
    $con = Db::getInstance()->getConnection();
    $result = mysqli_query($con, "SELECT * FROM customer WHERE `CustomerID` = '$customerID' LIMIT 1");

    //echo mysqli_error($con);

    if (mysqli_num_rows($result) > 0) 
    {
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
  public function Update(Customer $customer): bool
  {
    $con = Db::getInstance()->getConnection();
    echo mysqli_error($con);
    $customerID = $customer->getCustomerID();
    $username = $customer->getUsername();
    $password = $customer->getPassword();
    $phone = $customer->getPhone();
    $birthdate = $customer->getBirthdate();
    $address = $customer->getAddress();

    $isSuccessful = mysqli_query($con, "UPDATE customer SET CustomerID = '$customerID', Username = '$username', 
    Password = '$password', Phone = '$phone', Birthdate = '$birthdate', Address = '$address' WHERE CustomerID = '$customerID'");
    return $isSuccessful;
  }
  public function Delete($customerID): bool
  {
    $con = Db::getInstance()->getConnection();

    $isSuccessful = mysqli_query($con, "DELETE FROM customer WHERE CustomerID = '$customerID'");
    return $isSuccessful;
  }
  public static function getInstance(): CustomerRepo
  {
    if (!isset(CustomerRepo::$instance)) {
      CustomerRepo::$instance = new CustomerRepo();
    }

    return CustomerRepo::$instance;
  }
}
