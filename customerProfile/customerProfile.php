<?php
include_once("../header.html");
include("./customerProfile.html");
session_start();

if (empty($_SESSION["Username"])) {
    header("location:../login.php");
    exit();
}

$username = $_SESSION["Username"];
$phone = $_SESSION["Phone"];
$birthdate = $_SESSION["Birthdate"];
$address = $_SESSION["Address"];
echo "Username: " . $username . "<br>";
echo "Phone Number: " . $phone . "<br>";
echo "Birthdate: " . $birthdate . "<br>";
echo "Address: " . $address . "<br>";
echo "<a href='../wishlist/displayWishlist.php'>View Wishlist</a>";
