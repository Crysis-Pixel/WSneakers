<?php
    class Reviews{
        private int $reviewID = 0;
        private string $text;
        private int $productID;
        private int $customerID;
    
        public function __construct(string $text, int $productID, int $customerID){
            $this->text=$text;
            $this->productID=$productID;
            $this->customerID=$customerID;
        }

        public function setReviewID(int $reviewID) {
            $this->reviewID = $reviewID;
        }
        public function setCustomerID(int $customerID) {
            $this->customerID = $customerID;
        }
        public function setProductID(int $productID) {
            $this->productID = $productID;
        }
        public function setText(string $text) {
            $this->text = $text;
        }

    
        public function getReviewID() : int {
            return $this->reviewID;
        }
        public function getCustomerID() : int {
            return $this->customerID;
        }
        public function getProductID(){
            return $this->productID;
        }
        public function getText(){
            return $this->text;
        }
    }
?>