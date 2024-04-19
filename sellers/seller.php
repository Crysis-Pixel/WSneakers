<?php
class Seller
{
  private int $sellerID;
  private string $phone;
  private string $username;
  private string $password;

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

  public static function create() : Seller 
  {
    return new Seller();
  }
}
