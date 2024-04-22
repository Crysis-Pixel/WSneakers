<?php
class Customer
{
    private int $customerID;
    private string $username = "";
    private string $password = "";
    private string $phone = "";
    private string $birthdate = "";
    private string $address = "";

    public function setCustomerID(string $customerID) : Customer {
        $this->customerID = $customerID;

        return $this;
    }

    public function setUsername(string $username) : Customer {
        $this->username = $username;

        return $this;
    }
    public function setPassword(string $password) : Customer {
        $this->password = $password;

        return $this;
    }

    public function setPhone(string $phone) : Customer {
        $this->phone = $phone;

        return $this;
    }

    public function setBirthdate(string $birthdate) : Customer {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function setAddress(string $address) : Customer {
        $this->address = $address;

        return $this;
    }

    public function getCustomerID() : string {
        return $this->customerID;
    }

    public function getUsername() : string {
        return $this->username;
    }
    public function getPassword() : string {
        return $this->password;
    }

    public function getPhone() : string {
        return $this->phone;
    }

    public function getBirthdate() : string {
        return $this->birthdate;
    }

    public function getAddress() : string {
        return $this->address;
    }
    
    public static function create() : Customer {
        return new Customer();
    }
    
}
?>
