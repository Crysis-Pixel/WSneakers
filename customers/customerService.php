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
            echo "Failed to register in database! <br>";
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
    public function GetAllCustomers()
    {
        $customerRepo = CustomerRepo::getInstance();
        return $customerRepo->GetAllCustomers();
    }
    public static function getInstance(): CustomerService
    {
        if (!isset(CustomerService::$instance)) {
            CustomerService::$instance = new CustomerService();
        }

        return CustomerService::$instance;
    }
    public function FindByCustomerID($customerID): Customer
    {
        $customerRepo = CustomerRepo::getInstance();
        $customer = $customerRepo->FindByCustomerID($customerID);

        if ($customer != null)
        {
            return $customer;
        }
        
        echo "No ID Found!";
        return null;
    }
    public function Update(Customer $customer): bool
    {
        $customerRepo = CustomerRepo::getInstance();
        $isSuccessful = $customerRepo->Update($customer);

        if ($isSuccessful)
        {
            echo "Update Successful";
            return true;
        }
        
        echo "Update Failed";
        return false;
    }
    public function Delete($customerID): bool
    {
        $customerRepo = CustomerRepo::getInstance();
        $customer = $customerRepo->FindByCustomerID($customerID);

        if ($customer != null)
        {
            $isSuccessful = $customerRepo->Delete($customer->getCustomerID());
            if ($isSuccessful)
            {
                echo "Delete Successful";
                return true;
            }
        }
        echo "Delete Failed";
        return false;
    }
    public function Print(Customer $customer)
    {
        echo $customer->getUsername();
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
