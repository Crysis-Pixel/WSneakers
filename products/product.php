<?php
class Product
{
    //self explanatory class with getters and setters
    //follows attributes in the products table
    
    private int $ProductID = 0;
    private string $ProductName;
    private float $Price;
    private int $Quantity;
    private $Colours;
    private string $Image;
    private $Sizes;
    private string $Description;

    public function __construct(string $ProductName, float $Price, int $Quantity, array $Colours, $Image, array $Sizes, string $Description)
    {
        //$this->ProductID = $ProductID;
        $this->ProductName = $ProductName;
        $this->Price = $Price;
        $this->Quantity = $Quantity;
        $this->Colours = $Colours;
        $this->Image = $Image;
        $this->Sizes = $Sizes;
        $this->Description = $Description;

    }

    public function setProductID(string $ProductID) {
        $this->ProductID = $ProductID;

    }

    public function setProductName(string $ProductName) {
        $this->ProductName = $ProductName;

    }


    public function setPrice(string $Price) {
        $this->Price = $Price;

    }
    public function setQuantity(string $Quantity) {
        $this->Quantity = $Quantity;

    }

    public function setColours(string $Colours) {
        $this->Colours = $Colours;

    }

    public function setImage(string $Image) {
        $this->Image = $Image;

    }

    public function setSizes(string $Sizes) {
        $this->Sizes = $Sizes;

    }

    public function setDesc(string $Desc) {
        $this->Description = $Desc;

    }

    public function getProductID() : int {
        return $this->ProductID;
    }

    public function getProductName() : string {
        return $this->ProductName;
    }

    public function getPrice() : float {
        return $this->Price;
    }
    public function getQuantity() : int {
        return $this->Quantity;
    }

    public function getColours(){
        return $this->Colours;
    }

    public function getImage() : string {
        return $this->Image;
    }

    public function getSizes(){
        return $this->Sizes;
    }

    public function getDesc() : string {
        return $this->Description;
    }
}
?>