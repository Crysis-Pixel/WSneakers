<?php
    include_once("./database/db.php");    
    include_once("header.html");
    include_once("index.html");
    include_once("./customers/customer.php");
    include_once("./customers/customerService.php");
    include_once("./customers/customerRepository.php");
    session_start();
    if(!empty($_SESSION["Username"]))
    {
        echo $_SESSION["Username"] . "<br>";
        echo $_SESSION["Password"];
    } else
    {
        echo "Logged Out";
    }

    
    $customer = Customer::create()
        ->setUsername("Crysis5")
        ->setPassword("543")
        ->setAddress("OK")
        ->setPhone("123456");

    if(isset($_POST["logoutBtn"]))
    {
        session_destroy();
        header("location: index.php");
    }

?>