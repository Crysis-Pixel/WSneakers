<?php
    include("./database/db.php");
    include("header.html");
    include("./customers/customer.php");
    include("./customers/customerService.php");
    include("./customers/customerRepository.php");
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h2>Home Page</h2>
    <a href="login.php">Login/Sign Up</a> <br><br>
</head>
<body>
    <a href="itempage.php">Item1</a>&nbsp&nbsp&nbsp &nbsp
    <a href="itempage.php">Item2</a> &nbsp&nbsp&nbsp&nbsp
    <a href="itempage.php">Item3</a> &nbsp&nbsp&nbsp&nbsp
    <a href="itempage.php">Item4</a> &nbsp&nbsp&nbsp&nbsp <br><br>
</body>
</html>


<?php
    $customer = Customer::create()
        ->setUsername("Crysis5")
        ->setPassword("543")
        ->setAddress("OK")
        ->setPhone("123456");

        $_SESSION["username"] = "jim";
            $_SESSION["password"] = "ok";

            echo $_SESSION["username"] . "<br>";
            echo $_SESSION["password"] . "<br>";

        echo $customer->getUsername();
?>