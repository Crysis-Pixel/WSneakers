<?php
include("header.html");
include("./database/db.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <h1 class="h1">Sign up Page</h1>
    <link rel="stylesheet" href="sellers_signup.css">
</head>

<body class="body">
    <form action="sellers_signup.php" method="post">

        <div class="phone">
            <label>Phone Number: </label>
            <input type="text" name="phone" placeholder="Phone Number"><br><br>
        </div>

        <div class="username">
            <label>Username: </label>
            <input type="text" name="username" placeholder="Username"><br><br>
        </div>

        <div class="password">
            <label>Password: </label>
            <input type="password" name="password" placeholder="Password"><br><br>
        </div>

        <div>
            <input class="signupButton" type="submit" name="signupBtn" value="Sign up">
        </div>

    </form>
</body>

</html>