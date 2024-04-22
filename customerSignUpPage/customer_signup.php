<?php
    include("../header.html");
    include("./customer_signup.html");
    include("../database/db.php");   
    include("../customers/customer.php");
    include("../customers/customerService.php");
    include("../customers/customerRepository.php");
    session_start();
    if (isset($_POST["signupButton"]))
    {
        if(!empty($_POST["username"]) && !empty($_POST["password"]) && 
        !empty($_POST["phone"]) && !empty($_POST["birthdate"]) && 
        !empty($_POST["address"]))
        {
            $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
            $phone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_SPECIAL_CHARS);
            $birthDate = filter_input(INPUT_POST, "birthdate", FILTER_SANITIZE_SPECIAL_CHARS);
            $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS);
            $customer = Customer::create()->setUsername($username)
                ->setPassword(password_hash($password, PASSWORD_DEFAULT))
                ->setPhone($phone)
                ->setBirthdate($birthDate)
                ->setAddress($address);
            
            $isSuccessful = CustomerService::getInstance()->Insert($customer);

            if($isSuccessful)
            {
                $_SESSION["Username"] = $username;
                $_SESSION["Password"] = $password;
                $_SESSION["Phone"] = $phone;
                $_SESSION["Birthdate"] = $birthdate;
                $_SESSION["Address"] = $address;

                header("location: ../customerProfile/customerProfile.php");
            }

        }
    }
?>