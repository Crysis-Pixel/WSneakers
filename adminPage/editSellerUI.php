<!DOCTYPE html>
<html lang="en">

<head>
  <h1 class="h1">Edit Seller</h1>
  <link rel="stylesheet" href="">
</head>

<body>
  <form action="./editSeller.php" method="post">
    <div>
      <label>Username: </label>
      <input type="text" name="username" value="<?php echo "Username"; ?>"><br><br>
    </div>
    <div>
      <label>Phone: </label>
      <input type="text" name="phone" value="<?php echo "Phone"; ?>"><br><br>
    </div>
    <div>
      <input class="editBtn" type="submit" name="editBtn" value="Edit">
    </div>
  </form>
</body>

</html>