<?php
class CustomerRepo
{
  public static $instance;

  public function GetAllCustomers(): void
  {
    $con = Db::getInstance()->getConnection();
    $result = mysqli_query($con, "Select * FROM customer");

  }

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
