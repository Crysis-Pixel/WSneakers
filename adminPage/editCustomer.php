<?php
session_start();
include("./adminSessionAccess.php");
include("../header.html");
include("../customers/customer.php");
include("../customers/customerService.php");
include("../customers/customerRepository.php");
include("../database/db.php");
include("./editCustomerUI.php");


if (isset($_POST["editBtn"])) {
    if (
        !empty($_POST["username"]) &&
        !empty($_POST["phone"]) && !empty($_POST["birthdate"]) &&
        !empty($_POST["address"])
    ) {
        $customerID = $_SESSION["editCustomerID"];
        echo $customerID;
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
        echo "All Filled ";


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
                header("location: ./customerTable.php");
            }
        }
    } else {
        echo "Some Fields are empty!";
    }
}
