<?php
class Cart{
    private int $cartID;
    private int $customerID;
    private array $productIDs;
    private array $quantity;
    private array $priceOfProduct;
    private array $productName;
    private float $totalPrice;

    public function __construct() {
        $this->productIDs = array();
        $this->quantity = array();
        $this->priceOfProduct = array();
        $this->productName = array();
    }
    public function setCartID(int $cartID) {
        $this->cartID = $cartID;
        return $this;
    }

    public function setCustomerID(int $customerID) {
        $this->customerID = $customerID;
        return $this;
    }
    
    public function addProductID(int $productID, $quantity)
    {
        if(array_search($productID, $this->productIDs,false) !== false)
        {
            $this->quantity[$productID] = $this->quantity[$productID] + $quantity;
        }else
        {
            array_push($this->productIDs, $productID);
            sort($this->productIDs);
            $this->quantity[$productID] = $quantity;
        }
        return $this;
    }
    public function retrieveOldCart($customerID)
    {
        $cartRepo = CartRepo::getInstance();
        $isCartExist = $cartRepo->checkCustomerHasCart($customerID);
        if($isCartExist)
        {
            $this->cartID = $cartRepo->getCartID($customerID);
            $result = $cartRepo->getCartProduct($this->cartID);
            while($row = $result->fetch_assoc())
            {
                array_push($this->productIDs, $row["ProductID"]);
                $this->quantity[$row["ProductID"]] = $row["Quantity"];
            }
        }
        return $this;
    }
    public function setPriceOfProduct(array $prices)
    {
        $this->priceOfProduct = $prices;
    }
    public function setProductName(array $names)
    {
        $this->productName = $names;
    }
    public function setTotalPrice(int $total)
    {
        $this->totalPrice = $total;
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
    public function getQuantity(){
        return $this->quantity;
    }
    public function getPriceOfProduct()
    {
        return $this->priceOfProduct;
    }
    public function getProductName()
    {
        return $this->productName;
    }
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }
    public static function create() : Cart {
        
        return new Cart();
    }
}
?>