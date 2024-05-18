<?php
class Cart{
    private int $cartID;
    private int $customerID;
    private array $productIDs;

    public function setCartID(int $cartID) {
        $this->cartID = $cartID;
        return $this;
    }

    public function setCustomerID(int $customerID) {
        $this->customerID = $customerID;
        return $this;
    }

    public function addProductID(int $productID)
    {
        if(!isset($this->productIDs)){
            $this->productIDs = array();
        }
        array_push($this->productIDs, $productID);

        return $this;
    }

    public function getCartID() : int {
        return $this->cartID;
    }

    public function getCustomerID() : int {
        return $this->customerID;
    }
    public function getProductIDs()
    {
        return $this->productIDs;
    }
    public static function create() : Cart {
        
        return new Cart();
    }
}
?>