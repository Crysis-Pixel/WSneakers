<?php
class Customer
{
    private int $customerID;
    private string $username = "";
    private string $password = "";
    private string $phone = "";
    private string $birthdate = "";
    private int $orderID;
    private int $trxID;
    private string $address = "";
    private int $reportID;
    private int $reviewID;

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

    public function setOrderID(string $orderID) : Customer {
        $this->orderID = $orderID;

        return $this;
    }

    public function setTrxID(string $trxID) : Customer {
        $this->trxID = $trxID;

        return $this;
    }

    public function setAddress(string $address) : Customer {
        $this->address = $address;

        return $this;
    }

    public function setReportID(string $reportID) : Customer {
        $this->reportID = $reportID;

        return $this;
    }

    public function setReviewID(string $reviewID) : Customer {
        $this->reviewID = $reviewID;

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

    public function getOrderID() : int {
        return $this->orderID;
    }

    public function getTrxID() : int {
        return $this->trxID;
    }

    public function getAddress() : string {
        return $this->address;
    }

    public function getReportID() : int {
        return $this->reportID;
    }

    public function getReviewID() : int {
        return $this->reviewID;
    }
    
    public static function create() : Customer {
        return new Customer();
    }
}
?>
