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

        public function Login($username, $passowrd): bool
        {
            $isFound = false;

            $customerRepo = CustomerRepo::getInstance();
            $customerCount = $customerRepo->GetCustomerCount();
            $customerUsernames = $customerRepo->GetAllUsername();
            $customerPasswords = $customerRepo->GetAllPassword();
            for($i = 1; $i < $customerCount; $i++)
            {
                $customers[$i] = Customer::create()
                ->setUsername($customerUsernames[$i])
                ->setPassword($customerPasswords[$i]);
            }
            
            foreach ($customers as $customer) {
                if ($username == $customer->getUsername() && password_verify($passowrd, $customer->getPassword()))
                {
                    $isFound = true;
                    return $isFound;
                }
            }

            return false;
            
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
