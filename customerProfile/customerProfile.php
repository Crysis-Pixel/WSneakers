<?php
    include_once("../header.html");
    include("./customerProfile.html");
    session_start();

    $username = $_SESSION["Username"];
    $phone = $_SESSION["Phone"];
    $birthdate = $_SESSION["Birthdate"];
    $address = $_SESSION["Address"];
    echo "Username: " . $username . "<br>";
    echo "Phone Number: " . $phone . "<br>";
    echo "Birthdate: " . $birthdate . "<br>";
    echo "Address: " . $address . "<br>";
?>

<a></a>