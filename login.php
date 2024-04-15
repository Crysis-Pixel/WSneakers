<?php
    include("header.html");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <h1>Login Page</h1>
    <a href="index.php">Home Page <br><br></a>
</head>
    
<body>
    <form action = "login.php" method= "post">
        <label>Username: </label><br>
        <input type="text" name = "username"><br><br>
        <label>Password: </label><br>
        <input type="password" name = "password"><br><br>
        <input type="submit" name="loginBtn" value = "Login"><br>
        
    </form>
</body>
</html>
<?php  
    if (isset($_POST["loginBtn"])){
        $username = filter_input(INPUT_POST,"username",FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);
        if (!empty($username) && !empty($password)){
            $_SESSION["username"] = $username;
            $_SESSION["password"] = $password;

            echo $_SESSION["username"] . "<br>";
            echo $_SESSION["password"];

            header("location: index.php");
        } else {
            echo "username/pass incorrect";
        }
    }

    
    
?>