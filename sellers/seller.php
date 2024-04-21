<?php
class Seller
{
  private int $sellerID = 0;
  private string $phone;
  private string $username;
  private string $password;

  //Grabbing the data that the user submitted using the sign up form and assigning it into the properties in here
  public function __construct($phone, $username, $password) 
  { 
    $this->$phone = $phone;
    $this->$username = $username;
    $this->$password = $password;
  }

  public function setSellerID(int $sellerID): Seller
  {
    $this->sellerID = $sellerID;
    return $this;
  }
  
  public function getSellerID(): int
  {
    return $this->sellerID;
  }

  public function setPhone(string $phone): Seller
  {
    $this->phone = $phone;
    return $this;
  }
  
  public function getphone(): string
  {
    return $this->phone;
  }

  public function setUsername(string $username): Seller
  {
    $this->username = $username;
    return $this;
  }
  
  public function getUsername(): string
  {
    return $this->username;
  }

  public function setPassword(string $password): Seller
  {
    $this->password = $password;
    return $this;
  }

  public function getPassword(): string
  {
    return $this->password;
  }
}
