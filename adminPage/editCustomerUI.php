<!DOCTYPE html>
<html lang="en">

<head>
  <h1 class="h1">Customers Sign up Page</h1>
  <link rel="stylesheet" href="./editCustomer.css">
</head>
<?php
  if (isset($_SESSION["CustomerID"]))
  {
    $customerOld = CustomerService::getInstance()->FindByCustomerID($_SESSION["CustomerID"]);
  }
?>
<body class="body">
  <form action="./editCustomer.php" method="post">
    <div class="username">
      <label>Username: </label>
      <input type="text" name="username" value="<?php echo $customerOld->getUsername();?>"><br><br>
    </div>
    <div class="password">
      <label>Password: </label>
      <input type="password" name="password" value= ""><br><br>
    </div>
    <div class="phone">
      <label>Phone Number: </label>
      <input type="text" name="phone" value="<?php echo $customerOld->getPhone();?>"><br><br>
    </div>
    <div class="birthdate">
      <label>Birthdate: </label>
      <input type="text" name="birthdate" value="<?php echo $customerOld->getBirthdate();?>"><br><br>
    </div>
    <div class="address">
      <label>Address: </label>
      <input type="text" name="address" value="<?php echo $customerOld->getAddress();?>"><br><br>
    </div>
    <div>
      <input class="editBtn" type="submit" name="editBtn" value="Edit">
    </div>
  </form>
</body>

</html>