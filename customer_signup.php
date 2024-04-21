<?php
include("header.html");
include("./database/db.php");
include("./customers/customer.php");
include("./customers/customerService.php");
include("./customers/customerRepository.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <h1 class="h1">Customers Sign up Page</h1>
  <link rel="stylesheet" href="customer_signup.css">
</head>

<body class="body">
  <form action="" method="post">

    <div class="username">
      <label>Username: </label>
      <input type="text" name="username" placeholder="Username"><br><br>
    </div>
    <div class="password">
      <label>Password: </label>
      <input type="password" name="password" placeholder="Password"><br><br>
    </div>
    <div class="phone">
      <label>Phone Number: </label>
      <input type="text" name="phone" placeholder="Phone Number"><br><br>
    </div>
    <div class="birthdate">
      <label>Birthdate: </label>
      <input type="text" name="birthdate" placeholder="Birthdate"><br><br>
    </div>
    <div class="address">
      <label>Address: </label>
      <input type="text" name="address" placeholder="Address"><br><br>
    </div>
    <div>
      <input class="signupButton" type="submit" name="submit" value="Sign up">
    </div>
  </form>
</body>

</html>