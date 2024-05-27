<?php
    class Order{
        private int $orderID;
        private string $status;
        private int $cartID;
        private int $customerID;
        private int $couponID;
        private float $totalPrice;
        private string $date;
        private string $address;
        private string $payment_type;

        public function __construct()
        {
                
        }

        public function getOrderID()
        {
                return $this->orderID;
        }
        public function setOrderID($orderID)
        {
                $this->orderID = $orderID;

                return $this;
        }

        public function getStatus()
        {
                return $this->status;
        }

        public function setStatus($status)
        {
                $this->status = $status;

                return $this;
        }


        public function getCartID()
        {
                return $this->cartID;
        }


        public function setCartID($cartID)
        {
                $this->cartID = $cartID;

                return $this;
        }


        public function getCustomerID()
        {
                return $this->customerID;
        }


        public function setCustomerID($customerID)
        {
                $this->customerID = $customerID;

                return $this;
        }


        public function getCouponID()
        {
                return $this->couponID;
        }


        public function setCouponID($couponID)
        {
                $this->couponID = $couponID;

                return $this;
        }

        public function getDate()
        {
                return $this->date;
        }


        public function setDate($date)
        {
                $this->date = $date;

                return $this;
        }

        public function getAddress()
        {
                return $this->address;
        }


        public function setAddress($address)
        {
                $this->address = $address;

                return $this;
        }

        public function getPayment_type()
        {
                return $this->payment_type;
        }

        public function setPayment_type($payment_type)
        {
                $this->payment_type = $payment_type;

                return $this;
        }

        public static function create() : Order {
            return new Order();
        }

        /**
         * Get the value of totalPrice
         */ 
        public function getTotalPrice()
        {
                return $this->totalPrice;
        }

        /**
         * Set the value of totalPrice
         *
         * @return  self
         */ 
        public function setTotalPrice($totalPrice)
        {
                $this->totalPrice = $totalPrice;

                return $this;
        }
    }
?>