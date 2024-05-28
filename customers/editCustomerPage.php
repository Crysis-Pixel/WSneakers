<?php
session_start();
include("./customerSessionAccess.php");
include("../header.html");
include("../database/db.php");
include("./customer.php");
include("./customerService.php");
include("./customerRepository.php");
include("./editCustomerUI.php");

if (isset($_POST["editCustomer"])) {
    if (
        !empty($_POST["username"]) &&
        !empty($_POST["phone"]) && !empty($_POST["birthdate"]) &&
        !empty($_POST["address"])
    ) {
        $customerID = $_SESSION["CustomerID"];
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        if (!empty($_POST["password"])) {
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
            $password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $password = $_SESSION["editPassword"];
        }
        $phone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_SPECIAL_CHARS);
        $birthDate = filter_input(INPUT_POST, "birthdate", FILTER_SANITIZE_SPECIAL_CHARS);
        $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS);


        $isFound = CustomerService::getInstance()->FindByCustomerID($customerID);
        if ($isFound) {
            echo "Found! ";
            $newCustomer = Customer::create()
                ->setCustomerID($customerID)
                ->setUsername($username)
                ->setPassword($password)
                ->setPhone($phone)
                ->setBirthdate($birthDate)
                ->setAddress($address);

            echo $newCustomer->getUsername();
            $isSuccessful = CustomerService::getInstance()->Update($newCustomer);
            if ($isSuccessful) {
                echo "Successful ";
                $_SESSION["CustomerID"] = $newCustomer->getCustomerID();
                    $_SESSION["Username"] = $username;
                    $_SESSION["Password"] = $password;
                    $_SESSION["Phone"] = $newCustomer->getPhone();
                    $_SESSION["Birthdate"] = $newCustomer->getBirthdate();
                    $_SESSION["Address"] = $newCustomer->getAddress();
                header("location: ../customerProfile/customerProfile.php");
            }
        }
    } else {
        echo "Some Fields are empty!";
    }
}
