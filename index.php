<?php
    include("./database/db.php");
    include("header.html");
    include("./customers/customer.php");
    include("./customers/customerService.php");
    include("./customers/customerRepository.php");
    session_start();
    if(!empty($_SESSION["Username"]))
    {
        echo $_SESSION["Username"] . "<br>";
        echo $_SESSION["Password"];
    } else
    {
        echo "Logged Out";
    }

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
    <form action="index.php" method="post">
        <input class="logoutBtn" type="submit" name="logoutBtn" value="Logout">
    </form>
</body>
</html>


<?php
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