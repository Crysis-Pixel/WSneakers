<?php
    include("header.html");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <h1 class="h1">Login Page</h1>
    <a href="index.php" class="homePage">Home Page <br><br></a>
    <link href="login.css" rel="stylesheet" />
</head>
    
<body class="body">
    <article>
        <form action = "login.php" method= "post">
            <div class="username">
                <label>Username: </label>
                <input type="text" name = "username" placeholder = "Username"><br><br>
            </div>
            <div class="password">
                <label>Password: </label>
                <input type="password" name = "password" placeholder = "Password"><br><br>
            </div>
            <div>
                <input class="loginButton" type="submit" name="loginBtn" value = "Login">
            </div>
            <div class="sign-up">
                <label>New to WSneaker?</label>
                <a href="" class="sign-up-link">Create an account</a>
            </div>
        </form>
    </article>
</body>
</html>

<?php  
    if (isset($_POST["loginBtn"])){
        $username = filter_input(INPUT_POST,"username",FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);
        if (!empty($username) && !empty($password)){
            $_SESSION["username"] = $username;
            $_SESSION["password"] = $password;

            header("location: index.php");
        } else {
            echo "username/pass incorrect";
        }
    }
?>
