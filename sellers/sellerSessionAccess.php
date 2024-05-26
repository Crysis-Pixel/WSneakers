<?php
if(!isset($_SESSION["UserType"]) || $_SESSION["UserType"] !== "Seller")
{
    // echo "No Access!<br>";
    // echo "Redirect to ";
    // echo '<a href="http://localhost/wsneakers/index.php">Home Page</a>';
    // echo "/ ";
    // echo '<a href="http://localhost/wsneakers/login.php">Login Page<br><br></a>';
    header("location: http://localhost/wsneakers/login.php");
    exit();
}
?>