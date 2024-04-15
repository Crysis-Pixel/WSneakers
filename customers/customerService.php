<?php
    class CustomerService
    {
        private CustomerRepo $customerRepo;
        private static $instance;

        private function __construct() {
            $this->customerRepo = new CustomerRepo();
        }

        public function Insert(Customer $customer)
        {
            $customerRepo = $this->customerRepo->Insert($customer);
        }

        public function Login($customer)
        {
            $customerRepo = $this->customerRepo->Insert($customer);
        }



        public static function getInstance(): CustomerService
        {
            if (!isset(CustomerService::$instance))
            {
                CustomerService::$instance = new CustomerService();
            }

            return CustomerService::$instance;
        }
    }
?>
