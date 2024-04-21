<?php
class CustomerService
{
    private CustomerRepo $customerRepo;
    private static $instance;

    private function __construct()
    {
        
    }

    public function Insert(Customer $customer):bool
    {
        $customerRepo = CustomerRepo::getInstance();
        $isSuccessful = $customerRepo->Insert($customer);
        if ($isSuccessful)
        {
            echo "Successfully Registered! <br>"; 
        } else
        {
            echo "Failed to access database! <br>";
        }
        return $isSuccessful;
    }

    public function Login($username, $password): ?Customer
    {
        $customerRepo = CustomerRepo::getInstance();
        $customer = $customerRepo->FindByUsername($username);

        if ($customer != null)
        {
            if ($username == $customer->getUsername()) {
                if (password_verify($password, $customer->getPassword())) {
                    echo "Logged IN";
                    return $customer;
                } else {
                    echo "Wrong Pass";
                    return null;
                }
            }
        }
        
        echo "No ID Found!";
        return null;
    }
    public static function getInstance(): CustomerService
    {
        if (!isset(CustomerService::$instance)) {
            CustomerService::$instance = new CustomerService();
        }

        return CustomerService::$instance;
    }
}
/*
    public function Login($username, $password): Customer
            {
                $customerRepo = CustomerRepo::getInstance();
                $customer = $customerRepo->FindByUsername($username);
                echo $customer->getUsername();
                
                if ($customer->getPassword() !== null)
                {
                    if (password_verify($password, $customer->getPassword()))
                    {
                        echo "Login Successful!";
                        //header("location: index.php");
                    } else
                    {
                        echo "Wrong Password!";
                    }
                }
                
                return $customer;
            }
    */
