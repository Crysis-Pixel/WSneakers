<?php
include("../header.html");
include("../database/db.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <h1 class="h1">Sellers Sign up Page</h1>
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
            <input class="signupButton" type="submit" name="submit" value="Sign up">
        </div>
    </form>
</body>

</html>

<?php
if (isset($_POST["submit"])) {
    if (empty($_POST["phone"]) || empty($_POST["username"]) || empty($_POST["password"])) {
        echo "Please fillup the sign up form";
    } else {
        $phone = $_POST["phone"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO seller (Phone, Username, Pwd) VALUES('$phone', '$username', '$hashedPassword')";

        $con = db::getInstance()->getConnection();

        mysqli_query($con, $sql);
        try {
            echo "User is now registered";
        } catch (mysqli_sql_exception) {
            echo "Could not register user";
        }
    }
}
?>